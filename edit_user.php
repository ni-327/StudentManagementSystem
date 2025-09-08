<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

require_once '../includes/db.php';

$user_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$message = "";

// Fetch user details
$stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    die("❌ User not found.");
}
$user = $result->fetch_assoc();

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $role = $_POST['role'];
    $password = $_POST['password'];

    // Update password only if entered
    if (!empty($password)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET Username = ?, Password = ?, Role = ? WHERE user_id = ?");
        $stmt->bind_param("sssi", $username, $hashedPassword, $role, $user_id);
    } else {
        $stmt = $conn->prepare("UPDATE users SET Username = ?, Role = ? WHERE user_id = ?");
        $stmt->bind_param("ssi", $username, $role, $user_id);
    }

    if ($stmt->execute()) {
        $message = "<div class='alert alert-success'>✅ User updated successfully.</div>";
        $user['Username'] = $username;
        $user['Role'] = $role;
    } else {
        $message = "<div class='alert alert-danger'>❌ Failed to update user.</div>";
    }
}

include '../admin/includes/header.php';
?>

<style>
body {
    background-color: #121212;
    color: #fff;
}
.card {
    background-color: #1e1e1e;
    border: none;
}
.card-header {
    background-color: #0d6efd;
    color: white;
}
.form-control, .form-select {
    background-color: #2c2c2c;
    color: #fff;
    border: 1px solid #444;
}
.form-control::placeholder {
    color: #aaa;
}
</style>

<div class="container-fluid">
  <div class="row">
    <!-- Sidebar -->
    <div class="col-md-2 p-0">
      <?php include("../admin/includes/sidebar.php"); ?>
    </div>

    <main class="col-md-10 p-4">
      <div class="card shadow-lg text-white">
        <div class="card-header">
          <h4 class="mb-0"><i class="fas fa-user-edit me-2"></i>Edit User</h4>
        </div>
        <div class="card-body">
          <?= $message ?>

          <form method="POST">
        <div class="mb-3">
        <label class="form-label text-white">Username</label>
        <input type="text" name="username" class="form-control" 
                value="<?= htmlspecialchars($user['Username']) ?>" readonly>
        </div>

        <div class="mb-3">
        <label class="form-label text-white">Password</label>
        <div class="input-group">
            <input type="password" name="password" id="passwordField" class="form-control" placeholder="New password (optional)">
            <button type="button" class="btn btn-outline-secondary" onclick="resetPassword()">Reset</button>
        </div>
        <small class="form-text text-muted text-white-50">Click "Reset" to set password to <code>1234</code>.</small>
        </div>

        <script>
        function resetPassword() {
            document.getElementById('passwordField').value = '1234';
        }
        </script>


            <div class="mb-3">
              <label class="form-label text-white">Role</label>
              <select name="role" class="form-select" required>
                <option value="admin" <?= $user['Role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                <option value="lecturer" <?= $user['Role'] === 'lecturer' ? 'selected' : '' ?>>Lecturer</option>
                <option value="student" <?= $user['Role'] === 'student' ? 'selected' : '' ?>>Student</option>
              </select>
            </div>

            <div class="d-flex justify-content-between">
              <a href="manage_user.php" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back
              </a>
              <button type="submit" class="btn btn-success">
                <i class="fas fa-save me-1"></i> Update User
              </button>
            </div>
          </form>
        </div>
      </div>
    </main>
  </div>
</div>

<?php include '../admin/includes/footer.php'; ?>
