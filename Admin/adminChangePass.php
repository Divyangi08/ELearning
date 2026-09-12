<?php
// ================= ERROR REPORTING =================
error_reporting(E_ALL);
ini_set('display_errors', 1);

// ================= SESSION =================
if(session_id() == ''){
  session_start();
}

define('TITLE', 'Change Password');

include('./adminInclude/header.php'); 
include('../dbConnection.php');

// ✅ SAFE SESSION VALUE
$adminEmail = $_SESSION['adminLogEmail'] ?? '';
$passmsg = "";

// ================= UPDATE PASSWORD =================
if(isset($_POST['adminPassUpdatebtn'])){

  if(empty($_POST['adminPass'])){
    $passmsg = "<div class='alert alert-warning text-center'>Enter new password</div>";
  } else {

    $adminPass = trim($_POST['adminPass']);

    // 🔐 HASH PASSWORD
    $hashedPass = password_hash($adminPass, PASSWORD_DEFAULT);

    // ✅ SECURE QUERY
    $stmt = $conn->prepare("UPDATE admin SET admin_pass = ? WHERE admin_email = ?");
    $stmt->bind_param("ss", $hashedPass, $adminEmail);

    if($stmt->execute()){
      $passmsg = "<div class='alert alert-success text-center'>Password updated successfully</div>";
    } else {
      $passmsg = "<div class='alert alert-danger text-center'>Update failed</div>";
    }

    $stmt->close();
  }
}
?>

<style>
.main-content {
  margin-left: 230px;
  margin-top: 70px;
  padding: 20px 25px;
  background: #f5f7fb;
  min-height: 100vh;
}

.card-box {
  background: #fff;
  padding: 25px;
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.05);
  max-width: 500px;
  margin: auto;
}

body, label, h1, h2, h3, h4 {
  color: #111 !important;
}

.form-control {
  color: #111 !important;
}

.btn-primary {
  background: #4f46e5;
  border: none;
}

.btn-light {
  color: #111;
}

.page-title {
  text-align: center;
  margin-bottom: 15px;
  font-weight: 600;
}
</style>

<div class="main-content">

  <div class="card-box">

    <h4 class="page-title">Change Password</h4>

    <form method="POST">

      <!-- EMAIL -->
      <div class="form-group">
        <label>Email</label>
        <input 
          type="email" 
          class="form-control" 
          value="<?php echo htmlspecialchars($adminEmail); ?>" 
          readonly
        >
      </div>

      <!-- PASSWORD -->
      <div class="form-group">
        <label>New Password</label>
        <input 
          type="password" 
          class="form-control" 
          name="adminPass" 
          placeholder="Enter new password" 
          required
        >
      </div>

      <!-- BUTTON -->
      <div class="text-center mt-3">
        <button type="submit" class="btn btn-primary" name="adminPassUpdatebtn">
          Update Password
        </button>
        <button type="reset" class="btn btn-light ml-2">
          Reset
        </button>
      </div>

      <!-- MESSAGE -->
      <div class="mt-3">
        <?php echo $passmsg; ?>
      </div>

    </form>

  </div>

</div>

<?php include('./adminInclude/footer.php'); ?>