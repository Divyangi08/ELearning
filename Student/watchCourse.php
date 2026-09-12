<?php  
if (session_id() == '') {
    session_start();
}

include('./stuInclude/header.php');
include('../dbConnection.php');

// ===== LOGIN CHECK =====
if (!isset($_SESSION['stuLogEmail'])) {
    echo "<script> location.href='../index.php'; </script>";
    exit();
}

// ===== GET COURSE ID =====
$course_id = isset($_GET['course_id']) ? $_GET['course_id'] : null;

// ===== VALIDATION =====
if (!$course_id) {
    echo "<script> location.href='myCourse.php'; </script>";
    exit();
}

// ===== FUNCTION: YOUTUBE CONVERT =====
function convertToEmbed($url) {
    parse_str(parse_url($url, PHP_URL_QUERY), $params);
    if (isset($params['v'])) {
        return "https://www.youtube.com/embed/" . $params['v'];
    }
    return $url;
}

$firstVideo = "";
?>

<style>
body { background:#f1f5f9; font-family:'Segoe UI'; }
.content { margin-left:240px; padding:25px; }

.card-box {
    background:white;
    padding:18px;
    border-radius:12px;
    box-shadow:0 4px 12px rgba(0,0,0,0.08);
}

.lesson-item {
    padding:12px;
    border-bottom:1px solid #eee;
    cursor:pointer;
}

.lesson-item:hover { background:#e2e8f0; }
.lesson-item.active { background:#3b82f6; color:white; }

.video-frame {
    width:100%;
    height:500px;
    border-radius:12px;
}
</style>

<div class="content">

<h4 class="mb-3">🎬 Course Player</h4>

<div class="row">

<!-- ===== LESSON LIST ===== -->
<div class="col-md-3">
<div class="card-box">
<h6>Lessons</h6>

<ul class="list-unstyled" id="playlist">

<?php
$stmt = $conn->prepare("SELECT lesson_name, lesson_link FROM lesson WHERE course_id = ?");
$stmt->bind_param("i", $course_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {

    $isFirst = true;

    while ($row = $result->fetch_assoc()) {

        $embedLink = convertToEmbed($row['lesson_link']);

        if ($isFirst) {
            $firstVideo = $embedLink;
            $active = "active";
            $isFirst = false;
        } else {
            $active = "";
        }

        echo '<li class="lesson-item '.$active.'" 
                data-video="'.htmlspecialchars($embedLink).'">'
                .htmlspecialchars($row['lesson_name']).
             '</li>';
    }

} else {
    echo "<li>No lessons found</li>";
}

$stmt->close();
?>

</ul>
</div>
</div>

<!-- ===== VIDEO PLAYER ===== -->
<div class="col-md-9">
<div class="card-box">

<?php if ($firstVideo): ?>
<iframe id="videoarea"
    class="video-frame"
    src="<?php echo $firstVideo; ?>"
    frameborder="0"
    allow="autoplay; encrypted-media"
    allowfullscreen>
</iframe>
<?php else: ?>
<p>No video available</p>
<?php endif; ?>

</div>
</div>

</div>
</div>

<script>
const video = document.getElementById("videoarea");
const items = document.querySelectorAll(".lesson-item");

items.forEach(item => {
    item.addEventListener("click", function() {

        items.forEach(i => i.classList.remove("active"));
        this.classList.add("active");

        video.src = this.getAttribute("data-video");
    });
});
</script>

<?php include('./stuInclude/footer.php'); ?>