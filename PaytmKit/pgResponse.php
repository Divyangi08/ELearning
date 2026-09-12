<?php 
header("Pragma: no-cache");
header("Cache-Control: no-cache");
header("Expires: 0");

session_start();

// DB connection
include('../dbConnection.php');

// Paytm files
require_once("./lib/config_paytm.php");
require_once("./lib/encdec_paytm.php");

// Get Paytm response
$paramList = $_POST;

$paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : "";

// Verify checksum
$isValidChecksum = verifychecksum_e($paramList, PAYTM_MERCHANT_KEY, $paytmChecksum);

if($isValidChecksum == true){

    if (isset($_POST["STATUS"]) && $_POST["STATUS"] == "TXN_SUCCESS") {

        echo "<h2 style='color:green;text-align:center;'>Payment Successful ✅</h2>";

        if(isset($_SESSION['temp_user'])){

            $temp = $_SESSION['temp_user'];

            $name = $temp['name'];
            $email = $temp['email'];
            $phone = $temp['phone'];
            $password = password_hash($temp['password'], PASSWORD_DEFAULT);
            $course_id = $temp['course_id'];

            // =========================
            // INSERT STUDENT (FIXED COLUMN NAME)
            // =========================
            $check = $conn->prepare("SELECT * FROM student WHERE stu_email=?");

            if(!$check){
                die("SQL Error: " . $conn->error);
            }

            $check->bind_param("s", $email);
            $check->execute();
            $res = $check->get_result();

            if($res->num_rows == 0){

                $stmt = $conn->prepare("INSERT INTO student (stu_name, stu_email, stu_pass, stu_phone) VALUES (?, ?, ?, ?)");

                if(!$stmt){
                    die("Insert Error: " . $conn->error);
                }

                $stmt->bind_param("ssss", $name, $email, $password, $phone);
                $stmt->execute();
            }

            // =========================
            // INSERT ORDER (FIXED FIELD NAMES)
            // =========================
            $order_id = $_POST['ORDERID'] ?? '';
            $status = $_POST['STATUS'] ?? '';
            $respmsg = $_POST['RESPMSG'] ?? '';
            $amount = $_POST['TXNAMOUNT'] ?? '';
            $date = $_POST['TXNDATE'] ?? date("Y-m-d H:i:s");

            $stmt2 = $conn->prepare("INSERT INTO courseorder 
            (order_id, stu_email, course_id, status, respmsg, amount, order_date) 
            VALUES (?, ?, ?, ?, ?, ?, ?)");

            if(!$stmt2){
                die("Order Insert Error: " . $conn->error);
            }

            $stmt2->bind_param("sssssss", $order_id, $email, $course_id, $status, $respmsg, $amount, $date);
            $stmt2->execute();

            // LOGIN USER
            $_SESSION['stuLogEmail'] = $email;

            unset($_SESSION['temp_user']);

            echo "<script>
                setTimeout(() => {
                    window.location.href = '../Student/myCourse.php';
                }, 2000);
            </script>";

        } else {
            echo "<p style='text-align:center;'>Session expired. Please try again.</p>";
        }

    } else {
        echo "<h2 style='color:red;text-align:center;'>Payment Failed ❌</h2>";
    }

} else {
    echo "<h2 style='color:red;text-align:center;'>Checksum mismatched ❌</h2>";
}
?>