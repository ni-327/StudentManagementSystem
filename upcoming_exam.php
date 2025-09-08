<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'student') {
    header("Location: ../../auth/login.php");
    exit;
}

include '../../includes/db.php';

$student_id = intval($_SESSION['user_id']);

// Fetch department_id of student
$dept_q = mysqli_query($conn, "SELECT department_id FROM student WHERE student_id = $student_id");
$dept = mysqli_fetch_assoc($dept_q)['department_id'];

// Fetch upcoming exams (future dates, filtered by student department)
$query = "SELECT e.exam_name, s.subject_name, e.exam_date 
          FROM exam e
          JOIN subject s ON e.subject_id = s.subject_id
          WHERE s.department_id = $dept AND e.exam_date >= CURDATE()
          ORDER BY e.exam_date ASC";

$result = mysqli_query($conn, $query);

// ✅ Add this block to catch SQL errors
if (!$result) {
    die("❌ SQL Error: " . mysqli_error($conn));
}

?>

<?php include '../include/header.php'; ?>
<?php include '../include/sidebar.php'; ?>
<?php include '../include/topbar.php'; ?>

<div style="margin-left:250px; padding-top:70px; padding:20px;">
    <h4 class="text-white mb-4"><i class="fas fa-calendar-alt me-2"></i>Upcoming Exams</h4>

    <table class="table table-dark table-bordered table-striped">
        <thead>
            <tr>
                <th>Exam Name</th>
                <th>Subject</th>
                <th>Date</th>
                <th>Time</th>
                <th>Venue</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                    <td><?= htmlspecialchars($row['Exam_Name']) ?></td>
                    <td><?= htmlspecialchars($row['Subject_Name']) ?></td>
                    <td><?= date('F j, Y', strtotime($row['Exam_Date'])) ?></td>
                    <td><?= htmlspecialchars($row['Exam_Time']) ?></td>
                    <td><?= htmlspecialchars($row['Venue']) ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="5" class="text-center text-secondary">No upcoming exams found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include '../include/footer.php';?>
