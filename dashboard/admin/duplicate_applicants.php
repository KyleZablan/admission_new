<?php
require_once __DIR__ . "/../../database/dbconnection.php";

try {
    $db = new Database();
    $conn = $db->dbConnection();

    // Join deduplication logs with applicant full names
    $sql = "
        SELECT dl.id, dl.new_applicant_id, dl.matched_applicant_id, dl.match_reason, dl.score, dl.created_at,
               na.full_name AS new_name,
               ma.full_name AS matched_name
        FROM deduplication_logs dl
        JOIN tupad_applications na ON dl.new_applicant_id = na.id
        JOIN tupad_applications ma ON dl.matched_applicant_id = ma.id
        ORDER BY dl.created_at DESC
    ";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $duplicates = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Duplicate Applicants</title>
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="../../src/css/admin/index.css">
  <link rel="stylesheet" href="../../src/css/admission.css">
</head>

<body>
<div class="wrapper">
  <!-- Sidebar -->
  <aside id="sidebar">
    <div class="d-flex">
      <button class="toggle-btn" type="button" title="Toggle Sidebar" aria-label="Toggle Sidebar">
        <i class="lni lni-grid-alt" aria-hidden="true"></i>
      </button>
      <div class="sidebar-logo">
        <a href="#">Admission</a>
      </div>
    </div>
    <ul class="sidebar-nav">
      <li class="sidebar-item">
        <a href="applicants_list.php" class="sidebar-link active">
          <i class="lni lni-users"></i>
          <span>Applicants (Master List)</span>
        </a>
      </li>
      <li class="sidebar-item">
        <a href="duplicate_applicants.php" class="sidebar-link active">
          <i class="lni lni-warning"></i>
          <span>Duplicate Applicants</span>
        </a>
      </li>
      <li class="sidebar-item">
        <a href="eligible_applicants.php" class="sidebar-link active">
          <i class="lni lni-checkmark-circle"></i>
          <span>Eligible Applicants</span>
        </a>
      </li>
      <li class="sidebar-item">
        <a href="rejected_applicants.php" class="sidebar-link active">
          <i class="lni lni-close"></i>
          <span>Rejected Applicants</span>
        </a>
      </li>
      <li class="sidebar-item">
        <a href="pending_applicants.php" class="sidebar-link active">
          <i class="lni lni-hourglass"></i>
          <span>Pending Applicants</span>
        </a>
      </li>
      <li class="sidebar-item">
        <a href="application_history.php" class="sidebar-link active">
          <i class="lni lni-timer"></i>
          <span>Application History</span>
        </a>
      </li>
      <li class="sidebar-item">
        <a href="reports.php" class="sidebar-link active">
          <i class="lni lni-stats-up"></i>
          <span>Reports (Final List)</span>
        </a>
      </li>

      <!-- Back Button -->
      <li class="sidebar-item logout">
        <a href="admission.php" class="sidebar-link active">
          <i class="lni lni-arrow-left"></i>
          <span>Back to Services</span>
        </a>
      </li>
    </ul>
  </aside>

  <!-- Main Content -->
  <div class="main">
    <header>
      <div class="header-container">
        <h1 class="header-title">TUPAD ADMISSION SYSTEM</h1>
      </div>
    </header>

    <main class="content px-3 py-4">
      <div class="container-fluid">
        <section class="form-section">
          <h2 class="section-title text-center">🚨 Duplicate Applicants</h2>

          <?php if (!empty($duplicates)): ?>
            <div class="table-responsive mt-4">
              <table class="table table-striped table-bordered">
                <thead class="table-dark">
                  <tr>
                    <th>Log ID</th>
                    <th>New Applicant</th>
                    <th>Matched Applicant</th>
                    <th>Reason</th>
                    <th>Score</th>
                    <th>Date</th>
                  </tr>
                </thead>
                <tbody>
                <?php foreach ($duplicates as $row): ?>
                  <tr>
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td><?= htmlspecialchars($row['new_name']) ?> (ID: <?= $row['new_applicant_id'] ?>)</td>
                    <td><?= htmlspecialchars($row['matched_name']) ?> (ID: <?= $row['matched_applicant_id'] ?>)</td>
                    <td><?= htmlspecialchars($row['match_reason']) ?></td>
                    <td><?= htmlspecialchars($row['score']) ?></td>
                    <td><?= htmlspecialchars($row['created_at']) ?></td>
                  </tr>
                <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          <?php else: ?>
            <p class="text-center text-muted mt-4">No duplicate applicants found.</p>
          <?php endif; ?>
        </section>
      </div>
    </main>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
<script src="../../src/js/show.js"></script>
</body>
</html>
