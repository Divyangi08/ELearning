<?php
include('./dbConnection.php');
include('./mainInclude/header.php');

// Fetch instructors
$sql = "SELECT * FROM instructors";
$result = $conn->query($sql);
?>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>
body {
  font-family: 'Poppins', sans-serif;
  background: #f8fafc;
  margin-top: 70px;
}

.hero-small {
  height: 50vh;
  background: linear-gradient(135deg, #0f172a, #1e293b);
  display: flex;
  align-items: center;
  justify-content: center;
  color: #fff;
  text-align: center;
}

.section {
  padding: 80px 0;
}

.card {
  border: none;
  border-radius: 14px;
  box-shadow: 0 8px 25px rgba(0,0,0,0.05);
  transition: 0.3s ease;
}

.card:hover {
  transform: translateY(-8px);
}

.instructor-img {
  width: 100%;
  height: 220px;
  object-fit: cover;
}

.role {
  color: #2563eb;
  font-weight: 500;
  font-size: 14px;
}
</style>

<!-- HERO -->
<div class="hero-small">
  <div>
    <h1>Meet Our Instructors</h1>
    <p>Learn from industry experts</p>
  </div>
</div>

<!-- INSTRUCTORS -->
<div class="container section">
  <h2 class="text-center mb-5">Expert Mentors</h2>

  <div class="row">

<?php
if ($result && $result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {

    $id = (int)$row['instructor_id'];
    $name = htmlspecialchars($row['first_name'] . " " . $row['last_name']);
    $desc = htmlspecialchars(substr($row['description'], 0, 80)) . "...";

    $img = !empty($row['image']) 
      ? $row['image'] 
      : 'image/instructor1.jpg';

    $role = !empty($row['role']) 
      ? htmlspecialchars($row['role']) 
      : 'Instructor';
?>

    <div class="col-md-3 mb-4">
      <div class="card h-100 text-center p-3 d-flex flex-column">

        <img src="<?php echo $img; ?>" class="rounded instructor-img mb-3">

        <h6><?php echo $name; ?></h6>

        <p class="role"><?php echo $role; ?></p>

        <p class="text-muted small"><?php echo $desc; ?></p>

        <div class="mt-auto">
          <a href="instructorDetails.php?instructor_id=<?php echo $id; ?>" 
             class="btn btn-primary w-100 rounded-pill">
             Read Full
          </a>
        </div>

      </div>
    </div>

<?php
  }
} else {
  echo "<div class='col-12 text-center'><h5>No instructors found</h5></div>";
}
?>

  </div>
</div>

<?php include('./mainInclude/footer.php'); ?>