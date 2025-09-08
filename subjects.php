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

// ✅ FIXED SQL - Removed invalid 's.Code'
$sql = "SELECT s.Subject_ID, s.Subject_Name, d.Department_Name, sem.Semester_Name
        FROM subject s
        JOIN department d ON s.Department_ID = d.Department_ID
        JOIN semester sem ON s.Semester_ID = sem.Semester_ID
        WHERE s.Lecturer_ID = $lecturer_id
        ORDER BY sem.Semester_Name ASC";

$result = mysqli_query($conn, $sql);

// ✅ Optional: show SQL error if exists
if (!$result) {
    die("<div class='alert alert-danger'>❌ SQL Error: " . mysqli_error($conn) . "</div>");
}
?>

<div class="container-fluid px-4">
  <div class="card bg-dark text-white border-secondary shadow rounded-4">
    <div class="card-header bg-gradient text-white" style="background: linear-gradient(90deg, #0d6efd, #6610f2);">
      <h4 class="mb-0"><i class="fas fa-book me-2"></i>My Subjects</h4>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-dark table-striped table-bordered align-middle">
          <thead class="table-light text-dark">
            <tr>
              <th>#</th>
              <th>Subject Name</th>
              <th>Semester</th>
              <th>Department</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $count = 1;
            if (mysqli_num_rows($result) > 0):
              while ($row = mysqli_fetch_assoc($result)):
            ?>
              <tr>
                <td><?= $count++ ?></td>
                <td><?= htmlspecialchars($row['Subject_Name']) ?></td>
                <td><?= $row['Semester_Name'] ?></td>
                <td><?= $row['Department_Name'] ?></td>
              </tr>
            <?php endwhile; else: ?>
              <tr>
                <td colspan="4" class="text-center text-warning">No subjects assigned.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php include 'include/footer.php'; ?>
