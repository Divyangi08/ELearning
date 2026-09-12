<?php 
// ===== START SESSION =====
if (session_id() == '') {
  session_start();
}

define('TITLE', 'My Course');
define('PAGE', 'mycourse');

include('./stuInclude/header.php'); 
include_once('../dbConnection.php');

// ===== LOGIN CHECK =====
if (!isset($_SESSION['stuLogEmail'])) {
  echo "Session missing. Please login.";
  exit();
}

$stuLogEmail = $_SESSION['stuLogEmail'];
?>

<style>
.course-card {
  border-radius: 15px;
  overflow: hidden;
  transition: 0.3s;
  border: none;
}
.course-card:hover {
  transform: translateY(-5px);
}
.course-img {
  height: 180px;
  object-fit: cover;
}
</style>

<div class="container-fluid">

  <h3 class="mb-4">📚 My Courses</h3>

  <div class="row">

<?php

// ===== GET COURSES =====
$sql = "SELECT * 
        FROM courseorder 
        JOIN course ON course.course_id = courseorder.course_id 
        WHERE courseorder.stu_email = '$stuLogEmail'";

$result = $conn->query($sql);

if (!$result) {
  die("SQL Error: " . $conn->error);
}

if ($result->num_rows > 0) {

  while ($row = $result->fetch_assoc()) {

    $courseId = $row['course_id'];
    $img = !empty($row['course_img']) ? $row['course_img'] : '../image/default-course.jpg';

    // ===== SIMPLE PROGRESS LOGIC (NO TABLE NEEDED) =====
    // based on course_id (for demo)
    if ($courseId % 3 == 0) {
        $progress = 100;
    } elseif ($courseId % 2 == 0) {
        $progress = 60;
    } else {
        $progress = 20;
    }

    // ===== STATUS =====
    if ($progress == 100) {
        $status = "Completed";
        $badge = "success";
    } elseif ($progress >= 50) {
        $status = "In Progress";
        $badge = "warning";
    } else {
        $status = "Not Started";
        $badge = "secondary";
    }
?>

    <div class="col-md-4 mb-4">
      <div class="card course-card shadow-sm">

        <img src="<?php echo $img; ?>" class="course-img">

        <div class="card-body">

          <h5 class="fw-bold"><?php echo $row['course_name']; ?></h5>

          <p class="text-muted">
            <?php echo substr($row['course_desc'],0,70); ?>...
          </p>

          <span class="badge bg-<?php echo $badge; ?> mb-2">
            <?php echo $status; ?>
          </span>

          <div class="progress mb-2" style="height:8px;">
            <div class="progress-bar bg-<?php echo $badge; ?>" 
                 style="width:<?php echo $progress; ?>%">
            </div>
          </div>

          <small class="text-muted"><?php echo $progress; ?>% completed</small><br>

          <small class="text-muted">
            Instructor: <?php echo $row['course_author']; ?>
          </small><br>

          <strong class="text-primary">
            ₹<?php echo $row['course_price']; ?>
          </strong>

          <div class="mt-3">
            <a href="watchcourse.php?course_id=<?php echo $courseId; ?>" 
               class="btn btn-primary btn-sm w-100">
               Continue Learning
            </a>
          </div>

        </div>

      </div>
    </div>

<?php
  }

} else {
  echo "<div class='col-12'><div class='alert alert-info'>No courses found</div></div>";
}
?>

  </div>
</div>

</div>

<?php include('./stuInclude/footer.php'); ?>