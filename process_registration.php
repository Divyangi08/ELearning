<?php 
session_start();
include('./dbConnection.php');

// =========================
// HANDLE POST REQUEST
// =========================
if($_SERVER['REQUEST_METHOD'] == 'POST'){

  // INIT ERRORS
  $errors = [];

  // GET DATA
  $name = trim($_POST['name'] ?? '');
  $email = trim($_POST['email'] ?? '');
  $phone = trim($_POST['phone'] ?? '');
  $password = $_POST['password'] ?? '';
  $confirm_password = $_POST['confirm_password'] ?? '';
  $course_id = intval($_POST['course_id'] ?? 0);
  $payment_method = $_POST['payment_method'] ?? '';

  // =========================
  // VALIDATION
  // =========================
  if(strlen($name) < 3){
    $errors[] = "Name must be at least 3 characters";
  }

  if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $errors[] = "Invalid email format";
  }

  if(!preg_match('/^[0-9]{10}$/', $phone)){
    $errors[] = "Phone must be 10 digits";
  }

  if(strlen($password) < 6){
    $errors[] = "Password must be at least 6 characters";
  }

  if($password !== $confirm_password){
    $errors[] = "Passwords do not match";
  }

  if(empty($course_id)){
    $errors[] = "Invalid course selected";
  }

  // =========================
  // DATABASE CHECK
  // =========================
  if(!$conn){
    die("Database connection failed");
  }

  $stmt = $conn->prepare("SELECT stu_email FROM student WHERE stu_email=?");

  if($stmt){
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
      $errors[] = "Email already registered";
    }
  } else {
    $errors[] = "Database error occurred";
  }

  // =========================
  // LOAD HEADER
  // =========================
  include('./mainInclude/header.php');
?>

<style>
.page-wrapper {
  min-height: 75vh;
  display: flex;
  align-items: center;
  justify-content: center;
  background: linear-gradient(135deg, #4e73df, #1cc88a);
  padding: 60px 15px;
}

.card-box {
  background: #fff;
  border-radius: 18px;
  padding: 45px 35px;
  max-width: 520px;
  width: 100%;
  text-align: center;
  box-shadow: 0 20px 50px rgba(0,0,0,0.15);
  animation: fadeIn 0.4s ease;
}

.icon {
  font-size: 55px;
  margin-bottom: 15px;
}

.success { color: #28a745; }
.error { color: #e74c3c; }

.title {
  font-size: 24px;
  font-weight: 600;
  margin-bottom: 10px;
}

.subtitle {
  color: #777;
  margin-bottom: 20px;
}

ul {
  text-align: left;
  margin-bottom: 20px;
}

.btn-custom {
  border-radius: 10px;
  padding: 12px 20px;
  margin: 5px;
}

@keyframes fadeIn {
  from {opacity:0; transform: translateY(20px);}
  to {opacity:1; transform: translateY(0);}
}
</style>

<div class="page-wrapper">
  <div class="card-box">

<?php if(!empty($errors)): ?>

    <!-- ERROR UI -->
    <div class="icon error">
      <i class="fas fa-times-circle"></i>
    </div>

    <div class="title">Registration Failed</div>
    <div class="subtitle">Please fix the issues below</div>

    <ul>
      <?php foreach($errors as $e): ?>
        <li><?php echo htmlspecialchars($e); ?></li>
      <?php endforeach; ?>
    </ul>

    <a href="register.php" class="btn btn-primary btn-custom">
      ← Try Again
    </a>

<?php else: ?>

    <!-- SUCCESS UI -->
    <div class="icon success">
      <i class="fas fa-check-circle"></i>
    </div>

    <div class="title">Registration Successful 🎉</div>
    <div class="subtitle">
      Your account has been created successfully.
    </div>

    <a href="index.php" class="btn btn-success btn-custom">
      Go to Home
    </a>

    <a href="courses.php" class="btn btn-outline-primary btn-custom">
      Browse Courses
    </a>

<?php endif; ?>

  </div>
</div>

<?php
include('./mainInclude/footer.php');

} else {
  echo "Invalid Request";
}
?>