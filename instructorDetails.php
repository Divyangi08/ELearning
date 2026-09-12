<?php
include('./dbConnection.php');
include('./mainInclude/header.php');

if (!isset($_GET['instructor_id']) || empty($_GET['instructor_id'])) {
  echo "<h3 class='text-center mt-5'>Invalid Instructor</h3>";
  exit;
}

$instructor_id = (int)$_GET['instructor_id'];

// Fetch instructor
$stmt = $conn->prepare("SELECT * FROM instructors WHERE instructor_id = ?");
$stmt->bind_param("i", $instructor_id);
$stmt->execute();
$result = $stmt->get_result();

if (!$result || $result->num_rows == 0) {
  echo "<h3 class='text-center mt-5'>Instructor not found</h3>";
  exit;
}

$row = $result->fetch_assoc();

$name = htmlspecialchars($row['first_name'] . " " . $row['last_name']);
$email = htmlspecialchars($row['email']);
$desc = htmlspecialchars($row['description']);
$hire_date = htmlspecialchars($row['hire_date']);
$salary = htmlspecialchars($row['salary']);

$img = !empty($row['image']) 
  ? $row['image'] 
  : 'image/instructor1.jpg';

$role = !empty($row['role']) 
  ? htmlspecialchars($row['role']) 
  : 'Instructor';
?>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>
body {
  font-family: 'Poppins', sans-serif;
  background: #f1f5f9;
}

.detail-header {
  background: linear-gradient(135deg, #0f172a, #1e293b);
  color: white;
  padding: 60px 20px;
  text-align: center;
}

.detail-card {
  background: #fff;
  border-radius: 15px;
  padding: 30px;
  margin-top: -40px;
  box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.profile-img {
  width: 180px;
  height: 180px;
  border-radius: 50%;
  object-fit: cover;
  margin-bottom: 15px;
}

.label {
  font-weight: 600;
}
</style>

<!-- HEADER -->
<div class="detail-header">
  <h1><?php echo $name; ?></h1>
  <p><?php echo $role; ?></p>
</div>

<!-- DETAILS -->
<div class="container">
  <div class="detail-card text-center">

    <img src="<?php echo $img; ?>" class="profile-img">

    <h4><?php echo $name; ?></h4>
    <p class="text-muted"><?php echo $email; ?></p>

    <hr>

    <p><span class="label">Hire Date:</span> <?php echo $hire_date; ?></p>
    <p><span class="label">Salary:</span> ₹<?php echo $salary; ?></p>

    <hr>

    <h5>About Instructor</h5>
    <p class="text-muted"><?php echo $desc; ?></p>

    <a href="instructor.php" class="btn btn-primary mt-3">
      Back to Instructors
    </a>

  </div>
</div>

<?php include('./mainInclude/footer.php'); ?>