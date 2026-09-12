<?php
include('./dbConnection.php');
include('./mainInclude/header.php');
?>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>
html { scroll-behavior: smooth; }

body {
  font-family: 'Poppins', sans-serif;
  background: #f8fafc;
  margin-top: 70px;
}

/* ================= NAVBAR ================= */
.glass-nav {
  position: fixed;
  top: 0;
  width: 100%;
  z-index: 999;
  backdrop-filter: blur(10px);
  background: rgba(255,255,255,0.7);
  border-bottom: 1px solid rgba(0,0,0,0.05);
  transition: 0.3s ease;
}

.navbar.scrolled {
  background: rgba(255,255,255,0.9);
}

/* ================= HERO ================= */
.hero {
  position: relative;
  height: 90vh;
  overflow: hidden;
}

.hero video {
  width: 100%;
  height: 100%;
  object-fit: cover;
  animation: zoomVideo 12s ease-in-out infinite alternate;
}

@keyframes zoomVideo {
  from { transform: scale(1); }
  to { transform: scale(1.08); }
}

.hero::after {
  content: "";
  position: absolute;
  inset: 0;
  background: rgba(0,0,0,0.55);
}

.hero-content {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  color: white;
  text-align: center;
}

/* HERO TEXT ANIMATION */
.hero-content h1,
.hero-content p,
.hero-content a {
  opacity: 0;
  transform: translateY(40px);
  animation: fadeUp 1s ease forwards;
}

.hero-content p { animation-delay: 0.2s; }
.hero-content a { animation-delay: 0.4s; }

@keyframes fadeUp {
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* ================= BUTTON ================= */
.btn-main {
  background: #2563eb;
  color: #fff;
  border-radius: 50px;
  padding: 10px 24px;
  border: none;
  transition: all 0.3s ease;
}

.btn-main:hover {
  background: #1d4ed8;
  transform: translateY(-2px);
  box-shadow: 0 10px 25px rgba(37,99,235,0.3);
}

/* ================= SECTIONS ================= */
.section {
  padding: 80px 0;
}

/* ================= CARDS ================= */
.card {
  border: none;
  border-radius: 14px;
  box-shadow: 0 8px 25px rgba(0,0,0,0.05);
  transition: all 0.3s ease;
}

.card:hover {
  transform: translateY(-8px) scale(1.02);
  box-shadow: 0 20px 50px rgba(0,0,0,0.08);
}

/* ================= ANIMATION ================= */
.reveal {
  opacity: 0;
  transform: translateY(60px) scale(0.98);
  transition: all 0.8s cubic-bezier(.2,.65,.3,1);
}

.reveal.show {
  opacity: 1;
  transform: translateY(0) scale(1);
}
</style>

<!-- ================= NAVBAR ================= -->
<nav class="navbar glass-nav navbar-expand-lg px-4">
  <a class="navbar-brand fw-bold" href="#">E-Learn</a>

  <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav">☰</button>

  <div class="collapse navbar-collapse" id="nav">
    <ul class="navbar-nav ms-auto">
      <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
      <li class="nav-item"><a class="nav-link" href="courses.php">Courses</a></li>
      <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>
    </ul>
  </div>
</nav>

<!-- ================= HERO ================= -->
<div class="hero">
  <video autoplay muted loop playsinline>
    <source src="video/banvid.mp4">
  </video>

  <div class="hero-content">
    <h1>Learn Skills That Matter</h1>
    <p class="mb-4">Modern learning for real-world success</p>

    <?php    
    if(!isset($_SESSION['is_login'])){
      echo '<a class="btn-main">Get Started</a>';
    } else {
      echo '<a class="btn btn-outline-light rounded-pill px-4" href="student/studentProfile.php">Dashboard</a>';
    }
    ?>
  </div>
</div>

<!-- ================= FEATURES ================= -->
<div class="container section">
  <div class="row text-center">
    <div class="col-md-3 reveal">100+ Courses</div>
    <div class="col-md-3 reveal">Expert Mentors</div>
    <div class="col-md-3 reveal">Learn Anytime</div>
    <div class="col-md-3 reveal">Affordable Pricing</div>
  </div>
</div>

<!-- ================= COURSES ================= -->
<div class="container section">
  <h2 class="text-center mb-5">Popular Courses</h2>

  <div class="row">
    <?php
    $sql = "SELECT * FROM course LIMIT 3";
    $result = $conn->query($sql);

    if($result->num_rows > 0){ 
      while($row = $result->fetch_assoc()){
        $course_id = $row['course_id'];
    ?>

    <div class="col-md-4 mb-4 reveal">
      <div class="card h-100">

        <img src="<?php echo str_replace('..', '.', $row['course_img']); ?>" 
             style="height:180px; object-fit:cover;">

        <div class="card-body">
          <h6><?php echo $row['course_name']; ?></h6>
          <p class="text-muted small">
            <?php echo substr($row['course_desc'],0,60); ?>...
          </p>
        </div>

        <div class="card-footer bg-white border-0 d-flex justify-content-between">
          <span class="text-primary fw-bold">
            ₹<?php echo $row['course_price']; ?>
          </span>

          <a href="coursedetails.php?course_id=<?php echo $course_id; ?>" 
             class="btn btn-sm btn-outline-primary rounded-pill">
             View
          </a>
        </div>

      </div>
    </div>

    <?php } } ?>
  </div>
</div>

<!-- ================= TESTIMONIALS ================= -->
<div class="container section">
  <h2 class="text-center mb-5">Student Feedback</h2>

  <div class="row">
    <?php 
    $sql = "SELECT s.stu_name, s.stu_occ, s.stu_img, f.f_content 
            FROM feedback f
            LEFT JOIN student s ON s.stu_id = f.stu_id
            LIMIT 3";

    $result = $conn->query($sql);

    if($result && $result->num_rows > 0){
      while($row = $result->fetch_assoc()){
        $img = !empty($row['stu_img']) ? str_replace('../','',$row['stu_img']) : 'image/default.jpg';
    ?>

    <div class="col-md-4 mb-4 reveal">
      <div class="card text-center p-4">

        <p class="text-muted small">"<?php echo $row['f_content']; ?>"</p>

        <img src="<?php echo $img; ?>" 
             class="rounded-circle mx-auto my-3"
             style="width:60px;height:60px;object-fit:cover;">

        <h6><?php echo $row['stu_name']; ?></h6>
        <small class="text-muted"><?php echo $row['stu_occ']; ?></small>

      </div>
    </div>

    <?php } } ?>
  </div>
</div>

<!-- ================= SCRIPTS ================= -->
<script>
/* NAVBAR SCROLL EFFECT */
window.addEventListener("scroll", function () {
  document.querySelector(".navbar").classList.toggle("scrolled", window.scrollY > 20);
});

/* SCROLL REVEAL */
const observer = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if(entry.isIntersecting){
      entry.target.classList.add('show');
    }
  });
}, { threshold: 0.15 });

document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
</script>

<?php include('./mainInclude/footer.php'); ?>