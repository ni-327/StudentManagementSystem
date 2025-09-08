<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'student') {
    header("Location: ../../auth/login.php");
    exit;
}

include '../includes/db.php'; // DB connection

$student_id = intval($_SESSION['user_id']); // ✅ use this consistently

// Fetch student details
$query = "SELECT s.full_name, d.department_name 
          FROM student s 
          JOIN department d ON s.department_id = d.department_id 
          WHERE s.student_id = $student_id";

$result = mysqli_query($conn, $query);
if ($result && mysqli_num_rows($result) > 0) {
    $student = mysqli_fetch_assoc($result);
} else {
    echo "Error fetching student data: " . mysqli_error($conn);
exit;
}



// Fetch GPA summary
$gpa_query = "SELECT ROUND(AVG(gpa), 2) AS overall_gpa FROM result WHERE student_id = $student_id";
$gpa_result = mysqli_query($conn, $gpa_query);
$gpa = mysqli_fetch_assoc($gpa_result)['overall_gpa'] ?? 0.00;

// Result count
$count_query = "SELECT COUNT(*) AS total_subjects FROM result WHERE student_id = $student_id";
$count_result = mysqli_query($conn, $count_query);
$total_subject = mysqli_fetch_assoc($count_result)['total_subject'] ?? 0;

?>
<?php include 'include/header.php'; ?>
<?php include 'include/sidebar.php'; ?>
<?php include 'include/topbar.php'; ?>


<div style="margin-left:250px; padding-top:70px; padding:20px;">
    <h3 class="text-white">Welcome, <?= htmlspecialchars($student['full_name']) ?></h3>
   

    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card bg-dark text-white shadow border border-success">
                <div class="card-body">
                    <h5 class="card-title">📊 GPA Summary</h5>
                    <p class="card-text display-6"><?= $gpa ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-dark text-white shadow border border-info">
                <div class="card-body">
                    <h5 class="card-title">📚 Total Subject</h5>
                    <p class="card-text display-6"><?= $total_subject ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-5 text-white">
        <h5>🎯 Quick Links</h5>
        <a href="view_results.php" class="btn btn-outline-light me-2">View Results</a>
        <a href="transcript.php" class="btn btn-outline-warning me-2">Transcript</a>
        <a href="upcoming_exam.php" class="btn btn-outline-info">Upcoming Exams</a>
    </div>
</div>
<?php include 'include/footer.php'; ?>

