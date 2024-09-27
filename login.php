<?php
header('Access-Control-Allow-Origin: http://localhost:5173');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Access-Control-Allow-Credentials: true');

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit;
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postData = json_decode(file_get_contents("php://input"), true);
    $email = $conn->real_escape_string($postData['email']);
    $password = $postData['password'];

    // Query for indigenes table
    $sql_indigenes = "SELECT * FROM indigenes_submissions WHERE email = '$email'";
    $result_indigenes = $conn->query($sql_indigenes);
    
    if ($result_indigenes->num_rows > 0) {
        $user = $result_indigenes->fetch_assoc();
        // Verify the password
        if (password_verify($password, $user['password'])) {
            echo json_encode(['status' => 'success', 'message' => 'Login successful', 'ibad_id' => $user['ibad_id']]);
            exit;
        }
    }

    // Check non-indigenes table
    $sql_nonindigenes = "SELECT * FROM nonindigenes_submissions WHERE email = '$email'";
    $result_nonindigenes = $conn->query($sql_nonindigenes);
    
    if ($result_nonindigenes->num_rows > 0) {
        $user = $result_nonindigenes->fetch_assoc();
        // Verify the password
        if (password_verify($password, $user['password'])) {
            echo json_encode(['status' => 'success', 'message' => 'Login successful', 'ibad_id' => $user['ibad_id']]);
            exit;
        }
    }

    echo json_encode(['status' => 'error', 'message' => 'Invalid email or password']);
}

$conn->close();
?>
