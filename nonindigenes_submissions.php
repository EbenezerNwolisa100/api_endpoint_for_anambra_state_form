<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include 'config.php';

$sql = "SELECT * FROM nonindigenes_submissions";
$result = $conn->query($sql);

$submissions = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $submissions[] = $row;
    }
}

echo json_encode($submissions);

$conn->close();
?>
