<?php
$file = __DIR__ . '/../../database/dbconnection.php';
if (!file_exists($file)) {
    die("DB connection file not found at: " . $file);
}
require_once $file;

// include deduplication engine
require_once __DIR__ . '/../admin/deduplication.php'; 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // 1. Create DB connection
    $db = new Database();
    $conn = $db->dbConnection();    

    // 2. Get form data
    $full_name = $_POST["full_name"];
    $address = $_POST["address"];
    $barangay = $_POST["barangay"];
    $birth_date = $_POST["birth_date"];
    $phone_number = $_POST["phone_number"];
    $employment_status = $_POST["employment_status"];
    $income_level = $_POST["income_level"];
    $income_amount = $_POST["income_amount"];

    // 3. Insert applicant (default status = Pending)
    $stmt = $conn->prepare("INSERT INTO tupad_applications 
        (full_name, address, barangay, birth_date, phone_number, employment_status, income_level, income_amount, created_at, status)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), 'Pending')");
    $stmt->execute([
        $full_name,
        $address,
        $barangay,
        $birth_date,
        $phone_number,
        $employment_status,
        $income_level,
        $income_amount
    ]);

    // 4. Get new applicant ID
    $newId = $conn->lastInsertId();

    // 5. Run deduplication check
    $engine = new DeduplicationEngine($conn, date("Y"));
    $result = $engine->analyzeAndLog(
        $newId,
        $full_name,
        $birth_date,
        $address,
        $barangay
    );

    // 6. Update the record with deduplication result
    if (isset($result['status'])) {
        $update = $conn->prepare("UPDATE tupad_applications SET status = ? WHERE id = ?");
        $update->execute([$result['status'], $newId]);
        $statusMsg = $result['status'];
    } else {
        $statusMsg = "Pending"; // fallback if no result
    }

    // 7. Show message
 echo "<script>
    alert('Application submitted with status: " . addslashes($statusMsg) . "');
    window.location.href = '/admission/dashboard/admin/admission.php';
</script>";

}
?>
