<?php
// ================= SESSION =================
if (session_id() == '') {
  session_start();
}

define('TITLE', 'Add Lesson');
include('./adminInclude/header.php');
include('../dbConnection.php');

// ================= SUBMIT =================
if (isset($_POST['lessonSubmitBtn'])) {

  $lesson_name = trim($_POST['lesson_name']);
  $lesson_desc = trim($_POST['lesson_desc']);
  $course_id   = trim($_POST['course_id']);
  $course_name = trim($_POST['course_name']);

  if (empty($lesson_name) || empty($lesson_desc) || empty($course_id) || empty($course_name)) {
    $msg = "<div class='alert alert-warning'>Fill all fields</div>";
  } else {

    $video_path = "";

    // FILE UPLOAD
    if (!empty($_FILES['lesson_link']['name'])) {
      $video_path = "../lessonvid/" . $_FILES['lesson_link']['name'];
      move_uploaded_file($_FILES['lesson_link']['tmp_name'], $video_path);
    }

    $sql = "INSERT INTO lesson (lesson_name, lesson_desc, lesson_link, course_id, course_name)
            VALUES ('$lesson_name','$lesson_desc','$video_path','$course_id','$course_name')";

    if ($conn->query($sql) === TRUE) {
      $msg = "<div class='alert alert-success'>Lesson Added Successfully</div>";
    } else {
      $msg = "<div class='alert alert-danger'>Error</div>";
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
  max-width: 700px;
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
  margin-bottom: 15px;
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

    <h4 class="page-title">Add New Lesson</h4>
    <p class="subtitle">Create a lesson for your course</p>

    <form method="POST" enctype="multipart/form-data">

      <div class="form-group">
        <label>Course ID</label>
        <input type="text" class="form-control" name="course_id">
      </div>

      <div class="form-group">
        <label>Course Name</label>
        <input type="text" class="form-control" name="course_name">
      </div>

      <div class="form-group">
        <label>Lesson Name *</label>
        <input type="text" class="form-control" name="lesson_name" required>
      </div>

      <div class="form-group">
        <label>Lesson Description *</label>
        <textarea class="form-control" name="lesson_desc" rows="4" required></textarea>
      </div>

      <div class="form-group">
        <label>Lesson Video</label>
        <input type="file" class="form-control-file" name="lesson_link">
      </div>

      <div class="text-center mt-3">
        <button type="submit" class="btn btn-primary" name="lessonSubmitBtn">Add Lesson</button>
        <a href="lessons.php" class="btn btn-light">Cancel</a>
      </div>

      <?php if (isset($msg)) echo $msg; ?>

    </form>

  </div>

</div>

<?php include('./adminInclude/footer.php'); ?>