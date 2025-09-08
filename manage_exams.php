<?php
session_start();
include '../includes/db.php';
include 'include/header.php';
include 'include/sidebar.php';
include 'include/topbar.php';

// Get lecturer ID from session
$lecturer_id = $_SESSION['user_id'] ?? 0;

// Fetch exams related to lecturer's subjects
$sql = "SELECT e.exam_id, e.name AS exam_name, e.exam_date, 
               s.name AS subject_name, sem.name AS semester_name
        FROM exam e
        JOIN subject s ON e.subject_id = s.subject_id
        JOIN semester sem ON e.semester_id = sem.semester_id
        WHERE s.lecturer_id = $lecturer_id
        ORDER BY e.exam_date ASC";

$result = mysqli_query($conn, $sql);
?>

<div class="container-fluid">
  <h4 class="text-white mb-4"><i class="fas fa-calendar-alt me-2"></i>My Exams</h4>

  <div class="table-responsive">
    <table class="table table-dark table-striped table-bordered">
      <thead>
        <tr>
          <th>#</th>
          <th>Exam Name</th>
          <th>Subject</th>
          <th>Semester</th>
          <th>Exam Date</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $count = 1;
        if ($result && mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$count}</td>
                    <td>{$row['exam_name']}</td>
                    <td>{$row['subject_name']}</td>
                    <td>{$row['semester_name']}</td>
                    <td>" . date('Y-m-d', strtotime($row['exam_date'])) . "</td>
                  </tr>";
            $count++;
          }
        } else {
          echo "<tr><td colspan='5' class='text-center text-warning'>No exams found.</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
</div>

<?php include 'include/footer.php'; ?>
