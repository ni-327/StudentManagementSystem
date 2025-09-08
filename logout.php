<?php
session_start();
session_unset();
session_destroy();

// ✅ Correct redirection to index.php
header("Location: ../index.php");
exit;
?>