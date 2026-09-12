<?php
// ================= ERROR REPORTING =================
error_reporting(E_ALL);
ini_set('display_errors', 1);

// ================= SESSION =================
if (session_id() == '') {
  session_start();
}

// ================= DB =================
include(__DIR__ . '/../dbConnection.php');

// ================= HEADER =================
include(__DIR__ . '/adminInclude/header.php');
?>

<style>
/* ===== LAYOUT ===== */
.main-content {
  margin-left: 230px;
  margin-top: 70px; /* FIX NAVBAR OVERLAP */
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
}

/* ===== TEXT ===== */
body, h1, h2, h3, h4, h5, p, label {
  color: #111 !important;
}

/* ===== TABLE ===== */
.table {
  background: #fff;
}

.table thead {
  background: #f1f3f5;
}

.table th, .table td {
  color: #111 !important;
}

/* ===== TABLE FIX ===== */
.table-responsive {
  overflow-x: auto;
}

table td, table th {
  white-space: nowrap;
}

/* ===== BUTTONS ===== */
.btn-info {
  background: #4f46e5;
  border: none;
  color: #fff;
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

<!-- ================= MAIN CONTENT ================= -->
<div class="main-content">

  <!-- HEADER -->
  <div class="page-header">
    <h4 class="m-0">List of Courses</h4>
    <a class="btn btn-success btn-sm" href="addCourse.php">+ Add Course</a>
  </div>

  <div class="card-box">

  <?php
  // ================= DELETE =================
  if(isset($_POST['delete']) && isset($_POST['id'])){
    $id = (int) $_POST['id'];

    $stmt = $conn->prepare("DELETE FROM course WHERE course_id = ?");
    
    if($stmt){
      $stmt->bind_param("i", $id);

      if($stmt->execute()){
        echo "<div class='alert alert-success'>Course Deleted Successfully</div>";
      } else {
        echo "<div class='alert alert-danger'>Delete Failed</div>";
      }

      $stmt->close();
    }
  }

  // ================= FETCH =================
  $sql = "SELECT * FROM course";
  $result = $conn->query($sql);

  if($result && $result->num_rows > 0){
  ?>

  <!-- TABLE -->
  <div class="table-responsive">
    <table class="table table-bordered table-hover w-100">
      <thead>
        <tr>
          <th style="width:10%">ID</th>
          <th style="width:40%">Course Name</th>
          <th style="width:25%">Author</th>
          <th style="width:25%">Action</th>
        </tr>
      </thead>
      <tbody>

      <?php while($row = $result->fetch_assoc()){ 
        $id = htmlspecialchars($row['course_id']);
        $name = htmlspecialchars($row['course_name']);
        $author = htmlspecialchars($row['course_author']);
      ?>

        <tr>
          <td><?php echo $id; ?></td>
          <td><?php echo $name; ?></td>
          <td><?php echo $author; ?></td>
          <td>

            <!-- EDIT -->
            <form action="editcourse.php" method="POST" class="d-inline">
              <input type="hidden" name="id" value="<?php echo $id; ?>">
              <button class="btn btn-sm btn-info">Edit</button>
            </form>

            <!-- DELETE -->
            <form method="POST" class="d-inline"
              onsubmit="return confirm('Are you sure you want to delete this course?');">
              <input type="hidden" name="id" value="<?php echo $id; ?>">
              <button class="btn btn-sm btn-danger" name="delete">Delete</button>
            </form>

          </td>
        </tr>

      <?php } ?>

      </tbody>
    </table>
  </div>

  <?php
  } else {
    echo "<div class='alert alert-warning'>No Courses Found</div>";
  }
  ?>

  </div>

</div>

<?php
include(__DIR__ . '/adminInclude/footer.php');
?>