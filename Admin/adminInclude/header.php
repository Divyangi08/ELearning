<?php
if(session_id() == ''){
  session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

<style>

/* ===== GLOBAL ===== */
body{
  margin:0;
  font-family:'Poppins',sans-serif;
  background:#020617;
  color:#e2e8f0;
}

/* ===== HEADER ===== */
.navbar{
  position:fixed;
  top:0;
  left:0;
  width:100%;
  height:60px;
  background:#020617;
  border-bottom:1px solid rgba(255,255,255,0.08);
  z-index:1000;
}

/* ===== SIDEBAR ===== */
.sidebar{
  position:fixed;
  top:60px;
  left:0;
  width:240px;
  height:100%;
  background:#020617;
  border-right:1px solid rgba(255,255,255,0.05);
  padding-top:20px;
}

/* Sidebar links */
.sidebar a{
  display:block;
  color:#38bdf8;
  padding:10px 20px;
  margin:5px 10px;
  border-radius:8px;
  text-decoration:none;
  transition:0.3s;
}

.sidebar a:hover{
  background:#1e293b;
}

/* Active link */
.sidebar a.active{
  background:#1e293b;
}

/* Logout */
.logout{
  color:#ef4444 !important;
}

</style>
</head>

<body>

<!-- HEADER -->
<nav class="navbar px-3 d-flex justify-content-between">
  <h5 class="text-info m-0">
    <i class="fas fa-graduation-cap"></i> E-Learning <span class="text-light">Admin Panel</span>
  </h5>

  <span>
    <i class="fas fa-user"></i> 
    <?php echo isset($_SESSION['adminLogEmail']) ? $_SESSION['adminLogEmail'] : 'Admin'; ?>
  </span>
</nav>

<!-- SIDEBAR -->
<div class="sidebar">

  <a href="dashboard.php" class="active">
    <i class="fas fa-gauge"></i> Dashboard
  </a>

  <a href="courses.php">
    <i class="fas fa-book"></i> Courses
  </a>

  <a href="lessons.php">
    <i class="fas fa-play"></i> Lessons
  </a>

  <a href="students.php">
    <i class="fas fa-users"></i> Students
  </a>

  <a href="instructors.php">
    <i class="fas fa-chalkboard-teacher"></i> Instructors
  </a>


  <a href="payment.php">
    <i class="fas fa-credit-card"></i> Payment Status
  </a>

  <a href="feedback.php">
    <i class="fas fa-comments"></i> Feedback
  </a>

  <a href="adminChangePass.php">
    <i class="fas fa-key"></i> Change Password
  </a>

  <hr>

  <a href="../logout.php" class="logout">
    <i class="fas fa-right-from-bracket"></i> Logout
  </a>

</div>