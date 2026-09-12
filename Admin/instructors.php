<?php  
error_reporting(E_ALL);
ini_set('display_errors', 1);

if(session_id() == ''){
  session_start();
}

define('TITLE', 'Instructors');

include('./adminInclude/header.php'); 
include('../dbConnection.php');
?>

<!-- ================= STYLE ================= -->
<style>
.main-content {
  margin-left: 230px;
  margin-top: 70px;
  padding: 20px 25px;
  background: #f5f7fb;
  min-height: 100vh;
}

.page-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 15px;
  border-bottom: 1px solid #ddd;
  padding-bottom: 8px;
}

.card-box {
  background: #fff;
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.table thead {
  background: #f1f3f5;
}

.table th, .table td {
  text-align: center;
  vertical-align: middle;
}

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
    <h4 class="m-0">Instructors Management</h4>
    <a href="addInstructor.php" class="btn btn-success btn-sm">
      + Add Instructor
    </a>
  </div>

  <div class="card-box">

<?php
$sql = "SELECT * FROM instructors";
$result = $conn->query($sql);

if($result && $result->num_rows > 0){
?>

    <div class="table-responsive">
      <table class="table table-bordered table-hover mb-0">
        <thead>
          <tr>
            <th>ID</th>
            <th>Image</th>
            <th>Name</th>
            <th>Role</th>
            <th>Actions</th>
          </tr>
        </thead>

        <tbody>

<?php while($row = $result->fetch_assoc()){ ?>

          <tr>
            <td><?php echo $row["instructor_id"]; ?></td>

            <td>
              <img src="../<?php echo $row['image']; ?>" 
                   width="50" height="50" 
                   style="border-radius:50%; object-fit:cover;">
            </td>

            <td>
              <?php echo $row["first_name"] . " " . $row["last_name"]; ?>
            </td>

            <td>
              <?php 
              echo !empty($row['role']) 
                   ? $row['role'] 
                   : "Instructor"; 
              ?>
            </td>

            <td>

              <!-- EDIT -->
              <form action="editInstructor.php" method="GET" class="d-inline">
                <input type="hidden" name="id" value="<?php echo $row["instructor_id"]; ?>">
                <button class="btn btn-sm btn-info">Edit</button>
              </form>

              <!-- DELETE -->
              <form method="POST" class="d-inline" onsubmit="return confirm('Delete this instructor?');">
                <input type="hidden" name="id" value="<?php echo $row["instructor_id"]; ?>">
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
  echo "<div class='p-4 text-center text-muted'>No instructors found</div>";
}
?>

  </div>
</div>

<?php
// ================= DELETE =================
if(isset($_POST['delete'])){
  $id = (int) $_POST['id'];

  $sql = "DELETE FROM instructors WHERE instructor_id = $id";
  if($conn->query($sql) === TRUE){
    echo "<script>location.reload();</script>";
  }
}
?>

<?php include('./adminInclude/footer.php'); ?>