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

// Get student info
$info_query = "SELECT full_name, registation_number, department_name FROM student WHERE student_id = $student_id";
$info_result = mysqli_query($conn, $info_query);
$student = mysqli_fetch_assoc($info_result);

// Get results
$result_query = "SELECT s.subject_name, r.grade, r.gpa, r.status
                 FROM result r
                 JOIN subject s ON r.subject_id = s.subject_id
                 WHERE r.student_id = $student_id";
$results = mysqli_query($conn, $result_query);

// Calculate GPA
$gpa_query = "SELECT ROUND(AVG(gpa), 2) AS overall_gpa FROM results WHERE student_id = $student_id";
$gpa_result = mysqli_query($conn, $gpa_query);
$gpa = mysqli_fetch_assoc($gpa_result)['overall_gpa'] ?? 0.00;
?>

<?php include '../include/header.php'; ?>
<?php include '../include/sidebar.php'; ?>
<?php include '../include/topbar.php'; ?>

<div style="margin-left:250px; padding-top:70px; padding:20px;">
    <div class="d-flex justify-content-between align-items-center">
        <h4 class="text-white mb-3"><i class="fas fa-file-alt me-2"></i>Transcript</h4>
        <button class="btn btn-warning" onclick="window.print()"><i class="fas fa-print"></i> Print</button>
    </div>

    <div class="bg-dark text-white border border-warning p-4 rounded" style="max-width: 800px;">
        <h5 class="mb-2">🎓 <?= htmlspecialchars($student['full_name']) ?></h5>
        <p class="mb-1"><strong>Reg No:</strong> <?= htmlspecialchars($student['reg_no']) ?></p>
        <p class="mb-3"><strong>Department:</strong> <?= htmlspecialchars($student['department_name']) ?></p>

        <table class="table table-dark table-bordered">
            <thead>
                <tr>
                    <th>Subject</th>
                    <th>Grade</th>
                    <th>GPA</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($results) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($results)): ?>
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

        <h5 class="mt-3">🎯 Overall GPA: <span class="text-warning"><?= $gpa ?></span></h5>
    </div>
</div>

<?php include '../include/footer.php';?>
