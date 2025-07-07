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

// Read input data
$data = json_decode(file_get_contents("php://input"), true);

$id = $data['id'] ?? '';

if (empty($id)) {
    echo json_encode(["success" => false, "message" => "User ID is required."]);
    exit;
}

//Delete user by ID
$query = "DELETE FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "User deleted successfully."]);
} else {
    echo json_encode(["success" => false, "message" => "Failed to delete user."]);
}

exit;
?>
