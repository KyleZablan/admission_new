<?php
// contact-us.php

// Bootstrap: DB connection and composer autoload
require_once __DIR__ . '/database/dbconnection.php';
require_once __DIR__ . '/src/vendor/autoload.php'; // adjust path if your autoload is elsewhere

// No 'use' statements here to avoid placement errors. We'll reference classes by fully-qualified names.
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>TUPAD Admission System</title>
  <link rel="stylesheet" href="src/css/contact-us.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>
  <div class="top-bar"></div>
  <header>
    <div class="header-container">
      <img src="src/img/logo-sta.png" alt="TUPAD Logo" class="logo" />
      <h1 class="header-title">TUPAD ADMISSION SYSTEM</h1>
    </div>
  </header>

  <nav>
    <a href="home.php">Home</a>
    <a href="about-us.php">About Us</a>
    <a href="contact-us.php" class="active">Contact Us</a>
    <a href="announcement.php">Announcement</a>
    <a href="login.php">Log In</a>
  </nav>

  <main>
    <section class="contact-section">
      <div class="contact-info">
        <div class="contact-location">
          <h3>Location</h3>
          <p>Municipal Hall Building, San Jose Street, Barangay San Jose, Sta. Rita, Pampanga, Philippines</p>
          <p>Office Hours:<br>Monday – Friday, 8:00 AM – 5:00 PM</p>
        </div>
        <div class="contact-map">
          <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3858.565741716421!2d120.61565407472058!3d14.996369684441008!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3396edb6408fd4b9%3A0x6052447cbcb0240d!2sMunicipal%20Hall%20of%20Santa%20Rita%2C%20Pampanga!5e0!3m2!1sen!2sph!4v1720322357485!5m2!1sen!2sph" 
            class="google-map"
            title="Location of Municipal Hall of Santa Rita, Pampanga"
            aria-label="Map of Municipal Hall location">
          </iframe>
        </div>
      </div>

      <div class="contact-form-wrapper">
        <h3>Contact Us</h3>
        <p>Need help or have questions? Contact us and let's make TUPAD services smarter, faster, and more accessible for Sta. Rita.</p>

        <form action="contact-us.php" method="POST" class="contact-form" novalidate>
          <input type="text" name="name" placeholder="Name" required>
          <input type="text" name="surname" placeholder="Surname" required>
          <input type="email" name="email" placeholder="Email" required>
          <input type="text" name="subject" placeholder="Subject" required>
          <textarea name="message" rows="5" placeholder="Message" required></textarea>
          <button type="submit" name="submit">Submit</button>
        </form>

        <?php
        // Process submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
            // Basic sanitization
            $name    = trim($_POST['name'] ?? '');
            $surname = trim($_POST['surname'] ?? '');
            $email   = trim($_POST['email'] ?? '');
            $subject = trim($_POST['subject'] ?? '');
            $message = trim($_POST['message'] ?? '');

            $errors = [];

            if ($name === '')    $errors[] = 'Name is required.';
            if ($surname === '') $errors[] = 'Surname is required.';
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required.';
            if ($subject === '') $errors[] = 'Subject is required.';
            if ($message === '') $errors[] = 'Message is required.';

            // If validation ok, save to DB
            if (empty($errors)) {
                try {
                    $db = new Database();
                    $conn = $db->dbConnection();
                    $stmt = $conn->prepare("INSERT INTO contact_messages (name, surname, email, subject, message) VALUES (?, ?, ?, ?, ?)");
                    $stmt->execute([$name, $surname, $email, $subject, $message]);
                } catch (PDOException $e) {
                    $errors[] = 'Database error: ' . htmlspecialchars($e->getMessage());
                }
            }

            // If DB saved ok, send email
            if (empty($errors)) {
                try {
                    $mail = new \PHPMailer\PHPMailer\PHPMailer(true); 
                    $mail->isSMTP();
                    $mail->Host       = 'smtp.gmail.com';
                    $mail->SMTPAuth   = true;
                    $mail->Username   = 'tupadstarita@gmail.com';     // ✅ your Gmail
                    $mail->Password   = 'mfxofqcdcdioxkvl';           // ✅ your Gmail App Password (no spaces!)
                    $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port       = 587;

                    // Must match your Gmail
                    $mail->setFrom('tupadstarita@gmail.com', 'TUPAD Contact');  
                    $mail->addAddress('tupadstarita@gmail.com', 'TUPAD Admin'); 

                    // User email for reply
                    $mail->addReplyTo($email, $name . ' ' . $surname);

                    $mail->isHTML(true);
                    $mail->Subject = 'Contact Form: ' . $subject;
                    $mail->Body    = "<h3>New Contact Message</h3>"
                                   . "<p><strong>Name:</strong> " . htmlspecialchars($name . ' ' . $surname) . "</p>"
                                   . "<p><strong>Email:</strong> " . htmlspecialchars($email) . "</p>"
                                   . "<p><strong>Message:</strong><br>" . nl2br(htmlspecialchars($message)) . "</p>";

                    $mail->send();
                    echo "<p style='color:green;'>✅ Message sent successfully.</p>";
                } catch (\PHPMailer\PHPMailer\Exception $e) {
                    echo "<p style='color:red;'>❌ Mailer Error: " . htmlspecialchars($e->getMessage()) . "</p>";
                } catch (Exception $e) {
                    echo "<p style='color:red;'>❌ Error: " . htmlspecialchars($e->getMessage()) . "</p>";
                }
            } else {
                foreach ($errors as $err) {
                    echo "<p style='color:red;'>❌ " . htmlspecialchars($err) . "</p>";
                }
            }
        }
        ?>
      </div>
    </section>
  </main>

  <footer>
    <div class="footer-content">
      <p class="footer-main">Smart TUPAD Admission System | Powered by Digital Innovation<br>Make TUPAD Admission Simple, Fair, and Fast</p>
      <div class="footer-links">
        <p>PESO SANTA RITA, PAMPANGA</p>
        <p>pesosantaritapamp.gov.ph</p>
      </div>
    </div>
    <script src="src/js/status.js"></script>
  </footer>
</body>
</html>
