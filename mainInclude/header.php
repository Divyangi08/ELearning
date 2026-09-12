<?php
ob_start(); // Prevent header errors

// ✅ Start session safely (ONLY HERE)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Bootstrap -->
  <link rel="stylesheet" href="css/bootstrap.min.css">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="css/style.css">

  <title>SkillHeritage</title>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-sm navbar-dark fixed-top shadow-sm px-4"
     style="background: linear-gradient(90deg,#020617,#0f172a);">

  <!-- Logo -->
  <div class="d-flex align-items-center">
    <a href="index.php" class="navbar-brand text-white font-weight-bold" style="font-size:24px;">
      SkillHeritage
    </a>

    <span class="navbar-text text-light ml-3" style="font-size:16px;">
      Your Gateway to Technical Skills
    </span>
  </div>

  <!-- Toggle -->
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#myMenu">
    <span class="navbar-toggler-icon"></span>
  </button>

  <!-- Menu -->
  <div class="collapse navbar-collapse justify-content-center" id="myMenu">

    <!-- Center Menu -->
    <ul class="navbar-nav mx-auto text-center">
      <li class="nav-item px-2"><a href="index.php" class="nav-link text-light">Home</a></li>
      <li class="nav-item px-2"><a href="about.php" class="nav-link text-light">About</a></li>
      <li class="nav-item px-2"><a href="courses.php" class="nav-link text-light">Courses</a></li>
      <li class="nav-item px-2"><a href="instructors.php" class="nav-link text-light">Instructors</a></li>
      <li class="nav-item px-2"><a href="testimonial.php" class="nav-link text-light">Testimonials</a></li>
      <li class="nav-item px-2"><a href="contact.php" class="nav-link text-light">Contact</a></li>
    </ul>

    <!-- Right Side -->
    <ul class="navbar-nav position-absolute" style="right:20px;">
      <?php 
      if (isset($_SESSION['is_login'])){
        echo '
        <li class="nav-item">
          <a href="student/studentProfile.php" class="nav-link text-light">My Profile</a>
        </li>
        <li class="nav-item">
          <a href="logout.php" class="nav-link text-light">Logout</a>
        </li>';
      } else {
        echo '
        <li class="nav-item">
          <a href="login.php" class="nav-link text-light">Login</a>
        </li>
        <li class="nav-item">
          <a href="signup.php" class="nav-link btn btn-danger text-white ml-2 px-3">Signup</a>
        </li>';
      }
      ?>
    </ul>

  </div>
</nav>

<!-- spacing for fixed navbar -->
<div style="margin-top:80px;"></div>