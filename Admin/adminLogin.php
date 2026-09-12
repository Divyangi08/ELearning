<?php 
session_start();

// 🔴 SHOW ERRORS
error_reporting(E_ALL);
ini_set('display_errors', 1);

// ✅ DATABASE CONNECTION (FIXED)
$conn = new mysqli("localhost", "root", "", "lms_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ✅ LOGIN LOGIC
if (isset($_POST['login'])) {

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT * FROM admin WHERE admin_email=? AND admin_pass=?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $_SESSION['admin'] = $email;
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid Email or Password";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <style>
        body {
            font-family: Arial;
            background: #f2f2f2;
        }
        .login-box {
            width: 320px;
            margin: 100px auto;
            padding: 25px;
            background: white;
            box-shadow: 0 0 10px gray;
            text-align: center;
            border-radius: 8px;
        }
        input {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
        }
        button {
            padding: 10px 20px;
            background: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background: #0056b3;
        }
        .error {
            color: red;
        }
    </style>
</head>

<body>

<div class="login-box">
    <h2>Admin Login</h2>

    <?php if (isset($error)) { ?>
        <p class="error"><?php echo $error; ?></p>
    <?php } ?>

    <form method="POST">
        <input type="email" name="email" placeholder="Enter Email" required>
        <input type="password" name="password" placeholder="Enter Password" required>
        <button type="submit" name="login">Login</button>
    </form>
</div>

</body>
</html>