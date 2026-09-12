<?php  
include('./dbConnection.php');
session_start();

// Login check
if(!isset($_SESSION['stuLogEmail'])) {
  header("Location: login.php");
  exit();
}

$stuEmail = $_SESSION['stuLogEmail'];

// Course check
if(!isset($_POST['course_id'])){
  header("Location: courses.php");
  exit();
}

$course_id = intval($_POST['course_id']);

// ✅ Prepared statement (SAFE)
$stmt = $conn->prepare("SELECT * FROM course WHERE course_id = ?");
$stmt->bind_param("i", $course_id);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows == 0){
  die("Invalid Course");
}

$row = $result->fetch_assoc();

// ✅ Better order ID (unique)
$order_id = "ORDS" . time() . rand(100,999);

// Store session
$_SESSION['ORDER_ID'] = $order_id;
$_SESSION['course_id'] = $course_id;
$_SESSION['amount'] = $row['course_price'];
?>

<!DOCTYPE html>
<html>
<head>
<title>Checkout</title>
<link rel="stylesheet" href="css/bootstrap.min.css">
</head>

<body>

<div class="container mt-5">
<div class="card p-4">

<h3>Checkout</h3>

<h5><?php echo htmlspecialchars($row['course_name']); ?></h5>
<h4>₹<?php echo htmlspecialchars($row['course_price']); ?></h4>

<form method="post" action="./PaytmKit/pgRedirect.php">

<input type="hidden" name="ORDER_ID" value="<?php echo $order_id; ?>">
<input type="hidden" name="CUST_ID" value="<?php echo $stuEmail; ?>">
<input type="hidden" name="TXN_AMOUNT" value="<?php echo $row['course_price']; ?>">

<input type="hidden" name="INDUSTRY_TYPE_ID" value="Retail">
<input type="hidden" name="CHANNEL_ID" value="WEB">

<button type="submit" class="btn btn-primary w-100">Pay Now</button>

</form>

</div>
</div>

</body>
</html>