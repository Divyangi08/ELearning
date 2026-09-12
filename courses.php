<?php
include('./dbConnection.php');
include('./mainInclude/header.php'); // session_start() is inside header.php
?>

<!-- GOOGLE FONT -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>
body {
  font-family: 'Poppins', sans-serif;
  background: #f1f5f9;
}

/* Banner */
.banner {
  background: linear-gradient(135deg, #0f172a, #1e293b);
  padding: 80px 20px;
  text-align: center;
  color: white;
}

.banner h1 {
  font-weight: 600;
}

/* Search */
.search-box {
  max-width: 500px;
  margin: 20px auto 0;
}

/* Card */
.card {
  border-radius: 15px;
  transition: 0.3s ease;
}
.card:hover {
  transform: translateY(-6px);
}

.card-img-top {
  border-top-left-radius: 15px;
  border-top-right-radius: 15px;
}

/* Button */
.btn-primary {
  background: #2563eb;
  border: none;
}
.btn-primary:hover {
  background: #1d4ed8;
}
</style>

<!-- BANNER -->
<div class="banner">
  <h1>Explore Courses</h1>
  <p class="text-light">Upgrade your skills with our latest courses</p>

  <!-- SEARCH -->
  <form method="GET" class="search-box d-flex">
    <input type="text" 
           name="search" 
           class="form-control me-2" 
           placeholder="Search courses..."
           value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
    <button class="btn btn-primary">Search</button>
  </form>
</div>

<!-- COURSES -->
<div class="container py-5">
  <div class="row g-4">

<?php
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Search query
if($search != ''){
  $stmt = $conn->prepare("SELECT * FROM course WHERE course_name LIKE ?");
  $like = "%$search%";
  $stmt->bind_param("s", $like);
  $stmt->execute();
  $result = $stmt->get_result();
} else {
  $result = $conn->query("SELECT * FROM course");
}

if($result && $result->num_rows > 0){

  while($row = $result->fetch_assoc()){

    $course_id = (int)$row['course_id'];
    $course_name = htmlspecialchars($row['course_name']);
    $course_desc = htmlspecialchars(substr($row['course_desc'],0,80)) . "...";
    $course_img = !empty($row['course_img']) 
        ? str_replace('..', '.', $row['course_img']) 
        : './image/default.jpg';

    $original_price = htmlspecialchars($row['course_original_price']);
    $price = htmlspecialchars($row['course_price']);
?>

    <div class="col-lg-4 col-md-6">
      <div class="card h-100 shadow-sm">

        <img src="<?php echo $course_img; ?>" 
             class="card-img-top" 
             style="height:200px; object-fit:cover;">

        <div class="card-body d-flex flex-column">

          <h6 class="fw-bold"><?php echo $course_name; ?></h6>

          <p class="text-muted small">
            <?php echo $course_desc; ?>
          </p>

          <div class="mt-auto">

            <div class="mb-3">
              <small class="text-muted">
                <del>₹<?php echo $original_price; ?></del>
              </small><br>
              <span class="fw-bold text-primary">
                ₹<?php echo $price; ?>
              </span>
            </div>

            <a href="coursedetails.php?course_id=<?php echo $course_id; ?>" 
               class="btn btn-primary w-100 rounded-pill">
               Enroll Now
            </a>

          </div>

        </div>
      </div>
    </div>

<?php
  }

} else {
  echo '<div class="col-12 text-center"><h5>No courses found</h5></div>';
}
?>

  </div>
</div>

<?php include('./mainInclude/footer.php'); ?>