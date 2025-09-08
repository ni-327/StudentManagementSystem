<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

require_once '../includes/db.php';
$message = "";

// Handle Add User
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_user'])) {
    $username = trim($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role     = $_POST['role'];

    // Check if username already exists
    $check = $conn->prepare("SELECT 1 FROM users WHERE Username = ?");
    $check->bind_param("s", $username);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $message = "<div class='alert alert-danger'>❌ Username already exists.</div>";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (Username, Password, Role) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $password, $role);
        if ($stmt->execute()) {
            $message = "<div class='alert alert-success'>✅ User added successfully.</div>";
        } else {
            $message = "<div class='alert alert-danger'>❌ Error adding user.</div>";
        }
    }
}

// Handle Delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM users WHERE user_id = $id");
    $message = "<div class='alert alert-warning'>🗑 User deleted.</div>";
}

// Fetch all users
$users = $conn->query("SELECT * FROM users");

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
.table-dark {
    background-color: #1a1a1a;
}
.table thead {
    background-color: #2d2d2d;
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
          <h4 class="mb-0"><i class="fas fa-users-cog me-2"></i> Manage Users</h4>
        </div>
        <div class="card-body">
          <?= $message ?>

          <!-- Add User Form -->
          <form method="POST" class="mb-4">
            <div class="row g-3 align-items-end">
              <div class="col-md-4">
                <label class="form-label text-white">Username</label>
                <input type="text" name="username" class="form-control" required>
              </div>
              <div class="col-md-4">
                <label class="form-label text-white">Password</label>
                <input type="password" name="password" class="form-control" required>
              </div>
              <div class="col-md-3">
                <label class="form-label text-white">Role</label>
                <select name="role" class="form-select" required>
                  <option value="">Select Role</option>
                  <option value="admin">Admin</option>
                  <option value="lecturer">Lecturer</option>
                  <option value="student">Student</option>
                </select>
              </div>
              <div class="col-md-1 d-grid">
                <button type="submit" name="add_user" class="btn btn-primary mt-md-4">
                  <i class="fas fa-plus"></i>
                </button>
              </div>
            </div>
          </form>

          <!-- User Table -->
          <table class="table table-bordered table-dark table-hover">
            <thead class="table-secondary text-dark">
              <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Role</th>
                <th class="text-center">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php while ($row = $users->fetch_assoc()): ?>
                <tr>
                  <td><?= $row['user_id'] ?></td>
                  <td><?= htmlspecialchars($row['Username']) ?></td>
                  <td><?= ucfirst($row['Role']) ?></td>
                  <td class="text-center">
                  <a href="edit_user.php?id=<?= $row['user_id'] ?>" class="btn btn-sm btn-warning me-1">
                    <i class="fas fa-edit"></i> Edit
                  </a>
                    <a href="?delete=<?= $row['user_id'] ?>" class="btn btn-danger btn-sm"
                       onclick="return confirm('Are you sure you want to delete this user?')">
                      <i class="fas fa-trash-alt"></i> Delete
                    </a>
                  </td>
                </tr>
              <?php endwhile; ?>
            </tbody>
          </table>

        </div>
      </div>
    </main>
  </div>
</div>

<?php include '../admin/includes/footer.php'; ?>
