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

// Get department ID of logged-in student
$dept_q = mysqli_query($conn, "SELECT department_id FROM student WHERE student_id = $student_id");
$dept = mysqli_fetch_assoc($dept_q)['department_id'];

// Get past exams (before today)
$query = "SELECT e.exam_name, s.subject_name, e.exam_date, e.exam_time, e.venue 
          FROM exam e
          JOIN subjects s ON e.subject_id = s.subject_id
          WHERE s.department_id = $dept AND e.exam_date < CURDATE()
          ORDER BY e.exam_date DESC";

$result = mysqli_query($conn, $query);
?>

<?php include '../include/header.php'; ?>
<?php include '../include/sidebar.php'; ?>
<?php include '../include/topbar.php'; ?>

<div style="margin-left:250px; padding-top:70px; padding:20px;">
    <h4 class="text-white mb-4"><i class="fas fa-history me-2"></i>Exam History</h4>

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
                        <td><?= htmlspecialchars($row['exam_name']) ?></td>
                        <td><?= htmlspecialchars($row['subject_name']) ?></td>
                        <td><?= date('F j, Y', strtotime($row['exam_date'])) ?></td>
                        <td><?= htmlspecialchars($row['exam_time']) ?></td>
                        <td><?= htmlspecialchars($row['venue']) ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="5" class="text-center text-secondary">No past exams found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include '../include/footer.php';?>
