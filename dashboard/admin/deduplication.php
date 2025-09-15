<?php
class DeduplicationEngine {
    private $conn;
    private $year;
    private $weights = [
        "full_name_birthday" => 100,
        "full_name_barangay" => 70,
        "birthday_barangay"  => 60,
        "full_address"       => 80,
        "yearly_limit"       => 120
    ];

    public function __construct(PDO $conn, int $year) {
        $this->conn = $conn;
        $this->year = $year;
    }

    private function norm($v) {
        $v = strtoupper(trim($v));
        return preg_replace('/[^A-Z0-9 ]/', '', $v);
    }

    public function analyzeAndLog(
        int $newApplicantId,
        string $full_name,
        string $birth_date,
        string $address,
        string $barangay
    ): array {
        $nameN = $this->norm($full_name);
        $addrN = $this->norm($address);
        $brgyN = $this->norm($barangay);

        $score   = 0;
        $reasons = [];
        $detailedMatches = []; // store applicant_id => [reason list]

        $collect = function(string $sql, array $params): array {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_COLUMN);
        };

        // Rule 1: Full name + birthday
        $rows = $collect(
            "SELECT id FROM tupad_applications WHERE UPPER(full_name) = ? AND birth_date = ? AND id != ?",
            [$nameN, $birth_date, $newApplicantId]
        );
        foreach ($rows as $id) {
            $score += $this->weights["full_name_birthday"];
            $reason = "Same full name and birthday";
            $reasons[] = $reason;
            $detailedMatches[$id][] = $reason;
        }

        // Rule 2: Full name + barangay
        $rows = $collect(
            "SELECT id FROM tupad_applications WHERE UPPER(full_name) = ? AND UPPER(barangay) = ? AND id != ?",
            [$nameN, $brgyN, $newApplicantId]
        );
        foreach ($rows as $id) {
            $score += $this->weights["full_name_barangay"];
            $reason = "Same full name and barangay";
            $reasons[] = $reason;
            $detailedMatches[$id][] = $reason;
        }

        // Rule 3: Birthday + barangay
        $rows = $collect(
            "SELECT id FROM tupad_applications WHERE birth_date = ? AND UPPER(barangay) = ? AND id != ?",
            [$birth_date, $brgyN, $newApplicantId]
        );
        foreach ($rows as $id) {
            $score += $this->weights["birthday_barangay"];
            $reason = "Same birthday and barangay";
            $reasons[] = $reason;
            $detailedMatches[$id][] = $reason;
        }

        // Rule 4: Full address
        $rows = $collect(
            "SELECT id FROM tupad_applications WHERE UPPER(address) = ? AND id != ?",
            [$addrN, $newApplicantId]
        );
        foreach ($rows as $id) {
            $score += $this->weights["full_address"];
            $reason = "Same full address";
            $reasons[] = $reason;
            $detailedMatches[$id][] = $reason;
        }

        // Rule 5: Already applied this year
        $rows = $collect(
            "SELECT id FROM tupad_applications 
             WHERE UPPER(full_name) = ? 
               AND YEAR(created_at) = ? 
               AND id != ?",
            [$nameN, $this->year, $newApplicantId]
        );
        foreach ($rows as $id) {
            $score += $this->weights["yearly_limit"];
            $reason = "Already applied this year";
            $reasons[] = $reason;
            $detailedMatches[$id][] = $reason;
        }

        // Final status
        $status = 'Eligible';
        if ($score >= 100) $status = 'Duplicate';
        elseif ($score >= 60) $status = 'Possible Duplicate';

        // Save logs: each matched applicant with its own reasons
        if (!empty($detailedMatches)) {
            $log = $this->conn->prepare(
                "INSERT INTO deduplication_logs (new_applicant_id, matched_applicant_id, match_reason, score)
                 VALUES (?, ?, ?, ?)"
            );
            foreach ($detailedMatches as $matchedId => $reasonList) {
                $reasonText = implode(', ', $reasonList);
                $log->execute([$newApplicantId, $matchedId, $reasonText, $score]);
            }
        }

        return [
            'status'  => $status,
            'score'   => $score,
            'reasons' => $reasons,
            'matches' => $detailedMatches // ✅ applicant_id => reason(s)
        ];
    }
}
