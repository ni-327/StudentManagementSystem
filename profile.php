<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'student') {
    header("Location: ../auth/login.php");
    exit;
}

include '../includes/db.php'; // DB connection

$student_id = intval($_SESSION['user_id']); // session from login

// Fetch student details
$query = "SELECT s.full_name, s.registration_number, s.email, s.phone, s.address, d.department_id
          FROM student s
          JOIN department d ON s.department_id = d.department_id
          WHERE s.student_id = $student_id";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $student = mysqli_fetch_assoc($result);
} else {
    echo "Unable to fetch profile data: " . mysqli_error($conn);
    exit;
}
?>

<?php include 'include/header.php'; ?>
<?php include 'include/sidebar.php'; ?>
<?php include 'include/topbar.php'; ?>

<div style="margin-left:250px; padding-top:70px; padding:20px;">
    <h3 class="text-white mb-4"><i class="fas fa-user-circle me-2"></i>My Profile</h3>

    <div class="card bg-dark text-white shadow border border-secondary" style="max-width: 600px;">
        <div class="card-body">
            <p><strong>Full Name:</strong> <?= htmlspecialchars($student['full_name']) ?></p>
            <p><strong>Registration No:</strong> <?= htmlspecialchars($student['registration_number']) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($student['email']) ?></p>
            <p><strong>Phone:</strong> <?= htmlspecialchars($student['phone']) ?></p>
            <p><strong>Department:</strong> <?= htmlspecialchars($student['department_id']) ?></p>
            <p><strong>Address:</strong> <?= htmlspecialchars($student['address']) ?></p>
        </div>
    </div>
</div>

<?php include 'include/footer.php';?>