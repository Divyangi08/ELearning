<?php
if (session_id() == '') {
  session_start();
}

include_once('../dbConnection.php');

// ===== SESSION =====
$stuLogEmail = isset($_SESSION['stuLogEmail']) ? $_SESSION['stuLogEmail'] : '';

// ===== DEFAULT IMAGE =====
$stu_img = "../image/default.png";

// ===== FETCH IMAGE =====
if (!empty($stuLogEmail)) {
  $stmt = $conn->prepare("SELECT stu_img FROM student WHERE stu_email = ?");
  $stmt->bind_param("s", $stuLogEmail);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (!empty($row['stu_img'])) {
      $stu_img = $row['stu_img'];
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?php echo defined('TITLE') ? TITLE : 'Student Panel'; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Bootstrap -->
<link rel="stylesheet" href="../css/bootstrap.min.css">

<!-- Font Awesome -->
<link rel="stylesheet" href="../css/all.min.css">

<!-- Google Font -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

<style>
body {
  margin: 0;
  font-family: 'Inter', sans-serif;
  background: #f1f5f9;
}

/* ===== SIDEBAR ===== */
.sidebar {
  position: fixed;
  top: 0;
  left: 0;
  width: 240px;
  height: 100vh;
  background: linear-gradient(180deg, #020617, #0f172a);
  color: #fff;
  padding: 20px;
}

/* TITLE */
.sidebar h4 {
  display: flex;
  align-items: center;
  gap: 10px;
  font-weight: 600;
}

/* PROFILE */
.sidebar img {
  width: 85px;
  height: 85px;
  border-radius: 50%;
  border: 3px solid #3b82f6;
  margin: 15px auto;
  display: block;
  object-fit: cover;
}

/* EMAIL */
.sidebar .email {
  text-align: center;
  font-size: 14px;
  color: #94a3b8;
  word-break: break-all;
}

/* MENU */
.sidebar a {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 10px;
  color: #cbd5e1;
  text-decoration: none;
  border-radius: 8px;
  margin: 5px 0;
  transition: 0.3s;
}

.sidebar a i {
  width: 20px;
  text-align: center;
}

.sidebar a:hover {
  background: #1e293b;
  color: #fff;
  transform: translateX(5px);
}

/* ACTIVE */
.sidebar a.active {
  background: #3b82f6;
  color: #fff;
}

/* MAIN CONTENT */
.main-content {
  margin-left: 240px;
  padding: 30px;
}
</style>
</head>

<body>

<!-- ===== SIDEBAR ===== -->
<div class="sidebar">

  <h4><i class="fas fa-user-graduate"></i> Student Panel</h4>

  <img src="<?php echo $stu_img; ?>" alt="Profile">

  <div class="email"><?php echo $stuLogEmail; ?></div>

  <hr style="border-color:#334155;">

  <a href="studentProfile.php" class="<?php if(defined('PAGE') && PAGE=='profile') echo 'active'; ?>">
    <i class="fas fa-user-circle"></i> Profile
  </a>

  <a href="myCourse.php" class="<?php if(defined('PAGE') && PAGE=='mycourse') echo 'active'; ?>">
    <i class="fas fa-book"></i> My Courses
  </a>

  <a href="watchcourse.php" class="<?php if(defined('PAGE') && PAGE=='watchcourse') echo 'active'; ?>">
    <i class="fas fa-play-circle"></i> Watch Course
  </a>

  <a href="paymentstatus.php" class="<?php if(defined('PAGE') && PAGE=='payment') echo 'active'; ?>">
    <i class="fas fa-credit-card"></i> Payment
  </a>

  <a href="stufeedback.php" class="<?php if(defined('PAGE') && PAGE=='feedback') echo 'active'; ?>">
    <i class="fas fa-comment-dots"></i> Feedback
  </a>

  <a href="studentChangePass.php" class="<?php if(defined('PAGE') && PAGE=='studentChangePass') echo 'active'; ?>">
    <i class="fas fa-lock"></i> Change Password
  </a>

  <a href="addstudent.php" class="<?php if(defined('PAGE') && PAGE=='addstudent') echo 'active'; ?>">
    <i class="fas fa-user-plus"></i> Add Student
  </a>

  <hr>

  <a href="../logout.php">
    <i class="fas fa-sign-out-alt"></i> Logout
  </a>

</div>

<!-- ===== MAIN CONTENT START ===== -->
<div class="main-content">