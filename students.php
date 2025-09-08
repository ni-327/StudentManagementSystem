<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'lecturer') {
    header("Location: ../auth/login.php");
    exit;
}

include '../includes/db.php';
include 'include/header.php';
include 'include/sidebar.php';
include 'include/topbar.php';

$lecturer_id = $_SESSION['user_id'] ?? 0;

// Fetch students related to lecturer's subjects
$students = $conn->query("
    SELECT DISTINCT st.student_id, st.name, st.email, st.student_number,
                    d.name AS department_name, sem.name AS semester_name,
                    st.department_id, st.semester_id
    FROM student st
    JOIN department d ON st.department_id = d.department_id
    JOIN semester sem ON st.semester_id = sem.semester_id
    JOIN subject sub ON sub.department_id = st.department_id 
                    AND sub.semester_id = st.semester_id 
                    AND sub.lecturer_id = $lecturer_id
    ORDER BY st.name ASC
");
?>

<div class="container-fluid px-4">
  <div class="card bg-dark border-secondary shadow rounded-4 text-white">
    <div class="card-header bg-gradient text-white" style="background: linear-gradient(90deg, #0d6efd, #6610f2);">
      <h4 class="mb-0"><i class="fas fa-user-graduate me-2"></i>My Students</h4>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-dark table-striped table-bordered align-middle">
          <thead class="table-light text-dark">
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Student No</th>
              <th>Email</th>
              <th>Department</th>
              <th>Semester</th>
              <th>Subjects Taught</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $count = 1;
            if ($students && $students->num_rows > 0):
              while ($row = $students->fetch_assoc()):
                $student_id = $row['student_id'];
                $dep_id = $row['department_id'];
                $sem_id = $row['semester_id'];

                // Fetch subjects taught to this student by this lecturer
                $subject_names = [];
                $subjects_sql = "
                    SELECT subject_name 
                    FROM subject 
                    WHERE lecturer_id = $lecturer_id 
                      AND department_id = $dep_id 
                      AND semester_id = $sem_id
                ";
                $subjects_result = $conn->query($subjects_sql);
                if ($subjects_result && $subjects_result->num_rows > 0) {
                    while ($sub = $subjects_result->fetch_assoc()) {
                        $subject_names[] = $sub['subject_name'];
                    }
                }
            ?>
              <tr>
                <td><?= $count++ ?></td>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['student_number']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['department_name']) ?></td>
                <td><?= htmlspecialchars($row['semester_name']) ?></td>
                <td>
                  <?= !empty($subject_names) ? implode(', ', $subject_names) : '<span class="text-warning">No subjects</span>' ?>
                </td>
                <td>
                  <a href="add_results.php?student_id=<?= $student_id ?>&semester_id=<?= $sem_id ?>" class="btn btn-sm btn-success">
                    <i class="fas fa-plus-circle"></i> Add Result
                  </a>
                </td>
              </tr>
            <?php endwhile; else: ?>
              <tr>
                <td colspan="8" class="text-center text-warning">No students found.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php include 'include/footer.php'; ?>
