<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'lecturer') {
    header("Location: ../auth/login.php");
    exit;
}

include '../includes/db.php'; // Make sure $conn is available
include 'include/header.php';
include 'include/sidebar.php';
include 'include/topbar.php';

$lecturer_id = $_SESSION['user_id'];
?>

<div class="container mt-4">
    <h2 class="text-white">Enter Student Results</h2>

    <!-- Subject Dropdown -->
    <form method="GET" class="mb-4">
        <label for="subject_id" class="form-label text-white">Select Subject:</label>
        <select name="subject_id" class="form-select" required>
            <option value="">-- Choose --</option>
            <?php
            $sql = "SELECT s.subject_id, s.subject_name 
                    FROM subject s
                    JOIN lecturer_subject ls ON s.subject_id = ls.subject_id
                    WHERE ls.lecturer_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $lecturer_id);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $selected = (isset($_GET['subject_id']) && $_GET['subject_id'] == $row['subject_id']) ? "selected" : "";
                echo "<option value='{$row['subject_id']}' $selected>{$row['subject_name']}</option>";
            }
            ?>
        </select>
        <button type="submit" class="btn btn-primary mt-2">Load Students</button>
    </form>

    <?php
    // If subject is selected
    if (isset($_GET['subject_id'])):
        $subject_id = $_GET['subject_id'];

        // Fetch students (customize query if you want to filter by subject)
        $sql = "SELECT student_id, name FROM student ORDER BY name ASC";
        $students = $conn->query($sql);
    ?>

    <form method="POST">
        <input type="hidden" name="subject_id" value="<?= htmlspecialchars($subject_id) ?>">

        <table class="table table-dark table-striped">
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Semester</th>
                    <th>Year</th>
                    <th>Marks</th>
                    <th>Grade</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($stu = $students->fetch_assoc()): ?>
                <tr>
                    <td>
                        <?= htmlspecialchars($stu['name']) ?>
                        <input type="hidden" name="student_ids[]" value="<?= $stu['student_id'] ?>">
                    </td>
                    <td><input type="text" name="semester_<?= $stu['student_id'] ?>" class="form-control" required></td>
                    <td><input type="number" name="year_<?= $stu['student_id'] ?>" class="form-control" required></td>
                    <td><input type="number" step="0.01" name="marks_<?= $stu['student_id'] ?>" class="form-control" required></td>
                    <td><input type="text" name="grade_<?= $stu['student_id'] ?>" class="form-control" required></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <button type="submit" name="save_results" class="btn btn-success">Save Results</button>
    </form>

    <?php endif; ?>

    <?php
    // Save Logic
    if (isset($_POST['save_results'])) {
        $subject_id = $_POST['subject_id'];
        foreach ($_POST['student_ids'] as $student_id) {
            $semester = $_POST['semester_' . $student_id];
            $year = $_POST['year_' . $student_id];
            $marks = $_POST['marks_' . $student_id];
            $grade = $_POST['grade_' . $student_id];

            $stmt = $conn->prepare("INSERT INTO result (student_id, subject_id, semester, year, marks, grade)
                                    VALUES (?, ?, ?, ?, ?, ?)
                                    ON DUPLICATE KEY UPDATE marks = VALUES(marks), grade = VALUES(grade)");
            $stmt->bind_param("iisiis", $student_id, $subject_id, $semester, $year, $marks, $grade);
            $stmt->execute();
        }
        echo "<div class='alert alert-success mt-3'>Results saved successfully!</div>";
    }
    ?>

</div>

<?php include 'include/footer.php'; ?>
