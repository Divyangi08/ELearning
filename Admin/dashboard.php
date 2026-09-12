<?php
session_start();

if(!isset($_SESSION['admin'])){
    header("Location: adminLogin.php");
    exit();
}

include('./adminInclude/header.php');

// DB CONNECTION
$conn = new mysqli("localhost", "root", "", "lms_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ===== COUNTS =====
$res1 = $conn->query("SELECT COUNT(*) as total FROM course");
$row1 = $res1->fetch_assoc();
$courses = $row1['total'];

$res2 = $conn->query("SELECT COUNT(*) as total FROM student");
$row2 = $res2->fetch_assoc();
$students = $row2['total'];

$res3 = $conn->query("SELECT COUNT(*) as total FROM courseorder");
$row3 = $res3->fetch_assoc();
$orders = $row3['total'];

$res4 = $conn->query("SELECT SUM(amount) as total FROM courseorder");
$row4 = $res4->fetch_assoc();
$revenue = $row4['total'] ? $row4['total'] : 0;

// ===== MONTH DATA =====
$months = array();
$monthlyRevenue = array();

for ($i=1; $i<=12; $i++) {
    $months[] = date("M", mktime(0,0,0,$i,1));

    $res = $conn->query("SELECT SUM(amount) as total FROM courseorder WHERE MONTH(order_date) = $i");
    $row = $res->fetch_assoc();

    $monthlyRevenue[] = $row['total'] ? (int)$row['total'] : 0;
}

// ===== TOP COURSES =====
$topCourses = array();

$res = $conn->query("
    SELECT c.course_name, COUNT(co.course_id) as total
    FROM courseorder co
    JOIN course c ON co.course_id = c.course_id
    GROUP BY co.course_id
    ORDER BY total DESC
    LIMIT 5
");

while($row = $res->fetch_assoc()){
    $topCourses[] = $row;
}
?>

<style>
/* ===== LAYOUT FIX ===== */
.main-content {
  margin-left: 230px;
  margin-top: 70px;
  padding: 25px;
  background: #f5f7fb;
  min-height: 100vh;
}

/* ===== FORCE BLACK TEXT ===== */
body, 
h1, h2, h3, h4, h5, h6, 
p, label, span, div, td, th {
  color: #111 !important;
}

input, textarea, select {
  color: #111 !important;
}

/* ===== CARDS ===== */
.grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 20px;
}

.card-box {
  background: #fff;
  padding: 20px;
  border-radius: 10px;
  text-align: center;
  box-shadow: 0 2px 6px rgba(0,0,0,0.05);
}

.revenue {
  background: #4f46e5;
  color: #fff !important;
}

/* ===== CHART ===== */
.chart-grid {
  display: grid;
  grid-template-columns: 2fr 1fr;
  gap: 20px;
  margin-top: 20px;
}

.chart-box {
  background: #fff;
  padding: 20px;
  border-radius: 10px;
}

/* ===== RESPONSIVE ===== */
@media(max-width: 900px){
  .grid {
    grid-template-columns: repeat(2,1fr);
  }
  .chart-grid {
    grid-template-columns: 1fr;
  }
}
</style>

<div class="main-content">

<h2>Dashboard</h2>

<!-- CARDS -->
<div class="grid">
  <div class="card-box">
    <p>Courses</p>
    <h2><?php echo $courses; ?></h2>
  </div>

  <div class="card-box">
    <p>Students</p>
    <h2><?php echo $students; ?></h2>
  </div>

  <div class="card-box">
    <p>Orders</p>
    <h2><?php echo $orders; ?></h2>
  </div>

  <div class="card-box revenue">
    <p>Revenue</p>
    <h2>₹ <?php echo $revenue; ?></h2>
  </div>
</div>

<!-- CHARTS -->
<div class="chart-grid">

  <div class="chart-box">
    <h3>Revenue Trend</h3>
    <canvas id="lineChart"></canvas>
  </div>

  <div class="chart-box">
    <h3>Top Courses</h3>
    <canvas id="barChart"></canvas>
  </div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
var months = <?php echo json_encode($months); ?>;
var revenueData = <?php echo json_encode($monthlyRevenue); ?>;
var topCourses = <?php echo json_encode($topCourses); ?>;

// LINE CHART
new Chart(document.getElementById('lineChart'), {
    type:'line',
    data:{
        labels: months,
        datasets:[{
            label:'Revenue',
            data: revenueData,
            borderColor:'#4f46e5',
            backgroundColor:'rgba(79,70,229,0.2)',
            fill:true
        }]
    }
});

// BAR CHART
var names = topCourses.map(function(c){ return c.course_name; });
var totals = topCourses.map(function(c){ return c.total; });

new Chart(document.getElementById('barChart'), {
    type:'bar',
    data:{
        labels:names,
        datasets:[{
            label:'Sales',
            data:totals,
            backgroundColor:'#22c55e'
        }]
    }
});
</script>

<?php include('./adminInclude/footer.php'); ?>