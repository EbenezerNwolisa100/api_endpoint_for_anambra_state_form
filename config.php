<?php
$servername = "localhost"; // Change this to your server
$username = "root";        // Change this to your MySQL username
$password = "";            // Change this to your MySQL password
$dbname = "ibad_submissions_db";     // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
