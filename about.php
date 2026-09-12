<?php
include('./dbConnection.php');
include('./mainInclude/header.php');
?>

<style>
/* ✅ Image Styling with Border */
.about-img {
  max-width: 420px;
  width: 100%;
  height: auto;
  object-fit: cover;
  border: 4px solid #dc3545; /* Red border */
  border-radius: 12px;       /* Smooth rounded corners */
  box-shadow: 0 10px 25px rgba(0,0,0,0.2);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

/* 🔥 Hover Effect */
.about-img:hover {
  transform: scale(1.03);
  box-shadow: 0 15px 35px rgba(0,0,0,0.3);
}
</style>

<!-- HERO SECTION -->
<section class="container-fluid p-0">
  <div style="
    background: linear-gradient(rgba(2,6,23,0.85), rgba(15,23,42,0.95)), 
                url('image/about.jpg') center/cover no-repeat;
    height: 65vh;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    color: #fff;
  ">
    <div>
      <h1 class="display-4 fw-bold">About SkillHeritage</h1>
      <p class="lead mt-3">Building Future-Ready Skills Through Digital Learning</p>
      <a href="courses.php" class="btn btn-danger mt-3 px-4 py-2">Explore Courses</a>
    </div>
  </div>
</section>

<!-- ABOUT SECTION -->
<section class="container py-5">
  <div class="row align-items-center">

    <!-- TEXT CONTENT -->
    <div class="col-md-6 mb-4">
      <h2 class="fw-bold mb-3">Who We Are</h2>
      <p class="text-muted">
        <strong>SkillHeritage</strong> is a modern digital learning platform dedicated to 
        bridging the gap between industry experts and aspiring learners. We provide 
        hands-on training in programming, web development, and emerging technologies 
        to help individuals stay competitive in today’s digital world.
      </p>

      <h3 class="fw-bold mt-4">Our Mission</h3>
      <p class="text-muted">
        To make high-quality education accessible, affordable, and flexible for everyone, 
        empowering learners to achieve their personal and professional goals.
      </p>

      <h3 class="fw-bold mt-4">Our Vision</h3>
      <p class="text-muted">
        To create a global learning ecosystem where knowledge is shared openly, 
        skills are nurtured continuously, and careers are transformed through innovation.
      </p>
    </div>

    <!-- ✅ IMAGE WITH BORDER -->
    <div class="col-md-6 d-flex justify-content-center align-items-center">
      <img src="image/about1.jpg" 
           class="img-fluid about-img" 
           alt="About SkillHeritage">
    </div>

  </div>
</section>

<!-- STATS SECTION -->
<section class="container-fluid text-white text-center py-5" 
         style="background: linear-gradient(90deg,#020617,#0f172a);">
  <div class="row">

    <div class="col-md-3 mb-3">
      <h2 class="fw-bold">100+</h2>
      <p class="text-light">Courses Available</p>
    </div>

    <div class="col-md-3 mb-3">
      <h2 class="fw-bold">50+</h2>
      <p class="text-light">Expert Instructors</p>
    </div>

    <div class="col-md-3 mb-3">
      <h2 class="fw-bold">1000+</h2>
      <p class="text-light">Active Students</p>
    </div>

    <div class="col-md-3 mb-3">
      <h2 class="fw-bold">24/7</h2>
      <p class="text-light">Learning Access</p>
    </div>

  </div>
</section>

<!-- FEATURES SECTION -->
<section class="container py-5">
  <h2 class="text-center fw-bold mb-5">Why Choose SkillHeritage?</h2>

  <div class="row text-center">

    <div class="col-md-3 mb-4">
      <div class="p-4 shadow-sm rounded bg-white h-100">
        <i class="fas fa-laptop fa-2x text-danger mb-3"></i>
        <h5 class="fw-semibold">Flexible Learning</h5>
        <p class="text-muted small">Access courses anytime, anywhere at your convenience.</p>
      </div>
    </div>

    <div class="col-md-3 mb-4">
      <div class="p-4 shadow-sm rounded bg-white h-100">
        <i class="fas fa-user-tie fa-2x text-danger mb-3"></i>
        <h5 class="fw-semibold">Industry Experts</h5>
        <p class="text-muted small">Learn directly from experienced professionals.</p>
      </div>
    </div>

    <div class="col-md-3 mb-4">
      <div class="p-4 shadow-sm rounded bg-white h-100">
        <i class="fas fa-book-open fa-2x text-danger mb-3"></i>
        <h5 class="fw-semibold">Structured Content</h5>
        <p class="text-muted small">Step-by-step learning paths designed for clarity.</p>
      </div>
    </div>

    <div class="col-md-3 mb-4">
      <div class="p-4 shadow-sm rounded bg-white h-100">
        <i class="fas fa-chart-line fa-2x text-danger mb-3"></i>
        <h5 class="fw-semibold">Career Advancement</h5>
        <p class="text-muted small">Build skills that boost your career growth.</p>
      </div>
    </div>

  </div>
</section>

<!-- CALL TO ACTION -->
<section class="container text-center py-5">
  <h2 class="fw-bold mb-3">Start Your Learning Journey Today</h2>
  <p class="text-muted mb-4">
    Join thousands of learners and upgrade your skills with SkillHeritage.
  </p>
  <a href="courses.php" class="btn btn-danger px-4 py-2">Get Started</a>
</section>

<?php include('./mainInclude/footer.php'); ?>