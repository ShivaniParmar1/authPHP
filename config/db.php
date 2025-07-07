<?php
// config/db.php

$host = "localhost";
$username = "root";
$password = ""; // for XAMPP keep it empty
$database = "admin_panel"; // your database name

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Uncomment below to test connection
// echo "Database connected successfully!";
?>
