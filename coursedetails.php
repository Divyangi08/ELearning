<?php
include('./dbConnection.php');
include('./mainInclude/header.php'); 
?>

<style>
body {
  background: #f8fafc;
  font-family: 'Poppins', sans-serif;
}

.course-card {
  background: #fff;
  border-radius: 15px;
  box-shadow: 0 10px 25px rgba(0,0,0,0.05);
}

.course-img {
  width: 100%;
  height: 250px;
  object-fit: cover;
}

.btn-buy {
  background: #2563eb;
  color: white;
  border: none;
  padding: 10px 20px;
  border-radius: 25px;
}

.btn-buy:hover {
  background: #1d4ed8;
}

.lesson-box {
  background: #fff;
  padding: 20px;
  border-radius: 12px;
  box-shadow: 0 10px 20px rgba(0,0,0,0.05);
}
</style>

<div class="container my-5">

<?php
if(isset($_GET['course_id'])){

  $course_id = intval($_GET['course_id']);
  $_SESSION['course_id'] = $course_id;

  $stmt = $conn->prepare("SELECT * FROM course WHERE course_id = ?");
  $stmt->bind_param("i", $course_id);
  $stmt->execute();
  $result = $stmt->get_result();

  if($result->num_rows > 0){ 
    $row = $result->fetch_assoc();

    $imgPath = !empty($row['course_img']) 
      ? str_replace('..', '.', $row['course_img']) 
      : 'assets/img/default.jpg';
?>

<!-- COURSE DETAILS -->
<div class="course-card p-4 mb-5">
  <div class="row align-items-center">

    <div class="col-md-5">
      <img src="<?php echo $imgPath; ?>" class="course-img rounded" alt="Course Image">
    </div>

    <div class="col-md-7 mt-3 mt-md-0">
      <h2><?php echo htmlspecialchars($row['course_name']); ?></h2>

      <p><?php echo htmlspecialchars($row['course_desc']); ?></p>

      <p><strong>Duration:</strong> 
        <?php echo htmlspecialchars($row['course_duration']); ?>
      </p>

      <div class="mb-3">
        <del>₹<?php echo htmlspecialchars($row['course_original_price']); ?></del>
        <h4 class="text-primary d-inline ms-2">
          ₹<?php echo htmlspecialchars($row['course_price']); ?>
        </h4>
      </div>

      <form action="studentRegistration.php" method="get">
        <input type="hidden" name="course_id" value="<?php echo $course_id; ?>">
        <button type="submit" class="btn-buy">Buy Now</button>
      </form>

    </div>

  </div>
</div>

<?php 
  } else {
    echo "<h5 class='text-danger'>Course not found</h5>";
  }
} else {
  echo "<h5 class='text-danger'>No course selected</h5>";
}
?>

<!-- LESSONS -->
<div class="lesson-box">
  <h4 class="mb-4">Course Lessons</h4>

<?php
if(isset($course_id)){

  $stmt = $conn->prepare("SELECT * FROM lesson WHERE course_id = ?");
  $stmt->bind_param("i", $course_id);
  $stmt->execute();
  $result = $stmt->get_result();

  if($result->num_rows > 0){
    $num = 0;

    echo '<table class="table table-hover">
          <thead class="table-light">
            <tr>
              <th>#</th>
              <th>Lesson Name</th>
            </tr>
          </thead><tbody>';

    while($row = $result->fetch_assoc()){
      $num++;
      echo "<tr>
              <td>$num</td>
              <td>".htmlspecialchars($row['lesson_name'])."</td>
            </tr>";
    }

    echo '</tbody></table>';

  } else {
    echo "<p class='text-muted'>No lessons available</p>";
  }
}
?>

</div>

</div>

<?php include('./mainInclude/footer.php'); ?>