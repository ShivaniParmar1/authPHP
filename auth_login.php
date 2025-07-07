<?php
session_start();
include 'config/db.php';
require_once 'vendor/autoload.php';
include 'config/jwt_secret.php';

use Firebase\JWT\JWT;

//Get email & password from form
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($email) || empty($password)) {
    $_SESSION['error'] = "Email and password are required.";
    header("Location: login.php");
    exit;
}

//find user by email
$query = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['error'] = "Invalid email or password.";
    header("Location: login.php");
    exit;
}

$user = $result->fetch_assoc();

//Check password
if (!password_verify($password, $user['password'])) {
    $_SESSION['error'] = "Invalid email or password.";
    header("Location: login.php");
    exit;
}

//Create JWT token
$_SESSION['user_id'] = $user['id'];
$_SESSION['user_name'] = $user['name'];

//Redirect to dashboard
header("Location: dashboard.php");
exit;
?>
