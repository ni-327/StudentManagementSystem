<?php
session_start();
include '../config/db.php';

$student_id = $_SESSION['student_id'] ?? 0;

$sql = "DELETE FROM notifications WHERE student_id = $student_id";
if (mysqli_query($conn, $sql)) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error']);
}
?>