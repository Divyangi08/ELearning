<?php  
session_start();

header("Pragma: no-cache");
header("Cache-Control: no-cache");
header("Expires: 0");

// Include Paytm files
require_once("./lib/config_paytm.php");
require_once("./lib/encdec_paytm.php");

// Check session
if (!isset($_SESSION['temp_user'])) {
    die("Session expired. Please try again.");
}

include("../dbConnection.php");

$temp = $_SESSION['temp_user'];

// ======================
// FETCH COURSE PRICE
// ======================
$stmt = $conn->prepare("SELECT course_price FROM course WHERE course_id=?");

if(!$stmt){
    die("SQL Error: " . $conn->error);
}

$stmt->bind_param("i", $temp['course_id']);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if (!$row) {
    die("Invalid course!");
}

// ======================
// PAYMENT DATA
// ======================
$ORDER_ID = "ORD" . rand(10000, 999999);
$CUST_ID = $temp['email'];
$TXN_AMOUNT = number_format((float)$row['course_price'], 2, '.', ''); // ✅ FIXED format

// ======================
// PARAM LIST
// ======================
$paramList = array();

$paramList["MID"] = PAYTM_MERCHANT_MID;
$paramList["ORDER_ID"] = $ORDER_ID;
$paramList["CUST_ID"] = $CUST_ID;
$paramList["INDUSTRY_TYPE_ID"] = PAYTM_INDUSTRY_TYPE_ID;
$paramList["CHANNEL_ID"] = PAYTM_CHANNEL_ID;
$paramList["TXN_AMOUNT"] = $TXN_AMOUNT;
$paramList["WEBSITE"] = PAYTM_MERCHANT_WEBSITE;

// ======================
// ✅ CRITICAL FIX (PATH)
// ======================

// ❌ OLD (WRONG sometimes due to case mismatch)
// /ELearning/

// ✅ NEW (MATCH YOUR PROJECT FOLDER EXACTLY)
$paramList["CALLBACK_URL"] = "http://" . $_SERVER['HTTP_HOST'] . "/Elearning/PaytmKit/pgResponse.php";

// ======================
// GENERATE CHECKSUM
// ======================
$checkSum = getChecksumFromArray($paramList, PAYTM_MERCHANT_KEY);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Processing Payment</title>
</head>
<body>

<center><h2>Please wait, redirecting to payment...</h2></center>

<form method="post" action="<?php echo PAYTM_TXN_URL ?>" name="paytmForm">

<?php
foreach ($paramList as $name => $value) {
    echo '<input type="hidden" name="' . htmlspecialchars($name) . '" value="' . htmlspecialchars($value) . '">';
}
?>

<input type="hidden" name="CHECKSUMHASH" value="<?php echo htmlspecialchars($checkSum); ?>">

</form>

<script>
document.paytmForm.submit();
</script>

</body>
</html>