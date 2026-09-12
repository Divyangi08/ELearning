<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// SESSION
if (session_id() == '') {
  session_start();
}

// DB
include('../dbConnection.php');
include('./adminInclude/header.php');

// ================= SUBMIT =================
if (isset($_POST['courseSubmitBtn'])) {

  $name = $_POST['course_name'];
  $desc = $_POST['course_desc'];
  $author = $_POST['course_author'];
  $duration = $_POST['course_duration'];
  $price = $_POST['course_price'];
  $oprice = $_POST['course_original_price'];

  if ($name == "" || $desc == "" || $author == "") {
    $msg = '<div class="alert alert-warning">Fill All Required Fields</div>';
  } else {

    $img = $_FILES['course_img']['name'];
    $img_tmp = $_FILES['course_img']['tmp_name'];
    $img_folder = "../image/courseimg/" . $img;

    move_uploaded_file($img_tmp, $img_folder);

    $sql = "INSERT INTO course 
    (course_name, course_desc, course_author, course_img, course_duration, course_price, course_original_price)
    VALUES ('$name','$desc','$author','$img_folder','$duration','$price','$oprice')";

    if ($conn->query($sql) == TRUE) {
      $msg = '<div class="alert alert-success">Course Added Successfully</div>';
    } else {
      $msg = '<div class="alert alert-danger">Unable to Add Course</div>';
    }
  }
}
?>

<style>
/* ===== LAYOUT FIX ===== */
.main-content {
  margin-left: 230px;
  padding: 30px;
  background: #f5f7fb;
  min-height: 100vh;
}

/* ===== CARD ===== */
.card-box {
  background: #ffffff;
  padding: 25px;
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

/* ===== TEXT (FORCE BLACK) ===== */
body, label, h1, h2, h3, h4, h5, p {
  color: #111 !important;
}

.form-control {
  color: #111 !important;
  background: #fff !important;
}

::placeholder {
  color: #666 !important;
}

/* ===== INPUT ===== */
.form-control:focus {
  border-color: #4f46e5;
  box-shadow: 0 0 0 1px #4f46e5;
}

/* ===== BUTTONS ===== */
.btn-primary {
  background: #4f46e5;
  border: none;
  color: #fff;
}

.btn-primary:hover {
  background: #4338ca;
}

.btn-light {
  color: #111 !important;
}

/* ===== TITLE ===== */
.page-title {
  font-weight: 600;
  margin-bottom: 20px;
  color: #111;
}
</style>

<!-- ================= UI ================= -->
<div class="main-content">

  <h4 class="page-title">Add New Course</h4>

  <div class="card-box">

    <form action="" method="POST" enctype="multipart/form-data">

      <div class="form-row">

        <div class="form-group col-md-6">
          <label>Course Name</label>
          <input type="text" class="form-control" name="course_name">
        </div>

        <div class="form-group col-md-6">
          <label>Author</label>
          <input type="text" class="form-control" name="course_author">
        </div>

      </div>

      <div class="form-group">
        <label>Description</label>
        <textarea class="form-control" name="course_desc"></textarea>
      </div>

      <div class="form-row">

        <div class="form-group col-md-4">
          <label>Duration</label>
          <input type="text" class="form-control" name="course_duration">
        </div>

        <div class="form-group col-md-4">
          <label>Original Price</label>
          <input type="number" class="form-control" name="course_original_price">
        </div>

        <div class="form-group col-md-4">
          <label>Selling Price</label>
          <input type="number" class="form-control" name="course_price">
        </div>

      </div>

      <div class="form-group">
        <label>Course Image</label>
        <input type="file" class="form-control-file" name="course_img">
      </div>

      <div class="text-center">
        <button type="submit" class="btn btn-primary" name="courseSubmitBtn">
          Add Course
        </button>
        <a href="courses.php" class="btn btn-light">Cancel</a>
      </div>

      <?php if(isset($msg)) echo $msg; ?>

    </form>

  </div>

</div>

<?php
include('./adminInclude/footer.php');
?>