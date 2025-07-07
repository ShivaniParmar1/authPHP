<?php
include '../config/db.php';
include '../config/jwt_secret.php';
require_once '../vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

//Read JWT token from request header
$headers = getallheaders();
$authHeader = $headers['Authorization'] ?? '';

if (!$authHeader) {
    echo json_encode(["success" => false, "message" => "Authorization header missing."]);
    exit;
}

//Extract token from "Bearer <token>"
$parts = explode(" ", $authHeader);
$token = $parts[1] ?? '';

if (empty($token)) {
    echo json_encode(["success" => false, "message" => "Token not found."]);
    exit;
}

//Verify token
try {
    $decoded = JWT::decode($token, new Key($jwtSecretKey, 'HS256'));
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => "Invalid token."]);
    exit;
}

//Get all users from database
$sql = "SELECT id, name, email, phone_number FROM users";
$result = $conn->query($sql);

$users = [];

while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}

//Send users in response
echo json_encode([
    "success" => true,
    "message" => "Users fetched successfully.",
    "data" => $users
]);
exit;
?>
