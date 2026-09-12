<?php
// SESSION
if (session_id() == '') {
  session_start();
}

define('TITLE', 'Add Student');
include('./adminInclude/header.php');
include('../dbConnection.php');

// ================= SUBMIT =================
if (isset($_POST['newStuSubmitBtn'])) {

  $name  = trim($_POST['stu_name']);
  $email = trim($_POST['stu_email']);
  $pass  = trim($_POST['stu_pass']);
  $occ   = trim($_POST['stu_occ']);

  if (empty($name) || empty($email) || empty($pass) || empty($occ)) {
    $msg = "<div class='alert alert-warning'>Fill all fields</div>";
  } else {

    $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO student (stu_name, stu_email, stu_pass, stu_occ) VALUES (?, ?, ?, ?)");

    if ($stmt) {
      $stmt->bind_param("ssss", $name, $email, $hashed_pass, $occ);

      if ($stmt->execute()) {
        $msg = "<div class='alert alert-success'>Student Added Successfully</div>";
      } else {
        $msg = "<div class='alert alert-danger'>Database Error</div>";
      }

      $stmt->close();
    }
  }
}
?>

<style>
/* ===== LAYOUT ===== */
.main-content {
  margin-left: 230px;
  margin-top: 70px;
  padding: 20px 25px;
  background: #f5f7fb;
  min-height: 100vh;
}

/* ===== CARD ===== */
.card-box {
  background: #fff;
  padding: 25px;
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.05);
  max-width: 600px;
  margin: auto;
}

/* ===== TEXT ===== */
body, label, h1, h2, h3, h4 {
  color: #111 !important;
}

/* ===== INPUT ===== */
.form-control {
  color: #111 !important;
}

/* ===== BUTTON ===== */
.btn-primary {
  background: #4f46e5;
  border: none;
}

.btn-light {
  color: #111;
}

/* ===== TITLE ===== */
.page-title {
  text-align: center;
  margin-bottom: 10px;
  font-weight: 600;
}

.subtitle {
  text-align: center;
  color: #666;
  margin-bottom: 20px;
}
</style>

<!-- ================= UI ================= -->
<div class="main-content">

  <div class="card-box">

    <h4 class="page-title">Add New Student</h4>
    <p class="subtitle">Create a new student account</p>

    <form method="POST">

      <div class="form-group">
        <label>Name *</label>
        <input type="text" class="form-control" name="stu_name" required>
      </div>

      <div class="form-group">
        <label>Email *</label>
        <input type="email" class="form-control" name="stu_email" required>
      </div>

      <div class="form-group">
        <label>Password *</label>
        <input type="password" class="form-control" name="stu_pass" required>
      </div>

      <div class="form-group">
        <label>Occupation *</label>
        <input type="text" class="form-control" name="stu_occ" required>
      </div>

      <div class="text-center mt-3">
        <button type="submit" class="btn btn-primary" name="newStuSubmitBtn">Add Student</button>
        <a href="students.php" class="btn btn-light">Cancel</a>
      </div>

      <?php if (isset($msg)) echo $msg; ?>

    </form>

  </div>

</div>

<?php include('./adminInclude/footer.php'); ?>