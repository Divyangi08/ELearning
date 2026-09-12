<?php
// ================= SESSION =================
if (session_id() == '') {
  session_start();
}

define('TITLE', 'Add Instructor');

// ✅ FIXED PATH
include('./adminInclude/header.php');
include('../dbConnection.php');

// ================= SUBMIT =================
if (isset($_POST['addInstructor'])) {

  $fname = trim($_POST['first_name']);
  $lname = trim($_POST['last_name']);
  $role  = trim($_POST['role']);
  $desc  = trim($_POST['description']);

  // IMAGE
  $imgName = $_FILES['image']['name'];
  $tmpName = $_FILES['image']['tmp_name'];

  if (empty($fname) || empty($lname)) {
    $msg = "<div class='alert alert-warning'>Fill required fields</div>";
  } else {

    // Upload image
    if (!empty($imgName)) {
      $imgPath = "../image/" . $imgName;
      move_uploaded_file($tmpName, $imgPath);
      $dbPath = "image/" . $imgName;
    } else {
      $dbPath = "image/instructor1.jpg";
    }

    // Insert using prepared statement
    $stmt = $conn->prepare("INSERT INTO instructors 
      (first_name, last_name, role, description, image) 
      VALUES (?, ?, ?, ?, ?)");

    if ($stmt) {
      $stmt->bind_param("sssss", $fname, $lname, $role, $desc, $dbPath);

      if ($stmt->execute()) {
        $msg = "<div class='alert alert-success'>Instructor Added Successfully</div>";
      } else {
        $msg = "<div class='alert alert-danger'>Database Error</div>";
      }

      $stmt->close();
    }
  }
}
?>

<!-- ================= STYLE ================= -->
<style>

/* ===== FORCE BLACK TEXT ===== */
body, 
h1, h2, h3, h4, h5, h6, 
label, 
p {
  color: #111 !important;
}

/* ===== INPUT ===== */
.form-control {
  color: #111 !important;
  border: 1px solid #ccc;
}

.form-control::placeholder {
  color: #888;
}

textarea.form-control {
  color: #111 !important;
}

input[type="file"] {
  color: #111;
}

/* ===== BUTTON ===== */
.btn-primary {
  background: #4f46e5;
  border: none;
  color: #fff !important;
}

.btn-light {
  color: #111 !important;
  background: #f1f3f5;
}

/* ===== LAYOUT ===== */
.main-content {
  margin-left: 230px;
  margin-top: 70px;
  padding: 20px 25px;
  background: #f5f7fb;
  min-height: 100vh;
}

/* ===== CARD ===== */
.card-box {
  background: #fff;
  padding: 25px;
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.05);
  max-width: 600px;
  margin: auto;
}

/* ===== TITLES ===== */
.page-title {
  text-align: center;
  margin-bottom: 10px;
  font-weight: 600;
}

.subtitle {
  text-align: center;
  color: #555;
  margin-bottom: 20px;
}

</style>

<!-- ================= UI ================= -->
<div class="main-content">

  <div class="card-box">

    <h4 class="page-title">Add Instructor</h4>
    <p class="subtitle">Create a new instructor profile</p>

    <form method="POST" enctype="multipart/form-data">

      <div class="form-group">
        <label>First Name *</label>
        <input type="text" class="form-control" name="first_name" required>
      </div>

      <div class="form-group">
        <label>Last Name *</label>
        <input type="text" class="form-control" name="last_name" required>
      </div>

      <div class="form-group">
        <label>Role</label>
        <input type="text" class="form-control" name="role" placeholder="e.g. Web Developer">
      </div>

      <div class="form-group">
        <label>Description</label>
        <textarea class="form-control" name="description" rows="3"></textarea>
      </div>

      <div class="form-group">
        <label>Profile Image</label>
        <input type="file" class="form-control" name="image">
      </div>

      <div class="text-center mt-3">
        <button type="submit" class="btn btn-primary" name="addInstructor">
          Add Instructor
        </button>
        <a href="instructors.php" class="btn btn-light">Cancel</a>
      </div>

      <?php if (isset($msg)) echo $msg; ?>

    </form>

  </div>

</div>

<?php include('./adminInclude/footer.php'); ?>