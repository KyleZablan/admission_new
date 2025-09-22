<?php
require_once __DIR__ . '/../../database/dbconnection.php';
require_once __DIR__ . '/../../src/vendor/autoload.php';

$db = new Database();
$conn = $db->dbConnection();

$notice = "";

// Handle reply
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reply'], $_POST['message_id'])) {
    $reply = trim($_POST['reply']);
    $message_id = intval($_POST['message_id']);

    if ($reply !== '') {
        // Fetch the message before updating
        $stmt = $conn->prepare("SELECT * FROM contact_messages WHERE id=?");
        $stmt->execute([$message_id]);
        $msg = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($msg) {
            // Save reply in DB
            $stmt = $conn->prepare("UPDATE contact_messages SET reply=?, status='answered' WHERE id=?");
            $stmt->execute([$reply, $message_id]);

            // Send reply email
try {
    $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'tupadstarita@gmail.com';       // ✅ your Gmail
    $mail->Password   = 'mfxofqcdcdioxkvl';             // ✅ App password (no spaces)
    $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    $mail->setFrom('tupadstarita@gmail.com', 'TUPAD Admin'); // ✅ sender
    $mail->addAddress($msg['email'], $msg['name'] . ' ' . $msg['surname']);

    $mail->isHTML(true);
    $mail->Subject = "Re: " . $msg['subject'];
    $mail->Body    = "
        <p>Hello <strong>" . htmlspecialchars($msg['name']) . "</strong>,</p>
        <p>We received your message:</p>
        <blockquote>" . nl2br(htmlspecialchars($msg['message'])) . "</blockquote>
        <p><strong>Our Reply:</strong></p>
        <p>" . nl2br(htmlspecialchars($reply)) . "</p>
        <br>
        <hr>
        <p style='font-size:12px;color:gray;'>This is an automated response from TUPAD Admission System.</p>
    ";

    $mail->send();
    $notice = "✅ Reply sent successfully to " . htmlspecialchars($msg['email']);
} catch (\PHPMailer\PHPMailer\Exception $e) {
    $notice = "❌ Mailer Error: " . htmlspecialchars($mail->ErrorInfo);
}

        }
    }
}

// Fetch messages
$stmt = $conn->query("SELECT * FROM contact_messages ORDER BY created_at DESC");
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin - Contact Messages</title>
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
      <li class="sidebar-item">
        <a href="admin_messages.php" class="sidebar-link active">
          <i class="lni lni-comments"></i>
          <span>Admin Message</span>
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
        <div class="dashboard-header">
          <h2>📩 Contact Messages</h2>
        </div>

        <!-- Notices -->
        <?php if (!empty($notice)): ?>
          <div class="alert <?= strpos($notice, '✅') !== false ? 'alert-success' : 'alert-danger' ?>">
            <?= $notice ?>
          </div>
        <?php endif; ?>

        <!-- Messages -->
        <?php if (!empty($messages)): ?>
          <?php foreach ($messages as $m): ?>
            <div class="card mb-3 shadow-sm">
              <div class="card-body">
                <h5 class="card-title">
                  <?= htmlspecialchars($m['name'] . ' ' . $m['surname']) ?>
                  <small class="text-muted">(<?= htmlspecialchars($m['email']) ?>)</small>
                </h5>
                <p><strong>Subject:</strong> <?= htmlspecialchars($m['subject']) ?></p>
                <p><?= nl2br(htmlspecialchars($m['message'])) ?></p>
                <p><strong>Status:</strong> 
                  <?php if ($m['status'] === 'pending'): ?>
                    <span class="badge bg-danger">Pending</span>
                  <?php else: ?>
                    <span class="badge bg-success">Answered</span>
                  <?php endif; ?>
                </p>

                <?php if ($m['status'] === 'pending'): ?>
                  <form method="POST" class="mt-3">
                    <input type="hidden" name="message_id" value="<?= $m['id'] ?>">
                    <textarea name="reply" class="form-control mb-2" placeholder="Write your reply..."></textarea>
                    <button type="submit" class="btn btn-primary">Send Reply</button>
                  </form>
                <?php else: ?>
                  <div class="alert alert-success mt-2">
                    <strong>Reply Sent:</strong><br><?= nl2br(htmlspecialchars($m['reply'])) ?>
                  </div>
                <?php endif; ?>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p>No messages found.</p>
        <?php endif; ?>
      </div>
    </main>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="../../src/js/show.js"></script>
</body>
</html>
