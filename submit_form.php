<?php


header('Access-Control-Allow-Origin: http://localhost:5173');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Access-Control-Allow-Credentials: true');

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");
    exit;
}

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postData = json_decode(file_get_contents("php://input"), true);

    // ... (existing code to extract and escape input data)
    $surname = $conn->real_escape_string($postData['surname']);
    $first_name = $conn->real_escape_string($postData['first_name']);
    $middle_name = $conn->real_escape_string($postData['middle_name']);
    $date_of_birth = $conn->real_escape_string($postData['date_of_birth']);
    $email = $conn->real_escape_string($postData['email']);
    $password = $conn->real_escape_string($postData['password']);
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
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    // Generate IBAD ID
    $ibad_id = 'IBAD-' . time() . '-' . rand(1000, 9999);

    // Determine the table based on submission type
    $table_name = $submission_type === 'indigene' ? 'indigenes_submissions' : 'nonindigenes_submissions';

    // Update SQL query to include ibad_id
    $sql = "INSERT INTO $table_name (
                ibad_id, surname, first_name, middle_name, date_of_birth, email, password, gender,
                marital_status, spouse_name, spouse_phone_number, country_of_residence,
                state_of_residence, lga_of_residence, lga_of_origin, community_of_origin,
                village, kindred, employment_status, occupation, phone_number, phone_on_whatsapp, alternate_on_whatsapp,
                alternate_phone_number, next_of_kin, next_of_kin_phone_number, state_of_origin, tribe,
                valid_means_of_identification, valid_identification_number, agreePrivacyPolicy
            ) VALUES (
                '$ibad_id', '$surname', '$first_name', '$middle_name', '$date_of_birth', '$email', '$hashed_password', '$gender',
                '$marital_status', '$spouse_name', '$spouse_phone_number', '$country_of_residence',
                '$state_of_residence', '$lga_of_residence', '$lga_of_origin', '$community_of_origin',
                '$village', '$kindred', '$employment_status', '$occupation', '$phone_number', '$phone_on_whatsapp', '$alternate_on_whatsapp',
                '$alternate_phone_number', '$next_of_kin', '$next_of_kin_phone_number', '$state_of_origin', '$tribe',
                '$valid_means_of_identification', '$valid_identification_number', '$agreePrivacyPolicy'
            )";

        // if ($conn->query($sql) === TRUE) {
        //     echo json_encode(['message' => 'Form submitted successfully', 'ibad_id' => $ibad_id]);
        // } else {
        //     echo json_encode(['error' => 'Error: ' . $conn->error]);
        // }


        if ($conn->query($sql) === TRUE) {
            echo json_encode(['message' => 'Form submitted successfully', 'ibad_id' => $ibad_id]);
        } else {
            // Add the actual SQL query to the error output for better debugging
            echo json_encode(['error' => 'SQL Error: ' . $conn->error, 'query' => $sql]);
        }
    }

$conn->close();

?>
