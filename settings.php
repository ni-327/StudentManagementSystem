<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'student') {
    header("Location: ../auth/login.php");
    exit;
}

include '../includes/db.php';

$student_id = intval($_SESSION['user_id']);
$success = '';
$error = '';

// Update password
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_password'])) {
    $current = mysqli_real_escape_string($conn, $_POST['current_password']);
    $new = mysqli_real_escape_string($conn, $_POST['new_password']);
    $confirm = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    // Get existing password
    $check = mysqli_query($conn, "SELECT password FROM student WHERE student_id = $student_id");
    $data = mysqli_fetch_assoc($check);

    if (!password_verify($current, $data['password'])) {
        $error = "❌ Current password is incorrect.";
    } elseif ($new !== $confirm) {
        $error = "❌ New passwords do not match.";
    } else {
        $hashed = password_hash($new, PASSWORD_DEFAULT);
        mysqli_query($conn, "UPDATE student SET password = '$hashed' WHERE student_id = $student_id");
        $success = "✅ Password updated successfully.";
    }
}
?>

<?php include 'include/header.php'; ?>
<?php include 'include/sidebar.php'; ?>
<?php include 'include/topbar.php'; ?>

<div style="margin-left:250px; padding-top:70px; padding:20px;">
    <h4 class="text-white mb-4"><i class="fas fa-cog me-2"></i>Account Settings</h4>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php elseif ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <div class="card bg-dark text-white shadow border border-secondary" style="max-width: 600px;">
        <div class="card-body">
            <h5 class="mb-3">🔒 Change Password</h5>
            <form method="POST">
                <div class="mb-3">
                    <label>Current Password</label>
                    <input type="password" name="current_password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>New Password</label>
                    <input type="password" name="new_password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Confirm New Password</label>
                    <input type="password" name="confirm_password" class="form-control" required>
                </div>
                <button type="submit" name="change_password" class="btn btn-warning">Update Password</button>
            </form>
        </div>
    </div>
</div>

<?php include 'include/footer.php';?>