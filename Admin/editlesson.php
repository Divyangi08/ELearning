<?php 
// ================= SESSION =================
if(session_id() == ''){
  session_start();
}

define('TITLE', 'Edit Lesson');
include('./adminInclude/header.php'); 
include('../dbConnection.php');

// ================= FETCH =================
if(isset($_REQUEST['id'])){
  $id = (int)$_REQUEST['id'];
  $sql = "SELECT * FROM lesson WHERE lesson_id = $id";
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
} else {
  $row = array();
}

// ================= UPDATE =================
if(isset($_REQUEST['requpdate'])){

  if($_REQUEST['lesson_name'] == "" || $_REQUEST['lesson_desc'] == ""){
    $msg = '<div class="alert alert-warning">Fill All Fields</div>';
  } else {

    $lid = $_REQUEST['lesson_id'];
    $lname = $_REQUEST['lesson_name'];
    $ldesc = $_REQUEST['lesson_desc'];

    $file = $_FILES['lesson_link']['name'];

    if(!empty($file)){
      $path = "../lessonvid/" . $file;
      move_uploaded_file($_FILES['lesson_link']['tmp_name'], $path);
    } else {
      $path = isset($row['lesson_link']) ? $row['lesson_link'] : '';
    }

    $sql = "UPDATE lesson SET 
      lesson_name='$lname',
      lesson_desc='$ldesc',
      lesson_link='$path'
      WHERE lesson_id='$lid'";

    if($conn->query($sql) == TRUE){
      $msg = '<div class="alert alert-success">Updated Successfully</div>';
    } else {
      $msg = '<div class="alert alert-danger">Update Failed</div>';
    }
  }
}
?>

<style>
body {
  background: #f4f6f9;
  font-family: 'Segoe UI', sans-serif;
}

/* Layout */
.main-content {
  margin-left: 230px;
  padding: 40px;
}

/* Card */
.card-box {
  background: #fff;
  padding: 30px;
  border-radius: 12px;
  box-shadow: 0 6px 18px rgba(0,0,0,0.08);
}

/* Title */
.page-title {
  font-size: 20px;
  font-weight: 600;
  margin-bottom: 20px;
  color: #222;
}

/* Labels */
label {
  font-weight: 500;
  color: #222;
  margin-bottom: 5px;
  display: block;
}

/* Inputs */
.form-control {
  background: #fff !important;
  border: 1px solid #ccc !important;
  border-radius: 6px;
  padding: 10px;
  margin-bottom: 15px;
  color: #111 !important;
}

/* Textarea */
textarea.form-control {
  min-height: 100px;
}

/* Focus */
.form-control:focus {
  border-color: #4f46e5 !important;
  box-shadow: 0 0 0 2px rgba(79,70,229,0.15);
}

/* Buttons */
.btn-primary {
  background: #4f46e5;
  border: none;
  border-radius: 6px;
  padding: 8px 18px;
}

.btn-primary:hover {
  background: #4338ca;
}

.btn-light {
  background: #e5e7eb;
  border-radius: 6px;
}

/* Video */
video {
  border-radius: 8px;
  margin-bottom: 10px;
}
</style>

<!-- ================= UI ================= -->
<div class="main-content">

  <h4 class="page-title">Edit Lesson</h4>

  <div class="card-box">

    <form method="POST" enctype="multipart/form-data">

      <label>Lesson ID</label>
      <input type="text" class="form-control" name="lesson_id"
        value="<?php echo $row['lesson_id'] ?? ''; ?>" readonly>

      <label>Lesson Name</label>
      <input type="text" class="form-control" name="lesson_name"
        value="<?php echo $row['lesson_name'] ?? ''; ?>">

      <label>Description</label>
      <textarea class="form-control" name="lesson_desc"><?php echo $row['lesson_desc'] ?? ''; ?></textarea>

      <label>Course ID</label>
      <input type="text" class="form-control" name="course_id"
        value="<?php echo $row['course_id'] ?? ''; ?>" readonly>

      <label>Course Name</label>
      <input type="text" class="form-control" name="course_name"
        value="<?php echo $row['course_name'] ?? ''; ?>" readonly>

      <label>Lesson Video</label>

      <?php if(isset($row['lesson_link']) && $row['lesson_link'] != ""){ ?>
        <video width="200" controls>
          <source src="<?php echo $row['lesson_link']; ?>">
        </video>
      <?php } ?>

      <input type="file" class="form-control" name="lesson_link">

      <br>

      <button type="submit" class="btn btn-primary" name="requpdate">Update</button>
      <a href="lessons.php" class="btn btn-light">Cancel</a>

      <br><br>

      <?php if(isset($msg)) echo $msg; ?>

    </form>

  </div>

</div>

<?php include('./adminInclude/footer.php'); ?>