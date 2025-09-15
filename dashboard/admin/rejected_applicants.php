<?php
require_once __DIR__ . "/../../database/dbconnection.php";

try {
    $db = new Database();
    $conn = $db->dbConnection();

    // Fetch only rejected applicants
    $sql = "
        SELECT id, full_name, address, birth_date, phone_number, status, created_at
        FROM tupad_applications
        WHERE status = 'Rejected'
        ORDER BY created_at DESC
    ";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $rejectedApplicants = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Rejected Applicants</title>
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
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
          <h2 class="section-title text-center">❌ Rejected Applicants</h2>

          <?php if (!empty($rejectedApplicants)): ?>
            <div class="table-responsive mt-4">
              <table class="table table-striped table-bordered">
                <thead class="table-dark">
                  <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Address</th>
                    <th>Birth Date</th>
                    <th>Phone Number</th>
                    <th>Status</th>
                    <th>Date Applied</th>
                  </tr>
                </thead>
                <tbody>
                <?php foreach ($rejectedApplicants as $row): ?>
                  <tr>
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td><?= htmlspecialchars($row['full_name']) ?></td>
                    <td><?= htmlspecialchars($row['address']) ?></td>
                    <td><?= htmlspecialchars($row['birth_date']) ?></td>
                    <td><?= htmlspecialchars($row['phone_number']) ?></td>
                    <td><span class="badge bg-danger"><?= htmlspecialchars($row['status']) ?></span></td>
                    <td><?= htmlspecialchars($row['created_at']) ?></td>
                  </tr>
                <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          <?php else: ?>
            <p class="text-center text-muted mt-4">No rejected applicants found.</p>
          <?php endif; ?>
        </section>
      </div>
    </main>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="../../src/js/show.js"></script>
</body>
</html>
