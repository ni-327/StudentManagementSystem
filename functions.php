<script>
    function logAction($conn, $user_id, $role, $action) {
    $stmt = $conn->prepare("INSERT INTO logs (User_ID, Role, Action) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $user_id, $role, $action);
    $stmt->execute();
}
</script>