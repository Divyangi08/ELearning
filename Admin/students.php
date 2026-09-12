<?php 
// ================= ERROR REPORTING =================
error_reporting(E_ALL);
ini_set('display_errors', 1);

// ================= SESSION =================
if(session_id() == ''){
  session_start();
}

define('TITLE', 'Students');

// ================= INCLUDE =================
include('./adminInclude/header.php'); 
include('../dbConnection.php');
?>

<!-- ================= STYLE ================= -->
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
  padding: 0;
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

/* ===== TEXT ===== */
body, h1, h2, h3, h4, h5, p {
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
    <h4 class="m-0">Students Management</h4>
    <a href="addnewstudent.php" class="btn btn-success btn-sm">
      + Add Student
    </a>
  </div>

  <div class="card-box">

<?php
$sql = "SELECT * FROM student";
$result = $conn->query($sql);

if($result && $result->num_rows > 0){
?>

    <div class="table-responsive">
      <table class="table table-bordered table-hover mb-0">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Actions</th>
          </tr>
        </thead>

        <tbody>

<?php while($row = $result->fetch_assoc()){ ?>

          <tr>
            <td><?php echo $row["stu_id"]; ?></td>
            <td><?php echo $row["stu_name"]; ?></td>
            <td><?php echo $row["stu_email"]; ?></td>

            <td>

              <!-- EDIT -->
              <form action="editstudent.php" method="POST" class="d-inline">
                <input type="hidden" name="id" value="<?php echo $row["stu_id"]; ?>">
                <button class="btn btn-sm btn-info">Edit</button>
              </form>

              <!-- DELETE -->
              <form method="POST" class="d-inline" onsubmit="return confirm('Delete this student?');">
                <input type="hidden" name="id" value="<?php echo $row["stu_id"]; ?>">
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
  echo "<div class='p-4 text-center text-muted'>No students found</div>";
}
?>

  </div>
</div>

<?php
// ================= DELETE =================
if(isset($_POST['delete'])){
  $id = (int) $_POST['id'];

  $sql = "DELETE FROM student WHERE stu_id = $id";
  if($conn->query($sql) === TRUE){
    echo "<script>location.reload();</script>";
  }
}
?>

<?php include('./adminInclude/footer.php'); ?>