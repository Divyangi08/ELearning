<?php 
// ================= SESSION =================
if(session_id() == ''){
  session_start();
}

define('TITLE', 'Edit Instructor');
include('./adminInclude/header.php'); 
include('../dbConnection.php');

// ================= FETCH =================
if(isset($_REQUEST['id'])){
  $id = (int)$_REQUEST['id'];
  $sql = "SELECT * FROM instructors WHERE instructor_id = $id";
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
} else {
  $row = array();
}

// ================= UPDATE =================
if(isset($_REQUEST['requpdate'])){

  if($_REQUEST['first_name'] == "" || $_REQUEST['last_name'] == ""){
    $msg = '<div class="alert alert-warning">Fill required fields</div>';
  } else {

    $id    = $_REQUEST['instructor_id'];
    $fname = $_REQUEST['first_name'];
    $lname = $_REQUEST['last_name'];
    $role  = $_REQUEST['role'];
    $desc  = $_REQUEST['description'];

    // IMAGE
    $imgName = $_FILES['image']['name'];
    $tmpName = $_FILES['image']['tmp_name'];

    if(!empty($imgName)){
      $imgPath = "../image/" . $imgName;
      move_uploaded_file($tmpName, $imgPath);
      $dbPath = "image/" . $imgName;
    } else {
      $dbPath = $row['image'];
    }

    $sql = "UPDATE instructors SET 
      first_name='$fname',
      last_name='$lname',
      role='$role',
      description='$desc',
      image='$dbPath'
      WHERE instructor_id='$id'";

    if($conn->query($sql) == TRUE){
      $msg = '<div class="alert alert-success">Updated Successfully</div>';
    } else {
      $msg = '<div class="alert alert-danger">Update Failed</div>';
    }
  }
}
?>

<!-- ================= STYLE ================= -->
<style>

/* ===== LAYOUT ===== */
.main-content {
  margin-left: 230px;
  margin-top: 70px;
  padding: 30px;
  background: #f5f7fb;
  min-height: 100vh;
}

/* ===== CARD ===== */
.card-box {
  background: #fff;
  padding: 30px;
  border-radius: 12px;
  box-shadow: 0 10px 25px rgba(0,0,0,0.05);
  max-width: 650px;
  margin: auto;
}

/* ===== TITLE ===== */
.page-title {
  text-align: center;
  font-weight: 600;
  margin-bottom: 20px;
  color: #111;
}

/* ===== LABEL ===== */
label {
  font-weight: 500;
  margin-bottom: 5px;
  color: #111 !important;
}

/* ===== INPUT ===== */
.form-control {
  border-radius: 8px;
  border: 1px solid #ddd;
  padding: 10px;
  transition: all 0.2s ease;
  color: #111 !important;
}

.form-control:focus {
  border-color: #4f46e5;
  box-shadow: 0 0 0 2px rgba(79,70,229,0.1);
}

/* ===== TEXTAREA ===== */
textarea.form-control {
  resize: none;
}

/* ===== IMAGE ===== */
.profile-img {
  width: 90px;
  height: 90px;
  border-radius: 50%;
  object-fit: cover;
  border: 3px solid #f1f3f5;
  margin-top: 10px;
}

/* ===== BUTTONS ===== */
.btn-primary {
  background: #4f46e5;
  border: none;
  border-radius: 8px;
  padding: 8px 20px;
}

.btn-primary:hover {
  background: #4338ca;
}

.btn-light {
  background: #f1f3f5;
  border-radius: 8px;
  padding: 8px 20px;
  color: #111;
}

/* ===== SPACING ===== */
.form-group {
  margin-bottom: 15px;
}

</style>

<!-- ================= UI ================= -->
<div class="main-content">

  <div class="card-box">

    <h4 class="page-title">Update Instructor</h4>

    <form method="POST" enctype="multipart/form-data">

      <div class="form-group">
        <label>ID</label>
        <input type="text" class="form-control" name="instructor_id"
          value="<?php echo isset($row['instructor_id']) ? $row['instructor_id'] : ''; ?>" readonly>
      </div>

      <div class="form-group">
        <label>First Name *</label>
        <input type="text" class="form-control" name="first_name"
          value="<?php echo isset($row['first_name']) ? $row['first_name'] : ''; ?>">
      </div>

      <div class="form-group">
        <label>Last Name *</label>
        <input type="text" class="form-control" name="last_name"
          value="<?php echo isset($row['last_name']) ? $row['last_name'] : ''; ?>">
      </div>

      <div class="form-group">
        <label>Role</label>
        <input type="text" class="form-control" name="role"
          value="<?php echo isset($row['role']) ? $row['role'] : ''; ?>">
      </div>

      <div class="form-group">
        <label>Description</label>
        <textarea class="form-control" name="description" rows="3"><?php echo isset($row['description']) ? $row['description'] : ''; ?></textarea>
      </div>

      <!-- IMAGE -->
      <div class="form-group text-center">
        <label>Current Image</label><br>
        <img src="../<?php echo $row['image']; ?>" class="profile-img">
      </div>

      <div class="form-group">
        <label>Change Image</label>
        <input type="file" class="form-control" name="image">
      </div>

      <!-- BUTTONS -->
      <div class="text-center mt-4">
        <button type="submit" class="btn btn-primary" name="requpdate">
          Update
        </button>
        <a href="instructors.php" class="btn btn-light ms-2">Cancel</a>
      </div>

      <?php if(isset($msg)) echo $msg; ?>

    </form>

  </div>

</div>

<?php include('./adminInclude/footer.php'); ?>