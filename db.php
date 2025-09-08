<?php
// db.php

$host = 'localhost';      // or 127.0.0.1
$username = 'root';       // default username for XAMPP
$password = '';           // default password is empty in XAMPP
$database = 'student_management_db'; // replace with your actual database name

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Optional: set character set to utf8mb4
$conn->set_charset("utf8mb4");
?>
