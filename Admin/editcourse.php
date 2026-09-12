<?php 
// ================= SESSION =================
if (session_id() == '') {
  session_start();
}

define('TITLE', 'Edit Course');
include('./adminInclude/header.php'); 
include('../dbConnection.php');

// ================= FETCH DATA =================
if(isset($_REQUEST['id'])){
  $id = (int)$_REQUEST['id'];
  $sql = "SELECT * FROM course WHERE course_id = $id";
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
} else {
  $row = array();
}

// ================= UPDATE =================
if(isset($_REQUEST['requpdate'])){

  if($_REQUEST['course_name'] == "" || $_REQUEST['course_desc'] == "" || $_REQUEST['course_author'] == ""){
    
    $msg = '<div class="alert alert-warning">Fill All Fields</div>';

  } else {

    $cid = $_REQUEST['course_id'];
    $cname = $_REQUEST['course_name'];
    $cdesc = $_REQUEST['course_desc'];
    $cauthor = $_REQUEST['course_author'];
    $cduration = $_REQUEST['course_duration'];
    $cprice = $_REQUEST['course_price'];
    $coriginalprice = $_REQUEST['course_original_price'];

    // IMAGE
    $cimg = $_FILES['course_img']['name'];

    if(!empty($cimg)){
      $img_folder = "../image/courseimg/" . $cimg;
      move_uploaded_file($_FILES['course_img']['tmp_name'], $img_folder);
    } else {
      $img_folder = $_REQUEST['old_img'];
    }

    $sql = "UPDATE course SET 
      course_name='$cname',
      course_desc='$cdesc',
      course_author='$cauthor',
      course_duration='$cduration',
      course_price='$cprice',
      course_original_price='$coriginalprice',
      course_img='$img_folder'
      WHERE course_id='$cid'";

    if($conn->query($sql) == TRUE){
      $msg = '<div class="alert alert-success">Updated Successfully</div>';
    } else {
      $msg = '<div class="alert alert-danger">Unable to Update</div>';
    }
  }
}
?>

<style>
body {
  background: #f4f6f9;
  font-family: 'Segoe UI', sans-serif;
}

.main-content {
  margin-left: 230px;
  padding: 40px;
}

.card-box {
  background: #ffffff;
  padding: 30px;
  border-radius: 12px;
  box-shadow: 0 6px 18px rgba(0,0,0,0.08);
}

.page-title {
  font-weight: 600;
  font-size: 20px;
  margin-bottom: 20px;
  color: #222;
}

label {
  font-weight: 500;
  color: #222;
  margin-bottom: 5px;
  display: block;
}

.form-control {
  background: #ffffff !important;
  border: 1px solid #ccc !important;
  border-radius: 6px;
  padding: 10px;
  color: #111 !important;
  margin-bottom: 15px;
}

textarea.form-control {
  min-height: 100px;
}

.form-control:focus {
  border-color: #4f46e5 !important;
  box-shadow: 0 0 0 2px rgba(79,70,229,0.15);
}

.btn-primary {
  background: #4f46e5;
  border: none;
  padding: 8px 18px;
  border-radius: 6px;
}

.btn-primary:hover {
  background: #4338ca;
}

.btn-light {
  background: #e5e7eb;
  color: #111 !important;
  border-radius: 6px;
}

.img-thumbnail {
  max-width: 100px;
  border-radius: 6px;
  margin-bottom: 10px;
}
</style>

<!-- ================= UI ================= -->
<div class="main-content">

  <h4 class="page-title">Edit Course</h4>

  <div class="card-box">

    <form action="" method="POST" enctype="multipart/form-data">

      <input type="hidden" name="old_img" value="<?php echo isset($row['course_img']) ? $row['course_img'] : ''; ?>">

      <label>Course ID</label>
      <input type="text" class="form-control" name="course_id"
        value="<?php echo isset($row['course_id']) ? $row['course_id'] : ''; ?>" readonly>

      <label>Course Name</label>
      <input type="text" class="form-control" name="course_name"
        value="<?php echo isset($row['course_name']) ? $row['course_name'] : ''; ?>">

      <label>Description</label>
      <textarea class="form-control" name="course_desc"><?php echo isset($row['course_desc']) ? $row['course_desc'] : ''; ?></textarea>

      <label>Author</label>
      <input type="text" class="form-control" name="course_author"
        value="<?php echo isset($row['course_author']) ? $row['course_author'] : ''; ?>">

      <label>Duration</label>
      <input type="text" class="form-control" name="course_duration"
        value="<?php echo isset($row['course_duration']) ? $row['course_duration'] : ''; ?>">

      <label>Original Price</label>
      <input type="text" class="form-control" name="course_original_price"
        value="<?php echo isset($row['course_original_price']) ? $row['course_original_price'] : ''; ?>">

      <label>Selling Price</label>
      <input type="text" class="form-control" name="course_price"
        value="<?php echo isset($row['course_price']) ? $row['course_price'] : ''; ?>">

      <label>Course Image</label>

      <?php if(isset($row['course_img']) && $row['course_img'] != ""){ ?>
        <img src="<?php echo $row['course_img']; ?>" class="img-thumbnail">
      <?php } ?>

      <input type="file" class="form-control" name="course_img">

      <br>

      <button type="submit" class="btn btn-primary" name="requpdate">Update</button>
      <a href="courses.php" class="btn btn-light">Cancel</a>

      <br><br>

      <?php if(isset($msg)) echo $msg; ?>

    </form>

  </div>

</div>

<?php include('./adminInclude/footer.php'); ?>