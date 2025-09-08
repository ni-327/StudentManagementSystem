<?php
session_start();
include '../config/db.php';

$student_id = $_SESSION['student_id'] ?? 0;

$sql = "SELECT * FROM notifications WHERE student_id = $student_id ORDER BY created_at DESC LIMIT 5";
$result = mysqli_query($conn, $sql);

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = [
        'message' => $row['message'],
        'time' => date('h:i A', strtotime($row['created_at']))
    ];
}

$count_sql = "SELECT COUNT(*) AS unread_count FROM notifications WHERE student_id = $student_id AND is_read = 0";
$count_result = mysqli_query($conn, $count_sql);
$count_row = mysqli_fetch_assoc($count_result);

echo json_encode([
    'notifications' => $data,
    'unread' => $count_row['unread_count']
]);
?>