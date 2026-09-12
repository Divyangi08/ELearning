<?php 
// ================= ERROR REPORTING =================
error_reporting(E_ALL);
ini_set('display_errors', 1);

// ================= SESSION =================
if(session_id() == ''){
  session_start();
}

define('TITLE', 'Payment Status');

include('./adminInclude/header.php'); 
include('../dbConnection.php');

// ================= HEADERS =================
header("Pragma: no-cache");
header("Cache-Control: no-cache");
header("Expires: 0");

$ORDER_ID = "";
$responseParamList = [];
$paytmEnabled = false;

// ================= LOAD PAYTM =================
if(function_exists('openssl_encrypt')){
  if(file_exists("../PaytmKit/lib/config_paytm.php") && file_exists("../PaytmKit/lib/encdec_paytm.php")){
    require_once("../PaytmKit/lib/config_paytm.php");
    require_once("../PaytmKit/lib/encdec_paytm.php");

    if(function_exists('getTxnStatusNew')){
      $paytmEnabled = true;
    }
  }
}

// ================= GET STATUS =================
if (isset($_POST["ORDER_ID"]) && !empty($_POST["ORDER_ID"])) {

  $ORDER_ID = trim($_POST["ORDER_ID"]);

  // ✅ PAYTM CHECK
  if($paytmEnabled){

    $requestParamList = [
      "MID" => PAYTM_MERCHANT_MID,
      "ORDERID" => $ORDER_ID
    ];

    $checksum = getChecksumFromArray($requestParamList, PAYTM_MERCHANT_KEY);
    $requestParamList['CHECKSUMHASH'] = $checksum;

    $responseParamList = getTxnStatusNew($requestParamList);

    // fallback if API fails
    if(!$responseParamList){
      $responseParamList = ["ERROR" => "Unable to fetch Paytm response"];
    }
  }
}
?>

<style>
.main-content {
  margin-left: 230px;
  margin-top: 70px;
  padding: 20px 25px;
  background: #f5f7fb;
  min-height: 100vh;
}

.card-box {
  background: #fff;
  border-radius: 8px;
  padding: 20px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

body, h1, h2, h3, h4, label {
  color: #111 !important;
}

.table th, .table td {
  color: #111 !important;
}

.card-header {
  background: #f1f3f5 !important;
  color: #111 !important;
}
</style>

<div class="main-content">

<h4 class="mb-3">Payment Status</h4>

<div class="card-box mb-4">
  <form method="post" class="form-inline justify-content-center">

    <label class="mr-3 font-weight-bold">Order ID:</label>

    <input 
      type="text" 
      class="form-control mr-3" 
      name="ORDER_ID" 
      value="<?php echo htmlspecialchars($ORDER_ID); ?>" 
      placeholder="Enter Order ID"
      required
    >

    <button type="submit" class="btn btn-primary">
      Check Status
    </button>

  </form>
</div>

<?php
// ================= RESULT =================
if(!empty($ORDER_ID)){

  // ✅ PREPARED STATEMENT (SECURITY FIX)
  $stmt = $conn->prepare("SELECT * FROM courseorder WHERE order_id = ?");
  $stmt->bind_param("s", $ORDER_ID);
  $stmt->execute();
  $result = $stmt->get_result();

  if($result && $result->num_rows > 0){
    $row = $result->fetch_assoc();

    $status = $row['status'];
    $badge = ($status == 'Success') ? 'success' : 'danger';
?>

<div class="card-box">

  <div class="card-header text-center mb-3">
    Payment Details
  </div>

  <table class="table table-bordered text-center">
    <tbody>

      <tr>
        <th>Order ID</th>
        <td><?php echo htmlspecialchars($row['order_id']); ?></td>
      </tr>

      <tr>
        <th>Course ID</th>
        <td><?php echo htmlspecialchars($row['course_id']); ?></td>
      </tr>

      <tr>
        <th>Email</th>
        <td><?php echo htmlspecialchars($row['stu_email']); ?></td>
      </tr>

      <tr>
        <th>Status</th>
        <td>
          <span class="badge badge-<?php echo $badge; ?>">
            <?php echo htmlspecialchars($status); ?>
          </span>
        </td>
      </tr>

      <tr>
        <th>Date</th>
        <td><?php echo htmlspecialchars($row['order_date']); ?></td>
      </tr>

      <tr>
        <th>Amount</th>
        <td>₹ <?php echo htmlspecialchars($row['amount']); ?></td>
      </tr>

    </tbody>
  </table>

  <!-- PAYTM RESPONSE -->
  <?php if($paytmEnabled && !empty($responseParamList)){ ?>
    <h5 class="mt-4 text-center">Paytm Response</h5>
    <table class="table table-bordered text-center">
      <?php foreach($responseParamList as $key => $value){ ?>
        <tr>
          <th><?php echo htmlspecialchars($key); ?></th>
          <td><?php echo htmlspecialchars($value); ?></td>
        </tr>
      <?php } ?>
    </table>
  <?php } ?>

  <div class="text-right">
    <button class="btn btn-success" onclick="window.print()">
      Print Receipt
    </button>
  </div>

</div>

<?php
  } else {
    echo "<div class='alert alert-danger text-center'>Order not found</div>";
  }

  if(!$paytmEnabled){
    echo "<div class='alert alert-warning text-center mt-3'>
      Paytm not properly configured
    </div>";
  }
}
?>

</div>

<?php include('./adminInclude/footer.php'); ?>