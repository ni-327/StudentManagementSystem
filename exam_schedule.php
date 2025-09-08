<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'lecturer') {
    header("Location: ../auth/login.php");
    exit();
}

if (!isset($_SESSION['lecturer_id'])) {
    die("<div class='text-danger'>Error: lecturer_id is not set in session.</div>");
}

$_SESSION['user_role'] = 'lecturer'; // Already working for you

include '../includes/db.php';
include 'include/header.php';
include 'include/sidebar.php';
include 'include/topbar.php';

// Prepare the SQL
$sql = "SELECT e.exam_id, e.exam_name, e.exam_date, e.semester, s.subject_name
        FROM exam e
        JOIN subject s ON e.subject_id = s.subject_id
        JOIN lecturer_subject ls ON s.subject_id = ls.subject_id
        WHERE ls.lecturer_id = ?
        ORDER BY e.exam_date ASC";

// Prepare and check for errors
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("SQL Error: " . $conn->error);
}
$stmt->bind_param("i", $lecturer_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="container mt-4">
    <h2 class="text-white">My Exam Schedule</h2>

    <?php if ($result->num_rows > 0): ?>
        <table class="table table-dark table-striped mt-3">
            <thead>
                <tr>
                    <th>Exam Name</th>
                    <th>Subject</th>
                    <th>Semester</th>
                    <th>Exam Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['exam_name']) ?></td>
                    <td><?= htmlspecialchars($row['subject_name']) ?></td>
                    <td><?= htmlspecialchars($row['semester']) ?></td>
                    <td><?= htmlspecialchars($row['exam_date']) ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-info">No upcoming exams found for your subjects.</div>
    <?php endif; ?>
</div>

<?php include 'include/footer.php'; ?>
