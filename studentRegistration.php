<?php  
session_start();
include('./dbConnection.php');
include('./mainInclude/header.php');

// Get course_id
if(isset($_GET['course_id'])){
  $_SESSION['course_id'] = $_GET['course_id'];
}

$course_id = $_SESSION['course_id'] ?? 0;

// Fetch course
$course_name = "No Course Selected";
$course_price = "0";

if($course_id){
  $stmt = $conn->prepare("SELECT * FROM course WHERE course_id=?");
  $stmt->bind_param("i", $course_id);
  $stmt->execute();
  $result = $stmt->get_result();

  if($result->num_rows > 0){
    $course = $result->fetch_assoc();
    $course_name = $course['course_name'];
    $course_price = $course['course_price'];
  }
}
?>

<style>
.page-wrapper {
  padding: 60px 0;
  background: linear-gradient(135deg, #4e73df, #1cc88a);
  min-height: 100vh;
}

.register-card, .summary-card {
  border-radius: 15px;
  box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.summary-card {
  background: #fff;
  padding: 25px;
}

.form-control {
  border-radius: 10px;
}

.btn {
  border-radius: 10px;
}

.section-title {
  font-weight: 600;
  margin-bottom: 20px;
}

.price-box {
  font-size: 26px;
  font-weight: bold;
  color: #28a745;
}

.payment-box {
  background: #f8f9fa;
  padding: 15px;
  border-radius: 10px;
  margin-top: 10px;
}
</style>

<div class="page-wrapper">
  <div class="container">
    <div class="row">

      <!-- LEFT -->
      <div class="col-md-7">
        <div class="card register-card p-4">

          <h4 class="section-title">📝 Student Registration</h4>

          <form method="post" action="process_registration.php">

            <div class="form-group">
              <label>Full Name</label>
              <input type="text" class="form-control" name="name" required>
            </div>

            <div class="form-group">
              <label>Email</label>
              <input type="email" class="form-control" name="email" required>
            </div>

            <div class="form-group">
              <label>Phone</label>
              <input type="tel" class="form-control" name="phone" required>
            </div>

            <div class="form-row">
              <div class="form-group col-md-6">
                <label>Password</label>
                <input type="password" class="form-control" name="password" required>
              </div>

              <div class="form-group col-md-6">
                <label>Confirm Password</label>
                <input type="password" class="form-control" name="confirm_password" required>
              </div>
            </div>

            <!-- PAYMENT -->
            <div class="form-group">
              <label class="font-weight-bold">💳 Payment Method</label>

              <div class="custom-control custom-radio">
                <input type="radio" id="razor" name="payment_method" value="razorpay" class="custom-control-input" required onclick="showPayment('razor')">
                <label class="custom-control-label" for="razor">Razorpay</label>
              </div>

              <div class="custom-control custom-radio">
                <input type="radio" id="upi" name="payment_method" value="upi" class="custom-control-input" onclick="showPayment('upi')">
                <label class="custom-control-label" for="upi">UPI</label>
              </div>

              <div class="custom-control custom-radio">
                <input type="radio" id="card" name="payment_method" value="card" class="custom-control-input" onclick="showPayment('card')">
                <label class="custom-control-label" for="card">Card</label>
              </div>
            </div>

            <!-- Razorpay -->
            <div id="razorBox" class="payment-box" style="display:none;">
              <p>Secure payment via Razorpay gateway.</p>
            </div>

            <!-- UPI -->
            <div id="upiBox" class="payment-box" style="display:none;">
              <div class="form-group">
                <label>UPI ID</label>
                <input type="text" class="form-control" name="upi_id">
              </div>
            </div>

            <!-- Card -->
            <div id="cardBox" class="payment-box" style="display:none;">
              <div class="form-group">
                <label>Card Number</label>
                <input type="text" class="form-control" name="card_number">
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label>Expiry</label>
                  <input type="text" class="form-control" name="expiry">
                </div>

                <div class="form-group col-md-6">
                  <label>CVV</label>
                  <input type="password" class="form-control" name="cvv">
                </div>
              </div>
            </div>

            <input type="hidden" name="course_id" value="<?php echo $course_id; ?>">

            <button type="submit" class="btn btn-success btn-block mt-3">
              Register & Pay →
            </button>

          </form>
        </div>
      </div>

      <!-- RIGHT -->
      <div class="col-md-5">
        <div class="summary-card">
          <h5 class="section-title">📘 Course Summary</h5>

          <p><strong>Course:</strong><br>
            <?php echo htmlspecialchars($course_name); ?>
          </p>

          <p><strong>Price:</strong></p>
          <div class="price-box">₹<?php echo htmlspecialchars($course_price); ?></div>

          <hr>

          <p class="text-muted">
            ✔ Lifetime access <br>
            ✔ Certificate included <br>
            ✔ Beginner to Advanced
          </p>
        </div>
      </div>

    </div>
  </div>
</div>

<script>
function showPayment(method){
  document.getElementById('razorBox').style.display = 'none';
  document.getElementById('upiBox').style.display = 'none';
  document.getElementById('cardBox').style.display = 'none';

  if(method === 'razor') document.getElementById('razorBox').style.display = 'block';
  if(method === 'upi') document.getElementById('upiBox').style.display = 'block';
  if(method === 'card') document.getElementById('cardBox').style.display = 'block';
}
</script>

<?php include('./mainInclude/footer.php'); ?>