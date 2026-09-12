<?php 
// ================= SESSION =================
if(session_id() == ''){
  session_start();
}

define('TITLE', 'Edit Student');
include('./adminInclude/header.php'); 
include('../dbConnection.php');

// ================= AUTH =================
if (!isset($_SESSION['is_admin_login'])) {
  echo "<script> location.href='../index.php'; </script>";
  exit;
}

// ================= FETCH =================
if(isset($_REQUEST['id'])){
  $id = (int)$_REQUEST['id'];
  $sql = "SELECT * FROM student WHERE stu_id = $id";
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
} else {
  $row = array();
}

// ================= UPDATE =================
if(isset($_REQUEST['requpdate'])){

  if($_REQUEST['stu_name'] == "" || $_REQUEST['stu_email'] == "" || $_REQUEST['stu_pass'] == "" || $_REQUEST['stu_occ'] == ""){
    $msg = '<div class="alert alert-warning">Fill All Fields</div>';
  } else {

    $sid = $_REQUEST['stu_id'];
    $sname = $_REQUEST['stu_name'];
    $semail = $_REQUEST['stu_email'];
    $spass = $_REQUEST['stu_pass'];
    $socc = $_REQUEST['stu_occ'];

    $sql = "UPDATE student SET 
      stu_name='$sname',
      stu_email='$semail',
      stu_pass='$spass',
      stu_occ='$socc'
      WHERE stu_id='$sid'";

    if($conn->query($sql) == TRUE){
      $msg = '<div class="alert alert-success">Updated Successfully</div>';
    } else {
      $msg = '<div class="alert alert-danger">Update Failed</div>';
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
</style>

<!-- ================= UI ================= -->
<div class="main-content">

  <div class="card-box">

    <h4 class="page-title">Update Student</h4>

    <form method="POST">

      <div class="form-group">
        <label>ID</label>
        <input type="text" class="form-control" name="stu_id"
          value="<?php echo isset($row['stu_id']) ? $row['stu_id'] : ''; ?>" readonly>
      </div>

      <div class="form-group">
        <label>Name</label>
        <input type="text" class="form-control" name="stu_name"
          value="<?php echo isset($row['stu_name']) ? $row['stu_name'] : ''; ?>">
      </div>

      <div class="form-group">
        <label>Email</label>
        <input type="text" class="form-control" name="stu_email"
          value="<?php echo isset($row['stu_email']) ? $row['stu_email'] : ''; ?>">
      </div>

      <div class="form-group">
        <label>Password</label>
        <input type="text" class="form-control" name="stu_pass"
          value="<?php echo isset($row['stu_pass']) ? $row['stu_pass'] : ''; ?>">
      </div>

      <div class="form-group">
        <label>Occupation</label>
        <input type="text" class="form-control" name="stu_occ"
          value="<?php echo isset($row['stu_occ']) ? $row['stu_occ'] : ''; ?>">
      </div>

      <div class="text-center mt-3">
        <button type="submit" class="btn btn-primary" name="requpdate">Update</button>
        <a href="students.php" class="btn btn-light">Cancel</a>
      </div>

      <?php if(isset($msg)) echo $msg; ?>

    </form>

  </div>

</div>

<?php include('./adminInclude/footer.php'); ?>