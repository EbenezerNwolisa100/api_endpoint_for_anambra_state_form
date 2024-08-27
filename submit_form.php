<?php
header('Access-Control-Allow-Origin: http://localhost:5173');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Access-Control-Allow-Credentials: true');

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    header("Access-Control-Allow-Origin: *"); // Allows requests from any origin
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); // Allows specific methods
    header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Allows specific headers
    exit;
}

// Allow CORS for the actual request
header("Access-Control-Allow-Origin: *"); // Allows requests from any origin
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); // Allows specific methods
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Allows specific headers

include 'config.php';

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the raw POST data
    $postData = json_decode(file_get_contents("php://input"), true);

    // Extract data from the POST request
    $surname = $conn->real_escape_string($postData['surname']);
    $first_name = $conn->real_escape_string($postData['first_name']);
    $middle_name = $conn->real_escape_string($postData['middle_name']);
    $date_of_birth = $conn->real_escape_string($postData['date_of_birth']);
    $gender = $conn->real_escape_string($postData['gender']);
    $marital_status = $conn->real_escape_string($postData['marital_status']);
    $spouse_name = $conn->real_escape_string($postData['spouse_name']);
    $spouse_phone_number = $conn->real_escape_string($postData['spouse_phone_number']);
    $country_of_residence = $conn->real_escape_string($postData['country_of_residence']);
    $state_of_residence = $conn->real_escape_string($postData['state_of_residence']);
    $state_of_origin = $conn->real_escape_string($postData['state_of_origin']);
    $lga_of_residence = $conn->real_escape_string($postData['lga_of_residence']);
    $lga_of_origin = $conn->real_escape_string($postData['lga_of_origin']);
    $community_of_origin = $conn->real_escape_string($postData['community_of_origin']);
    $village = $conn->real_escape_string($postData['village']);
    $tribe = $conn->real_escape_string($postData['tribe']);
    $kindred = $conn->real_escape_string($postData['kindred']);
    $employment_status = $conn->real_escape_string($postData['employment_status']);
    $occupation = $conn->real_escape_string($postData['occupation']);
    $phone_number = $conn->real_escape_string($postData['phone_number']);
    $alternate_phone_number = $conn->real_escape_string($postData['alternate_phone_number']);
    $phone_on_whatsapp = $conn->real_escape_string($postData['phone_on_whatsapp']);
    $alternate_on_whatsapp = $conn->real_escape_string($postData['alternate_on_whatsapp']);
    $next_of_kin = $conn->real_escape_string($postData['next_of_kin']);
    $next_of_kin_phone_number = $conn->real_escape_string($postData['next_of_kin_phone_number']);
    $valid_means_of_identification = $conn->real_escape_string($postData['valid_means_of_identification']);
    $valid_identification_number = $conn->real_escape_string($postData['valid_identification_number']);
    $submission_type = $conn->real_escape_string($postData['submission_type']);
    $agreePrivacyPolicy = $conn->real_escape_string($postData['agreePrivacyPolicy']);
    
    // SQL query to insert data into the submissions table
    $sql = "INSERT INTO submissions (
                surname, first_name, middle_name, date_of_birth, gender,
                marital_status, spouse_name, spouse_phone_number, country_of_residence,
                state_of_residence, lga_of_residence, lga_of_origin, community_of_origin,
                village, kindred, employment_status, occupation, phone_number, phone_on_whatsapp, alternate_on_whatsapp,
                alternate_phone_number, next_of_kin, next_of_kin_phone_number, state_of_origin, tribe,
                valid_means_of_identification, valid_identification_number, submission_type, agreePrivacyPolicy
            ) VALUES (
                '$surname', '$first_name', '$middle_name', '$date_of_birth', '$gender',
                '$marital_status', '$spouse_name', '$spouse_phone_number', '$country_of_residence',
                '$state_of_residence', '$lga_of_residence', '$lga_of_origin', '$community_of_origin',
                '$village', '$kindred', '$employment_status', '$occupation', '$phone_number', '$state_of_origin', '$tribe',                
                '$alternate_phone_number', '$next_of_kin', '$next_of_kin_phone_number', '$phone_on_whatsapp', '$alternate_on_whatsapp',                
                '$valid_means_of_identification', '$valid_identification_number', '$submission_type', '$agreePrivacyPolicy'
            )";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["status" => "success", "message" => "Data submitted successfully."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error: " . $conn->error]);
    }

    // Close the database connection
    $conn->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}
?>
