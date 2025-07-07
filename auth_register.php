<?php
session_start();

//Get form data
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$phone = $_POST['phone'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($name) || empty($email) || empty($phone) || empty($password)) {
    $_SESSION['reg_error'] = "All fields are required.";
    header("Location: register.php");
    exit;
}

//Send POST request to your register API
$apiUrl = 'http://localhost/authPHP/api/register.php';

$data = [
    'name' => $name,
    'email' => $email,
    'phone' => $phone,
    'password' => $password
];

$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type:application/json']);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

//Check response
$result = json_decode($response, true);

if ($result['success']) {
    // Registration successful-- go to login
    header("Location: login.php");
    exit;
} else {
    // Registration failed--show error
    $_SESSION['reg_error'] = $result['message'] ?? 'Registration failed.';
    header("Location: register.php");
    exit;
}
