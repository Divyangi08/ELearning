<?php 
// ================= ERROR REPORTING =================
error_reporting(E_ALL);
ini_set('display_errors', 1);

// ================= SESSION =================
if(session_id() == ''){
  session_start();
}

define('TITLE', 'Lessons');

// ================= INCLUDE =================
include('./adminInclude/header.php');
include('../dbConnection.php');
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

/* ===== HEADER ===== */
.page-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 15px;
  border-bottom: 1px solid #ddd;
  padding-bottom: 8px;
}

/* ===== CARD ===== */
.card-box {
  background: #fff;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.05);
  margin-bottom: 15px;
}

/* ===== TEXT ===== */
body, h1, h2, h3, h4, h5, p, label {
  color: #111 !important;
}

/* ===== TABLE ===== */
.table thead {
  background: #f1f3f5;
}

.table th, .table td {
  color: #111 !important;
  text-align: center;
}

/* ===== BUTTONS ===== */
.btn-info {
  background: #4f46e5;
  border: none;
}

.btn-danger {
  background: #ef4444;
  border: none;
}

.btn-success {
  background: #22c55e;
  border: none;
}
</style>

<!-- ================= MAIN ================= -->
<div class="main-content">

  <!-- HEADER -->
  <div class="page-header">
    <h4 class="m-0">Manage Lessons</h4>
  </div>

  <!-- SEARCH -->
  <div class="card-box">
    <form method="GET" class="d-flex align-items-center">
      <label class="mr-3 mb-0 font-weight-bold">Enter Course ID:</label>
      <input type="number" class="form-control mr-3" name="checkid" placeholder="Course ID" required>
      <button type="submit" class="btn btn-primary">Search</button>
    </form>
  </div>

<?php
// ================= SEARCH =================
if(isset($_GET['checkid'])){
  $course_id = (int) $_GET['checkid'];

  $sql = "SELECT * FROM course WHERE course_id = $course_id";
  $result = $conn->query($sql);

  if($result && $result->num_rows > 0){
    $course = $result->fetch_assoc();

    $_SESSION['course_id'] = $course['course_id'];
    $_SESSION['course_name'] = $course['course_name'];
?>

  <!-- COURSE INFO -->
  <div class="card-box text-center">
    <strong>Course ID:</strong> <?php echo $course['course_id']; ?> |
    <strong>Course Name:</strong> <?php echo $course['course_name']; ?>
  </div>

<?php
    $sql = "SELECT * FROM lesson WHERE course_id = $course_id";
    $lessons = $conn->query($sql);

    if($lessons && $lessons->num_rows > 0){
?>

  <!-- TABLE -->
  <div class="card-box">
    <div class="table-responsive">
      <table class="table table-bordered table-hover">
        <thead>
          <tr>
            <th>ID</th>
            <th>Lesson Name</th>
            <th>Lesson Link</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>

<?php while($row = $lessons->fetch_assoc()){ ?>
          <tr>
            <td><?php echo $row['lesson_id']; ?></td>
            <td><?php echo $row['lesson_name']; ?></td>
            <td>
              <a href="<?php echo $row['lesson_link']; ?>" target="_blank">View</a>
            </td>
            <td>

              <!-- EDIT -->
              <form action="editlesson.php" method="POST" class="d-inline">
                <input type="hidden" name="id" value="<?php echo $row['lesson_id']; ?>">
                <button class="btn btn-sm btn-info">Edit</button>
              </form>

              <!-- DELETE -->
              <form method="POST" class="d-inline" onsubmit="return confirm('Delete this lesson?');">
                <input type="hidden" name="id" value="<?php echo $row['lesson_id']; ?>">
                <button class="btn btn-sm btn-danger" name="delete">Delete</button>
              </form>

            </td>
          </tr>
<?php } ?>

        </tbody>
      </table>
    </div>
  </div>

<?php
    } else {
      echo "<div class='alert alert-warning text-center'>No lessons found</div>";
    }

  } else {
    echo "<div class='alert alert-danger text-center'>Invalid Course ID</div>";
  }
}

// ================= DELETE =================
if(isset($_POST['delete'])){
  $id = (int) $_POST['id'];

  $sql = "DELETE FROM lesson WHERE lesson_id = $id";
  if($conn->query($sql) === TRUE){
    echo "<script>location.reload();</script>";
  }
}
?>

  <!-- ADD BUTTON -->
  <?php if(isset($_SESSION['course_id'])){ ?>
  <div class="text-right mt-3">
    <a class="btn btn-success" href="addLesson.php">+ Add Lesson</a>
  </div>
  <?php } ?>

</div>

<?php include('./adminInclude/footer.php'); ?>