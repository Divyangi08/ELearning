```php
<?php
include('./dbConnection.php');
include('./mainInclude/header.php');
?>

<!-- GOOGLE FONT -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>
body {
  font-family: 'Poppins', sans-serif;
  background: #f8fafc;
}

/* HEADER */
.contact-header {
  background: linear-gradient(135deg, #0f172a, #1e293b);
  color: white;
  padding: 80px 20px;
  text-align: center;
}

.contact-header p {
  color: #cbd5e1;
}

/* CARD */
.card {
  border-radius: 15px;
  transition: 0.3s ease;
}
.card:hover {
  transform: translateY(-5px);
}

/* BUTTON */
.btn-primary {
  background: #2563eb;
  border: none;
}
.btn-primary:hover {
  background: #1d4ed8;
}

/* INPUT */
.form-control {
  border-radius: 8px;
}
</style>

<!-- HEADER -->
<div class="contact-header">
  <h1>Contact Us</h1>
  <p>We’d love to hear from you! Reach out anytime.</p>
</div>

<!-- CONTENT -->
<div class="container py-5">
  <div class="row g-4">

    <!-- FORM -->
    <div class="col-lg-7">
      <div class="card shadow-sm p-4 border-0">

        <form method="post">

          <div class="mb-3">
            <label class="fw-semibold">Name</label>
            <input type="text" class="form-control" name="name" placeholder="Enter your name" required>
          </div>

          <div class="mb-3">
            <label class="fw-semibold">Subject</label>
            <input type="text" class="form-control" name="subject" placeholder="Enter subject" required>
          </div>

          <div class="mb-3">
            <label class="fw-semibold">Email</label>
            <input type="email" class="form-control" name="email" placeholder="Enter your email" required>
          </div>

          <div class="mb-3">
            <label class="fw-semibold">Message</label>
            <textarea class="form-control" name="message" rows="5" placeholder="Write your message..." required></textarea>
          </div>

          <button type="submit" name="submit" class="btn btn-primary w-100 rounded-pill">
            Send Message
          </button>

        </form>

      </div>
    </div>

    <!-- CONTACT INFO -->
    <div class="col-lg-5">
      <div class="card p-4 h-100 border-0 shadow-sm">

        <h4 class="fw-bold mb-3">SkillHeritage</h4>

        <p class="text-muted">
          <i class="fas fa-map-marker-alt text-primary me-2"></i>
          Near Police Camp II, Bokaro, Jharkhand - 834005
        </p>

        <p class="text-muted">
          <i class="fas fa-phone text-primary me-2"></i>
          +91 9876543210
        </p>

        <p class="text-muted">
          <i class="fas fa-envelope text-primary me-2"></i>
          support@skillheritage.com
        </p>

        <p class="text-muted">
          <i class="fas fa-globe text-primary me-2"></i>
          www.skillheritage.com
        </p>

        <hr>

        <p class="text-muted mb-0">
          Our team is always ready to support your learning journey. 
          Feel free to contact us anytime.
        </p>

      </div>
    </div>

  </div>
</div>

<?php include('./mainInclude/footer.php'); ?>
```
