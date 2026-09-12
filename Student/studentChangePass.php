<?php
// ===== START SESSION =====
if (session_id() == '') {
  session_start();
}

define('TITLE', 'Change Password');
define('PAGE', 'studentChangePass');

include('./stuInclude/header.php'); 
include_once('../dbConnection.php');

// ===== LOGIN CHECK =====
if (!isset($_SESSION['stuLogEmail'])) {
  echo "<script> location.href='../index.php'; </script>";
  exit();
}

$stuEmail = $_SESSION['stuLogEmail'];

// ===== UPDATE PASSWORD =====
if (isset($_POST['stuPassUpdateBtn'])) {

  if (empty($_POST['stuNewPass'])) {

    $passmsg = "<div class='alert alert-warning mt-3'>Please enter new password</div>";

  } else {

    $stuPass = $_POST['stuNewPass'];

    // OPTIONAL: minimum length check
    if (strlen($stuPass) < 4) {
      $passmsg = "<div class='alert alert-danger mt-3'>Password must be at least 4 characters</div>";
    } else {

      $sql = "UPDATE student SET stu_pass='$stuPass' WHERE stu_email='$stuEmail'";

      if ($conn->query($sql) == TRUE) {
        $passmsg = "<div class='alert alert-success mt-3'>Password updated successfully</div>";
      } else {
        $passmsg = "<div class='alert alert-danger mt-3'>Update failed</div>";
      }
    }
  }
}
?>

<!-- 🎨 UI START -->
<div class="container-fluid">

  <div class="row justify-content-center">

    <div class="col-md-6">

      <div class="card p-4 shadow-sm">

        <h4 class="mb-3">🔑 Change Password</h4>

        <form method="POST">

          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" 
                   value="<?php echo $stuEmail; ?>" readonly>
          </div>

          <div class="mb-3">
            <label class="form-label">New Password</label>
            <input type="password" 
                   class="form-control" 
                   name="stuNewPass" 
                   placeholder="Enter new password"
                   required>
          </div>

          <div class="d-flex gap-2">
            <button type="submit" 
                    class="btn btn-primary w-100" 
                    name="stuPassUpdateBtn">
              Update Password
            </button>

            <button type="reset" class="btn btn-secondary w-100">
              Reset
            </button>
          </div>

          <!-- MESSAGE -->
          <?php if(isset($passmsg)) echo $passmsg; ?>

        </form>

      </div>

    </div>

  </div>

</div>

</div> <!-- close content -->

<?php include('./stuInclude/footer.php'); ?>