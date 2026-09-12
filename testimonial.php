
<?php
include('./dbConnection.php');
include('./mainInclude/header.php');
?>

<!-- Google Font -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<!-- Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

<style>
:root {
  --primary: #0f172a;
  --secondary: #1e293b;
}

body {
  font-family: 'Poppins', sans-serif;
  background: linear-gradient(135deg, #e2e8f0, #f8fafc);
}

/* HEADER */
.testimonial-header {
  background: linear-gradient(135deg, var(--primary), var(--secondary));
  color: #fff;
  padding: 90px 20px;
  text-align: center;
}

/* SLIDER */
.swiper {
  padding: 60px 10px;
}

/* GLASS CARD */
.testimonial-card {
  backdrop-filter: blur(12px);
  background: rgba(255, 255, 255, 0.6);
  border-radius: 18px;
  padding: 25px;
  border: 1px solid rgba(255,255,255,0.3);
  box-shadow: 0 10px 30px rgba(0,0,0,0.08);
  height: 100%;
  transition: 0.3s ease;
}

.testimonial-card:hover {
  transform: translateY(-8px) scale(1.02);
}

/* QUOTE */
.quote {
  font-size: 15px;
  color: #1e293b;
  line-height: 1.6;
  margin-bottom: 20px;
}

/* STARS */
.stars {
  color: #fbbf24;
  margin-bottom: 12px;
  font-size: 16px;
}

/* PROFILE */
.profile {
  display: flex;
  align-items: center;
  gap: 12px;
}

.profile img {
  width: 55px;
  height: 55px;
  border-radius: 50%;
  object-fit: cover;
  border: 2px solid rgba(255,255,255,0.5);
}

.name {
  font-weight: 600;
}

.role {
  font-size: 13px;
  color: #475569;
}

/* NAV BUTTONS */
.swiper-button-next,
.swiper-button-prev {
  color: #0f172a;
}

/* PAGINATION */
.swiper-pagination-bullet {
  background: #0f172a;
}
</style>

<!-- HEADER -->
<section class="testimonial-header">
  <h1>What Our Students Say</h1>
  <p>Real experiences from learners at SkillHeritage</p>
</section>

<!-- SLIDER -->
<section class="container py-5">

<div class="swiper mySwiper">
  <div class="swiper-wrapper">

<?php
$sql = "SELECT s.stu_name, s.stu_occ, s.stu_img, f.f_content 
        FROM feedback f
        LEFT JOIN student s ON s.stu_id = f.stu_id";

$result = $conn->query($sql);

if ($result && $result->num_rows > 0):
  while ($row = $result->fetch_assoc()):

    $img = !empty($row['stu_img']) 
      ? str_replace('../', '', $row['stu_img']) 
      : 'image/default.jpg';

    $name = !empty($row['stu_name']) ? htmlspecialchars($row['stu_name']) : 'Student';
    $role = !empty($row['stu_occ']) ? htmlspecialchars($row['stu_occ']) : 'Learner';
    $feedback = !empty($row['f_content']) ? htmlspecialchars($row['f_content']) : 'Great learning experience!';
?>

    <!-- SLIDE -->
    <div class="swiper-slide">
      <div class="testimonial-card">

        <!-- ⭐ STARS -->
        <div class="stars">★★★★★</div>

        <!-- TEXT -->
        <p class="quote">“<?php echo $feedback; ?>”</p>

        <!-- PROFILE -->
        <div class="profile">
          <img src="<?php echo $img; ?>" alt="<?php echo $name; ?>">
          <div>
            <div class="name"><?php echo $name; ?></div>
            <div class="role"><?php echo $role; ?></div>
          </div>
        </div>

      </div>
    </div>

<?php 
  endwhile;
endif;
?>

  </div>

  <!-- NAV -->
  <div class="swiper-button-next"></div>
  <div class="swiper-button-prev"></div>

  <!-- DOTS -->
  <div class="swiper-pagination"></div>

</div>

</section>

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
var swiper = new Swiper(".mySwiper", {
  slidesPerView: 3,
  spaceBetween: 30,
  loop: true,
  autoplay: {
    delay: 2500,
    disableOnInteraction: false,
  },

  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },

  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },

  breakpoints: {
    0: { slidesPerView: 1 },
    768: { slidesPerView: 2 },
    1024: { slidesPerView: 3 }
  }
});
</script>

<?php include('./mainInclude/footer.php'); ?>