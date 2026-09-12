<?php
// ================= ERROR REPORTING =================
error_reporting(E_ALL);
ini_set('display_errors', 1);

// ================= SESSION =================
if(session_id() == ''){
  session_start();
}

define('TITLE', 'Feedback');

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

/* ===== CARD ===== */
.card-box {
  background: #fff;
  border-radius: 8px;
  padding: 0;
  box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

/* ===== TEXT ===== */
body, h1, h2, h3, h4 {
  color: #111 !important;
}

/* ===== TABLE ===== */
.table thead {
  background: #f1f3f5;
}

.table th, .table td {
  color: #111 !important;
}

/* ===== BUTTON ===== */
.btn-danger {
  background: #ef4444;
  border: none;
}
</style>

<!-- ================= MAIN ================= -->
<div class="main-content">

  <!-- TITLE -->
  <h4 class="mb-3">User Feedback</h4>

  <div class="card-box">

<?php
$sql = "SELECT * FROM feedback";
$result = $conn->query($sql);

if($result && $result->num_rows > 0){
?>

    <div class="table-responsive">
      <table class="table table-bordered table-hover mb-0 text-center">
        <thead>
          <tr>
            <th style="width:5%">ID</th>
            <th style="width:65%">Feedback</th>
            <th style="width:15%">Student ID</th>
            <th style="width:15%">Action</th>
          </tr>
        </thead>

        <tbody>

<?php while($row = $result->fetch_assoc()){ ?>

          <tr>
            <td><?php echo $row["f_id"]; ?></td>
            <td class="text-left"><?php echo $row["f_content"]; ?></td>
            <td><?php echo $row["stu_id"]; ?></td>

            <td>
              <form method="POST" class="d-inline" onsubmit="return confirm('Delete this feedback?');">
                <input type="hidden" name="id" value="<?php echo $row["f_id"]; ?>">
                <button class="btn btn-sm btn-danger">Delete</button>
              </form>
            </td>
          </tr>

<?php } ?>

        </tbody>
      </table>
    </div>

<?php
} else {
  echo "<div class='p-4 text-center text-muted'>No feedback available</div>";
}
?>

  </div>

</div>

<?php
// ================= DELETE =================
if(isset($_POST['delete'])){
  $id = (int) $_POST['id'];

  $sql = "DELETE FROM feedback WHERE f_id = $id";
  if($conn->query($sql) === TRUE){
    echo "<script>location.reload();</script>";
  }
}
?>

<?php include('./adminInclude/footer.php'); ?>