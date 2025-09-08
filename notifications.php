<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'lecturer') {
    header("Location: ../auth/login.php");
    exit;
}

include 'include/header.php';
include 'include/sidebar.php';
include 'include/topbar.php';
include '../includes/db.php';

$lecturer_id = $_SESSION['user_id'];
$message = "";

// Handle notification submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $body = mysqli_real_escape_string($conn, $_POST['body']);

    $query = "INSERT INTO notifications (lecturer_id, title, body, created_at) 
              VALUES ($lecturer_id, '$title', '$body', NOW())";

    if (mysqli_query($conn, $query)) {
        $message = "<div class='alert alert-success'>Notification sent successfully!</div>";
    } else {
        $message = "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
    }
}

// Fetch sent notifications
$notifications = mysqli_query($conn, "SELECT * FROM notifications WHERE lecturer_id = $lecturer_id ORDER BY created_at DESC");
?>

<div class="content-wrapper">
    <h3 class="text-white mb-4"><i class="fas fa-bell me-2"></i>Notifications</h3>

    <?= $message ?>

    <div class="card bg-dark text-white border border-secondary mb-4" style="max-width: 600px;">
        <div class="card-body">
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" required maxlength="100">
                </div>
                <div class="mb-3">
                    <label class="form-label">Message</label>
                    <textarea name="body" class="form-control" rows="4" required></textarea>
                </div>
                <button type="submit" class="btn btn-outline-info">Send Notification</button>
            </form>
        </div>
    </div>

    <h5 class="text-white">📜 Sent Notifications</h5>
    <?php if (mysqli_num_rows($notifications) > 0): ?>
        <ul class="list-group">
            <?php while ($note = mysqli_fetch_assoc($notifications)): ?>
                <li class="list-group-item bg-dark text-white border-secondary mb-2">
                    <strong><?= htmlspecialchars($note['title']) ?></strong><br>
                    <?= nl2br(htmlspecialchars($note['body'])) ?><br>
                    <small class="text-muted">Sent on: <?= $note['created_at'] ?></small>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p class="text-secondary">No notifications sent yet.</p>
    <?php endif; ?>
</div>

<?php include 'include/footer.php';?>
