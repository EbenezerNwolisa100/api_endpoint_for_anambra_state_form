<?php
header('Access-Control-Allow-Origin: http://localhost:5173');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Access-Control-Allow-Credentials: true');

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit;
}

// Admin credentials (hardcoded or store them securely in a database)
$adminEmail = 'admin@example.com'; // Change to your actual admin email
$adminPassword = password_hash('adminPassword', PASSWORD_DEFAULT); // Securely hashed password

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postData = json_decode(file_get_contents("php://input"), true);
    $email = $conn->real_escape_string($postData['email']);
    $password = $postData['password'];

    // Check if email and password match the admin credentials
    if ($email === $adminEmail && password_verify($password, $adminPassword)) {
        echo json_encode(['status' => 'success', 'message' => 'Admin login successful']);
        exit;
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid admin credentials']);
    }
}

$conn->close();
?>
