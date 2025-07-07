<?php

include '../config/db.php';
include '../config/jwt_secret.php';
require_once '../vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

//Verify JWT Token
$headers = getallheaders();
$authHeader = $headers['Authorization'] ?? '';

if (!$authHeader) {
    echo json_encode(["success" => false, "message" => "Authorization header missing."]);
    exit;
}

$parts = explode(" ", $authHeader);
$token = $parts[1] ?? '';

if (empty($token)) {
    echo json_encode(["success" => false, "message" => "Token not found."]);
    exit;
}

try {
    $decoded = JWT::decode($token, new Key($jwtSecretKey, 'HS256'));
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => "Invalid token."]);
    exit;
}

//Read input data
$data = json_decode(file_get_contents("php://input"), true);

$id = $data['id'];
$name = $data['name'];
$email = $data['email'];
$phone = $data['phone'];
$password = $data['password'] ?? null;

//Validate inputs
if (empty($id) || empty($name) || empty($email)) {
    echo json_encode(["success" => false, "message" => "Id, name, and email are required."]);
    exit;
}

//Prepare update query
if (!empty($password)) {
    // If password is provided, update it too
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $query = "UPDATE users SET name = ?, email = ?, phone_number = ?, password = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssi", $name, $email, $phone, $hashedPassword, $id);
} else {
    // If no password change
    $query = "UPDATE users SET name = ?, email = ?, phone_number = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssi", $name, $email, $phone, $id);
}

//Execute the query
if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "User updated successfully."]);
} else {
    echo json_encode(["success" => false, "message" => "Failed to update user."]);
}

exit;
?>
