<?php
header('Access-Control-Allow-Origin: http://localhost:5173');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Access-Control-Allow-Credentials: true');

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postData = json_decode(file_get_contents("php://input"), true);
    $submissionType = $conn->real_escape_string($postData['type']);

    // Fetch indigenes or non-indigenes submissions based on the request
    if ($submissionType === 'indigenes') {
        $sql = "SELECT * FROM indigenes_submissions";
    } elseif ($submissionType === 'non-indigenes') {
        $sql = "SELECT * FROM nonindigenes_submissions";
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid submission type']);
        exit;
    }

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $submissions = [];
        while ($row = $result->fetch_assoc()) {
            $submissions[] = $row;
        }
        echo json_encode(['status' => 'success', 'data' => $submissions]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No submissions found']);
    }
}

$conn->close();
?>
