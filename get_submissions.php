<?php
include 'config.php';

// SQL query to fetch all submissions
$sql = "SELECT * FROM submissions";
$result = $conn->query($sql);

$submissions = [];

if ($result->num_rows > 0) {
    // Fetch data and store in an array
    while ($row = $result->fetch_assoc()) {
        $submissions[] = $row;
    }
    echo json_encode($submissions);
} else {
    echo json_encode([]);
}

// Close the database connection
$conn->close();
?>