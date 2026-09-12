<?php 
// ================= SESSION =================
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('TITLE', 'Payment Status');
define('PAGE', 'payment');

// ================= DB =================
include('../dbConnection.php');

// ================= HEADER =================
include('./stuInclude/header.php');

// ================= PAYTM =================
require_once(dirname(__FILE__) . '/../PaytmKit/lib/config_paytm.php');
require_once(dirname(__FILE__) . '/../PaytmKit/lib/encdec_paytm.php');

$ORDER_ID = "";
$responseParamList = [];
$msg = "";

// ================= FORM =================
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if (!empty($_POST["ORDER_ID"])) {

    // ✅ Clean input (ONLY trim)
    $ORDER_ID = trim($_POST["ORDER_ID"]);

    // ================= CHECK IN DB =================
    $stmt = $conn->prepare("SELECT * FROM courseorder WHERE order_id = ?");
    $stmt->bind_param("s", $ORDER_ID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {

      $msg = '<div class="alert alert-danger text-center">
                ❌ Invalid Order ID! (Not found in database)
              </div>';

    } else {

      // ================= PAYTM REQUEST =================
      $paytmParams = [];

      $paytmParams["body"] = [
        "mid" => PAYTM_MERCHANT_MID,
        "orderId" => $ORDER_ID
      ];

      $checksum = getChecksumFromArray($paytmParams["body"], PAYTM_MERCHANT_KEY);

      $paytmParams["head"] = [
        "signature" => $checksum
      ];

      $post_data = json_encode($paytmParams);

      // ================= API =================
      $url = "https://securegw-stage.paytm.in/v3/order/status";

      $ch = curl_init($url);

      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);

      $response = curl_exec($ch);

      if (curl_errno($ch)) {
        $msg = '<div class="alert alert-danger">
                  Curl Error: '.curl_error($ch).'
                </div>';
      }

      curl_close($ch);

      $responseParamList = json_decode($response, true);
    }

  } else {
    $msg = '<div class="alert alert-warning text-center">Enter Order ID!</div>';
  }
}
?>

<style>
.page-title { font-weight: 600; }
.subtitle { color: #6b7280; }

.form-card {
  max-width: 420px;
  margin: 30px auto;
  border-radius: 15px;
  box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}

.invoice-box {
  max-width: 800px;
  margin: 30px auto;
  background: #fff;
  padding: 25px;
  border-radius: 15px;
  box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}

.badge-success { background: #16a34a; }
.badge-fail { background: #dc2626; }
</style>

<div class="container-fluid">

  <h2 class="page-title">Payment Status 💳</h2>
  <p class="subtitle">Check your transaction details</p>

  <!-- ================= FORM ================= -->
  <div class="card form-card p-4">

    <h5 class="text-center mb-3">Check Payment</h5>

    <?php echo $msg; ?>

    <form method="POST">
      <input type="text" name="ORDER_ID"
             class="form-control mb-3"
             placeholder="Enter Order ID"
             value="<?php echo htmlspecialchars($ORDER_ID); ?>" required>

      <button class="btn btn-primary w-100">Check</button>
    </form>

  </div>

  <!-- ================= RESULT ================= -->
  <?php 
  if (!empty($responseParamList)) {

    $status = $responseParamList["body"]["resultInfo"]["resultStatus"] ?? "UNKNOWN";
    $badge = ($status == "TXN_SUCCESS") ? "badge-success" : "badge-fail";
    $body = $responseParamList["body"] ?? [];
  ?>

  <div class="invoice-box">

    <div class="d-flex justify-content-between">
      <h4>Invoice</h4>
      <span class="badge <?php echo $badge; ?> text-white p-2">
        <?php echo $status; ?>
      </span>
    </div>

    <hr>

    <table class="table table-bordered text-center">
      <tbody>

      <?php
      foreach ($body as $key => $value) {
        if (!is_array($value)) {
          echo "<tr>
                  <th>$key</th>
                  <td>".htmlspecialchars($value)."</td>
                </tr>";
        }
      }
      ?>

      </tbody>
    </table>

    <div class="text-end">
      <button onclick="window.print()" class="btn btn-success">
        Print Invoice
      </button>
    </div>

  </div>

  <?php } ?>

</div>

<?php include('./stuInclude/footer.php'); ?>