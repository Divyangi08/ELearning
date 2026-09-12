<?php
// ===== START SESSION =====
if (session_id() == '') {
  session_start();
}

define('TITLE', 'Feedback');
define('PAGE', 'feedback');

include('./stuInclude/header.php'); 
include_once('../dbConnection.php');

// ===== LOGIN CHECK =====
if (!isset($_SESSION['stuLogEmail'])) {
  echo "<script> location.href='../index.php'; </script>";
  exit();
}

$stuEmail = $_SESSION['stuLogEmail'];

// ===== GET STUDENT ID =====
$stuId = "";
$sql = "SELECT stu_id FROM student WHERE stu_email='$stuEmail'";
$result = $conn->query($sql);

if ($result && $result->num_rows == 1) {
  $row = $result->fetch_assoc();
  $stuId = $row['stu_id'];
}

// ===== SUBMIT FEEDBACK =====
if (isset($_POST['submitFeedbackBtn'])) {

  if (empty($_POST['f_content'])) {
    $passmsg = "<div class='alert alert-warning mt-3'>Please enter feedback</div>";
  } else {

    $fcontent = $_POST['f_content'];

    $sql = "INSERT INTO feedback (f_content, stu_id) VALUES ('$fcontent', '$stuId')";

    if ($conn->query($sql) == TRUE) {
      $passmsg = "<div class='alert alert-success mt-3'>Feedback submitted successfully</div>";
    } else {
      $passmsg = "<div class='alert alert-danger mt-3'>Submission failed</div>";
    }
  }
}
?>

<!-- 🎨 UI START -->
<div class="container-fluid">

  <div class="row justify-content-center">

    <div class="col-md-6">

      <div class="card p-4 shadow-sm">

        <h4 class="mb-3">💬 Give Your Feedback</h4>

        <form method="POST">

          <div class="mb-3">
            <label class="form-label">Student ID</label>
            <input type="text" class="form-control" 
                   value="<?php echo $stuId; ?>" readonly>
          </div>

          <div class="mb-3">
            <label class="form-label">Your Feedback</label>
            <textarea class="form-control" 
                      name="f_content" 
                      rows="4" 
                      placeholder="Write your feedback here..."
                      required></textarea>
          </div>

          <button type="submit" 
                  class="btn btn-primary w-100" 
                  name="submitFeedbackBtn">
            Submit Feedback
          </button>

          <!-- MESSAGE -->
          <?php if(isset($passmsg)) echo $passmsg; ?>

        </form>

      </div>

    </div>

  </div>

</div>

</div> <!-- close content -->

<?php include('./stuInclude/footer.php'); ?>