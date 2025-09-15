<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admission Form</title>
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="../../src/css/admin/index.css"> <!-- Reusing sidebar css -->
  <link rel="stylesheet" href="../../src/css/admission.css"> <!-- Your admission form css -->
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
        <a href="applicants_list.php" class="sidebar-link">
          <i class="lni lni-users"></i>
          <span>Applicants (Master List)</span>
        </a>
      </li>
      <li class="sidebar-item">
        <a href="duplicate_applicants.php" class="sidebar-link">
          <i class="lni lni-warning"></i>
          <span>Duplicate Applicants</span>
        </a>
      </li>
      <li class="sidebar-item">
        <a href="eligible_applicants.php" class="sidebar-link">
          <i class="lni lni-checkmark-circle"></i>
          <span>Eligible Applicants</span>
        </a>
      </li>
      <li class="sidebar-item">
        <a href="rejected_applicants.php" class="sidebar-link">
          <i class="lni lni-close"></i>
          <span>Rejected Applicants</span>
        </a>
      </li>
      <li class="sidebar-item">
        <a href="pending_applicants.php" class="sidebar-link">
          <i class="lni lni-hourglass"></i>
          <span>Pending Applicants</span>
        </a>
      </li>
      <li class="sidebar-item">
        <a href="application_history.php" class="sidebar-link">
          <i class="lni lni-timer"></i>
          <span>Application History</span>
        </a>
      </li>
      <li class="sidebar-item">
        <a href="reports.php" class="sidebar-link">
          <i class="lni lni-stats-up"></i>
          <span>Reports (Final List)</span>
        </a>
      </li>

      <!-- Back Button -->
      <li class="sidebar-item logout">
        <a href="services.php" class="sidebar-link">
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
        <form class="admission-form" action="../admin/submit-application.php" method="POST" enctype="multipart/form-data">

          <!-- Contact Info -->
          <section class="form-section">
            <h2 class="section-title">Contact Information<span class="required">*</span></h2>
            <div class="form-group"><input type="text" name="full_name" placeholder="Enter your Name" required /></div>
            <div class="form-group"><input type="text" name="address" placeholder="Full Address" required /></div>
            <div class="form-row">
              <label for="filterBarangay" class="visually-hidden">Barangay</label>
              <select id="filterBarangay" name="barangay" class="form-select form-select-sm" required>
                <option value="">Select Barangay</option>
                <option value="Becuran">Becuran</option>
                <option value="Dila-dila">Dila-dila</option>
                <option value="San Agustin">San Agustin</option>
                <option value="San Basilio">San Basilio</option>
                <option value="San Isidro">San Isidro</option>
                <option value="San Jose">San Jose</option>
                <option value="San Juan">San Juan</option>
                <option value="San Matias">San Matias</option>
                <option value="Santa Monica">Santa Monica</option>
                <option value="San Vicente">San Vicente</option>
              </select>

              <div class="form-group"><input type="date" name="birth_date" placeholder="Date of Birth" required /></div>
            </div>
            <div class="form-group"><input type="tel" name="phone_number" placeholder="Phone No." required /></div>
          </section>

          <!-- Employment Status -->
          <section class="form-section">
            <h2 class="section-title">Employment Status<span class="required">*</span></h2>
            <div class="form-group">
              <select name="employment_status" required>
                <option value="" disabled selected>Employment Status</option>
                <option>Unemployed</option>
                <option>Underemployed</option>
                <option>Self-employed</option>
              </select>
            </div>
            <div class="form-group">
              <select name="income_level" required>
                <option value="" disabled selected>Income level*</option>
                <option>Below minimum wage</option>
                <option>Minimum wage</option>
                <option>Above minimum wage</option>
              </select>
            </div>
            <div class="form-group"><input type="text" name="income_amount" placeholder="Indicate the amount" required /></div>
          </section>

          <button type="submit" class="submit-btn">Submit</button>
        </form>
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
