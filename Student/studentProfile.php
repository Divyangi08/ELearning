<?php
if (session_id() == '') {
    session_start();
}

include('./stuInclude/header.php');
include_once('../dbConnection.php');

// DEFAULT VALUES
$stuId = "";
$stuName = "";
$stuOcc = "";
$stuImg = "../image/default.png";
$msg = "";

// SESSION
$stuEmail = isset($_SESSION['stuLogEmail']) ? $_SESSION['stuLogEmail'] : '';

if (empty($stuEmail)) {
    echo "Session expired. Please login again.";
    exit();
}

// FETCH DATA
$stmt = $conn->prepare("SELECT * FROM student WHERE stu_email = ?");
$stmt->bind_param("s", $stuEmail);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $stuId   = $row['stu_id'];
    $stuName = $row['stu_name'];
    $stuOcc  = $row['stu_occ'];
    $stuImg  = !empty($row['stu_img']) ? $row['stu_img'] : "../image/default.png";
}

// ===== UPDATE PROFILE =====
if (isset($_POST['updateStuNameBtn'])) {

    $name = trim($_POST['stuName']);
    $occ  = trim($_POST['stuOcc']);

    // VALIDATION
    if (empty($name) || empty($occ)) {
        $msg = '<div class="alert alert-danger">All fields are required.</div>';
    } 
    elseif (!preg_match("/^[a-zA-Z ]+$/", $name)) {
        $msg = '<div class="alert alert-danger">Name must contain only letters.</div>';
    } 
    else {

        $imgPath = $stuImg;

        // IMAGE VALIDATION
        if (!empty($_FILES['stuImg']['name'])) {

            $fileName = $_FILES['stuImg']['name'];
            $fileTmp  = $_FILES['stuImg']['tmp_name'];
            $fileSize = $_FILES['stuImg']['size'];
            $fileExt  = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            $allowed = array('jpg','jpeg','png');

            if (!in_array($fileExt, $allowed)) {
                $msg = '<div class="alert alert-danger">Only JPG, JPEG, PNG allowed.</div>';
            } 
            elseif ($fileSize > 2000000) {
                $msg = '<div class="alert alert-danger">Image must be less than 2MB.</div>';
            } 
            else {
                $imgPath = "../image/" . uniqid() . "_" . $fileName;
                move_uploaded_file($fileTmp, $imgPath);
            }
        }

        // UPDATE QUERY
        if (empty($msg)) {
            $update = $conn->prepare("UPDATE student SET stu_name=?, stu_occ=?, stu_img=? WHERE stu_email=?");
            $update->bind_param("ssss", $name, $occ, $imgPath, $stuEmail);

            if ($update->execute()) {
                $msg = '<div class="alert alert-success">Profile updated successfully ✔</div>';
                $stuName = $name;
                $stuOcc = $occ;
                $stuImg = $imgPath;
            } else {
                $msg = '<div class="alert alert-danger">Update failed. Try again.</div>';
            }
        }
    }
}
?>

<style>
.page-title { font-weight: 600; }
.subtitle { color: #6b7280; margin-bottom: 25px; }

.custom-card {
  border-radius: 15px;
  box-shadow: 0 10px 25px rgba(0,0,0,0.08);
  border: none;
}

.profile-img {
  width: 110px;
  height: 110px;
  border-radius: 50%;
  border: 4px solid #3b82f6;
  object-fit: cover;
}

.form-control { border-radius: 10px; }
.btn-primary { border-radius: 10px; }
</style>

<div class="container-fluid">

  <h2 class="page-title">Welcome 👋</h2>
  <p class="subtitle">Manage your profile</p>

  <div class="row g-4">

    <!-- PROFILE -->
    <div class="col-md-4">
      <div class="card custom-card text-center p-4">
        <img src="<?php echo $stuImg; ?>" class="profile-img mb-3">
        <h5><?php echo $stuName; ?></h5>
        <p class="text-muted"><?php echo $stuOcc; ?></p>
        <small><?php echo $stuEmail; ?></small>
      </div>
    </div>

    <!-- FORM -->
    <div class="col-md-8">
      <div class="card custom-card p-4">

        <h4 class="mb-3">Update Profile</h4>

        <?php if(!empty($msg)) { echo $msg; } ?>

        <form method="POST" enctype="multipart/form-data">

          <div class="row">
            <div class="col-md-6 mb-3">
              <label>Student ID</label>
              <input type="text" class="form-control" value="<?php echo $stuId; ?>" readonly>
            </div>

            <div class="col-md-6 mb-3">
              <label>Email</label>
              <input type="email" class="form-control" value="<?php echo $stuEmail; ?>" readonly>
            </div>
          </div>

          <div class="mb-3">
            <label>Full Name</label>
            <input type="text" name="stuName" class="form-control" value="<?php echo $stuName; ?>" required>
          </div>

          <div class="mb-3">
            <label>Occupation</label>
            <input type="text" name="stuOcc" class="form-control" value="<?php echo $stuOcc; ?>" required>
          </div>

          <div class="mb-3">
            <label>Profile Image</label><br>
            <img src="<?php echo $stuImg; ?>" style="width:80px;height:80px;"><br>
            <input type="file" name="stuImg" class="form-control mt-2">
          </div>

          <button type="submit" name="updateStuNameBtn" class="btn btn-primary">
            Update Profile
          </button>

        </form>

      </div>
    </div>

  </div>

</div>

<?php include('./stuInclude/footer.php'); ?>