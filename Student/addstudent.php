<?php 
if (session_id() == '') {
  session_start();
}

define('TITLE', 'Add Student');
define('PAGE', 'addstudent');

include('./stuInclude/header.php');
include_once('../dbConnection.php');

$msg = "";

// ===== ADD STUDENT =====
if (isset($_POST['stusignup'])) {

  $stuname = trim($_POST['stuname']);
  $stuemail = trim($_POST['stuemail']);
  $stupass = trim($_POST['stupass']);

  if ($stuname == "" || $stuemail == "" || $stupass == "") {
    $msg = "<div class='alert alert-warning text-center'>All fields required</div>";
  } else {

    // Check if email already exists
    $check = $conn->prepare("SELECT stu_email FROM student WHERE stu_email=?");
    $check->bind_param("s", $stuemail);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
      $msg = "<div class='alert alert-danger text-center'>Email already exists</div>";
    } else {

      // Insert student
      $stmt = $conn->prepare("INSERT INTO student(stu_name, stu_email, stu_pass) VALUES (?, ?, ?)");
      $stmt->bind_param("sss", $stuname, $stuemail, $stupass);

      if ($stmt->execute()) {
        $msg = "<div class='alert alert-success text-center'>Student Added Successfully</div>";
      } else {
        $msg = "<div class='alert alert-danger text-center'>Error adding student</div>";
      }
    }
  }
}
?>

<!-- ===== MAIN CONTENT ===== -->
<div class="main-content">

  <div class="card shadow" style="max-width:450px; margin:auto; margin-top:80px; padding:25px; border-radius:12px;">

    <h4 class="text-center mb-3">➕ Add Student</h4>

    <?php if(!empty($msg)) echo $msg; ?>

    <form method="POST">

      <div class="form-group mb-3">
        <label>Name</label>
        <input type="text" name="stuname" class="form-control" required>
      </div>

      <div class="form-group mb-3">
        <label>Email</label>
        <input type="email" name="stuemail" class="form-control" required>
      </div>

      <div class="form-group mb-3">
        <label>Password</label>
        <input type="password" name="stupass" class="form-control" required>
      </div>

      <button type="submit" name="stusignup" class="btn btn-primary w-100">
        Add Student
      </button>

    </form>

  </div>

</div>

<?php include('./stuInclude/footer.php'); ?>