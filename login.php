<?php 
include('./dbConnection.php');
include('./mainInclude/header.php'); // session_start() is inside header.php

$loginMsg = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $email = isset($_POST['stuLogEmail']) ? trim($_POST['stuLogEmail']) : '';
  $pass  = isset($_POST['stuLogPass']) ? trim($_POST['stuLogPass']) : '';

  if (empty($email) || empty($pass)) {
    $loginMsg = "<span class='text-danger'>All fields are required</span>";
  } 
  elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $loginMsg = "<span class='text-danger'>Invalid email format</span>";
  } 
  else {

    $stmt = $conn->prepare("SELECT stu_email, stu_pass FROM student WHERE stu_email = ?");
    
    if ($stmt) {
      $stmt->bind_param("s", $email);
      $stmt->execute();
      $result = $stmt->get_result();

      if ($result && $result->num_rows === 1) {
        $row = $result->fetch_assoc();

        // ✅ Password check (basic)
        if ($pass == $row['stu_pass']) {

          session_regenerate_id(true);

          $_SESSION['is_login'] = true;
          $_SESSION['stuLogEmail'] = $email;

          header("Location: student/studentProfile.php");
          exit();

        } else {
          $loginMsg = "<span class='text-danger'>Incorrect password</span>";
        }

      } else {
        $loginMsg = "<span class='text-danger'>Email not registered</span>";
      }

      $stmt->close();
    } else {
      $loginMsg = "<span class='text-danger'>Database error</span>";
    }
  }
}
?>

<div class="container py-5">
  <div class="row justify-content-center">

    <div class="col-md-5">
      <div class="card p-4 shadow-lg">

        <h3 class="text-center mb-4">Student Login</h3>

        <form method="POST">

          <div class="mb-3">
            <label>Email</label>
            <input type="email" class="form-control" name="stuLogEmail" required>
          </div>

          <div class="mb-3">
            <label>Password</label>
            <input type="password" class="form-control" name="stuLogPass" required>
          </div>

          <button type="submit" class="btn btn-primary w-100">Login</button>

        </form>

        <div class="mt-3 text-center">
          <?php echo $loginMsg; ?>
        </div>

      </div>
    </div>

  </div>
</div>

<?php include('./mainInclude/footer.php'); ?>