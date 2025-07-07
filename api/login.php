<?php

include '../config/db.php';
include '../config/jwt_secret.php';
require_once '../vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$data = json_decode(file_get_contents("php://input"), true);

$email = $data['email'];
$password = $data['password'];


if (empty($email) || empty($password)) {
    echo json_encode(["success" => false, "message" => "Email and password are required."]);
    exit;
}


$query = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo json_encode(["success" => false, "message" => "No user found."]);
    exit;
}

$user = $result->fetch_assoc();


if (!password_verify($password, $user['password'])) {
    echo json_encode(["success" => false, "message" => "Wrong password."]);
    exit;
}

//Create JWT token
$payload = [
    "id" => $user['id'],
    "email" => $user['email'],
    "time" => time()
];

$token = JWT::encode($payload, $jwtSecretKey, 'HS256');

//Send response
echo json_encode([
    "success" => true,
    "message" => "Login successful",
    "token" => $token
]);
exit;
?>
