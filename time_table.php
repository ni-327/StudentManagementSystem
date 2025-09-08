<?php
session_start();
include '../includes/db.php';
include 'include/header.php';
include 'include/sidebar.php';
include 'include/topbar.php';

$lecturer_id = $_SESSION['user_id'] ?? 0;

$sql = "SELECT e.exam_date, e.name AS exam_name, s.subject_name AS subject_name
        FROM exam e
        JOIN subject s ON e.subject_id = s.subject_id
        WHERE s.lecturer_id = $lecturer_id
        ORDER BY e.exam_date ASC";

$result = mysqli_query($conn, $sql);

// 💥 DEBUG if SQL fails
if (!$result) {
    die('SQL Error: ' . mysqli_error($conn));
}

?>

<div class="container-fluid">
  <h4 class="text-white mb-4">📅 Timetable</h4>

  <div class="table-responsive">
    <table class="table table-dark table-striped table-bordered">
      <thead>
        <tr>
          <th>#</th>
          <th>Date</th>
          <th>Subject</th>
          <th>Exam Name</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $count = 1;
        if (mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$count}</td>
                    <td>" . date('Y-m-d', strtotime($row['exam_date'])) . "</td>
                    <td>{$row['subject_name']}</td>
                    <td>{$row['exam_name']}</td>
                  </tr>";
            $count++;
          }
        } else {
          echo "<tr><td colspan='4' class='text-center text-warning'>No upcoming schedule found.</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
</div>

<?php include 'include/footer.php'; ?>
