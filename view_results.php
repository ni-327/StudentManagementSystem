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

// Fetch student results
$query = "SELECT r.result_id, s.subject_name, r.grade, r.gpa, r.status
          FROM result r
          JOIN subject s ON r.subject_id = s.subject_id
          WHERE r.student_id = $student_id
          ORDER BY r.result_id DESC";

$result = mysqli_query($conn, $query);
?>

<?php include '../include/header.php'; ?>
<?php include '../include/sidebar.php'; ?>
<?php include '../include/topbar.php'; ?>

<div style="margin-left:250px; padding-top:70px; padding:20px;">
    <h4 class="text-white mb-4"><i class="fas fa-poll me-2"></i>My Results</h4>

    <table class="table table-dark table-bordered table-striped">
        <thead>
            <tr>
                <th>Subject</th>
                <th>Grade</th>
                <th>GPA</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['subject_name']) ?></td>
                        <td><?= htmlspecialchars($row['grade']) ?></td>
                        <td><?= htmlspecialchars($row['gpa']) ?></td>
                        <td><?= htmlspecialchars($row['status']) ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="4" class="text-center text-secondary">No results available.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include '../include/footer.php';?>