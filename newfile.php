<?php
header('Access-Control-Allow-Origin: https://ibad.asatuyouth.org');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Access-Control-Allow-Credentials: true');
header("Content-type: application/json; charset=utf-8");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");
    exit;
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';


if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['function']) && $_GET['function'] === 'welcomeMessageAll'){
    // welcomeMessageAll($who = 'indigenes');
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $postData = json_decode(file_get_contents("php://input"), true);

    include 'config.php';

    // ... (existing code to extract and escape input data)
    $surname = $postData['surname'];
    $email = $postData['email'];
    $first_name = $postData['first_name'];
    $middle_name = $postData['middle_name'];
    $date_of_birth = $postData['date_of_birth'];
    $gender = $postData['gender'];
    $marital_status = $postData['marital_status'];
    $spouse_name = $postData['spouse_name'];
    $spouse_phone_number = $postData['spouse_phone_number'];
    $country_of_residence = $postData['country_of_residence'];
    $state_of_residence = $postData['state_of_residence'];
    $state_of_origin = $postData['state_of_origin'];
    $lga_of_residence = $postData['lga_of_residence'];
    $lga_of_origin = $postData['lga_of_origin'];
    $community_of_origin = $postData['community_of_origin'];
    $village = $postData['village'];
    $tribe = $postData['tribe'];
    $kindred = $postData['kindred'];
    $employment_status = $postData['employment_status'];
    $occupation = $postData['occupation'];
    $phone_number = $postData['phone_number'];
    $alternate_phone_number = $postData['alternate_phone_number'];
    $phone_on_whatsapp = $postData['phone_on_whatsapp'];
    $alternate_on_whatsapp = $postData['alternate_on_whatsapp'];
    $next_of_kin = $postData['next_of_kin'];
    $next_of_kin_phone_number = $postData['next_of_kin_phone_number'];
    $valid_means_of_identification = $postData['valid_means_of_identification'];
    $valid_identification_number = $postData['valid_identification_number'];
    $submission_type = $postData['submission_type'];
    $agreePrivacyPolicy = $postData['agreePrivacyPolicy'];

    // Generate IBAD ID
    $cin = $submission_type === 'indigene' ? 'A' : 'N';
    $ibad_id = $cin . mt_rand(00000001, 99999999);

    // Determine the table based on submission type
    $table_name = $submission_type === 'indigene' ? 'indigenes' : 'non_indigenes';

    try {
        $sql = "INSERT INTO {$table_name} (
                    ibad_id, email, surname, first_name, middle_name, date_of_birth, gender,
                    marital_status, spouse_name, spouse_phone_number, country_of_residence,
                    state_of_residence, lga_of_residence, lga_of_origin, community_of_origin,
                    village, kindred, employment_status, occupation, phone_number, phone_on_whatsapp, alternate_on_whatsapp,
                    alternate_phone_number, next_of_kin, next_of_kin_phone_number, state_of_origin, tribe,
                    valid_means_of_identification, valid_identification_number, agreePrivacyPolicy
                ) VALUES (
                    ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
                )";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ssssssssssssssssssssssssssssss", $ibad_id, $email, $surname, $first_name, $middle_name, $date_of_birth, $gender,
                $marital_status, $spouse_name, $spouse_phone_number, $country_of_residence,
                $state_of_residence, $lga_of_residence, $lga_of_origin, $community_of_origin,
                $village, $kindred, $employment_status, $occupation, $phone_number, $phone_on_whatsapp, $alternate_on_whatsapp,
                $alternate_phone_number, $next_of_kin, $next_of_kin_phone_number, $state_of_origin, $tribe,
                $valid_means_of_identification, $valid_identification_number, $agreePrivacyPolicy);
            if ($stmt->execute()) {
                $stmt->close();
                $conn->close();                

                sendMail($postData['email'], $postData['first_name'], $postData['surname'], $ibad_id);
                echo json_encode(['code' => 200, 'status' => 'success', 'message' => 'Form submitted successfully', 'ibad_id' => $ibad_id]);
                exit;
            } else {
                $stmt->close();
                $conn->close();
                echo json_encode(['code' => 500, 'error' => 'Error: ' . $conn->error]);
            }
        } else {
            $stmt->close();
            $conn->close();
            echo json_encode(['code' => 500, 'error' => 'Error: ' . $conn->error]);
        }
    } catch (Exception $e) {
        echo json_encode(['code' => 500, 'error' => $e->getMessage()]);
    }

}



function sendMail($email, $first_name, $surname, $cin){
    try {
        //Server settings
        $mail = new PHPMailer;
        //$mail->SMTPDebug = 2;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'asatu@email.tfnsolutions.us'; //'noreply@ibad.asatuyouth.org';                     //SMTP username
        $mail->Password   = 'bfimqogrudyvqnpj';                               //SMTP password
        $mail->SMTPSecure = 'ssl';            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('asatu@email.tfnsolutions.us', 'I Believe in Anambra');
        $mail->addAddress($email, $first_name . ' ' . $surname);     //Add a recipient
        $mail->addReplyTo('info@asatuyouth.org', 'I Believe in Anambra');


        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Thank you for Believing in Anambra';
        $mail->Body    = "Congratulations {$first_name} {$surname},<br><br> Your declaration has been received and your Community Identification Number is <b>{$cin}</b>. <br><br>If you need support at any time, please call +2347066024724 and mention your Community Identification Number. <br><br><b>I Believe in Anambra Team</b>";
        $mail->AltBody = "Congratulations {$first_name} {$surname}, Your declaration has been received and your Community Identification Number is {$cin}. If you need support at any time, please call +2347066024724 and mention your Community Identification Number. From: I Believe in Anambra Team";

        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

}

function welcomeMessageAll($who = 'indigenes'){
    include 'config.php';
    $sql = "SELECT ibad_id, email, surname, first_name FROM {$who}";
    $process = $conn->query($sql) or die($conn->error);
    $row = $process->fetch_array();
    $count = $process->num_rows;
    if ($count > 0) {
        do {
            // echo $row['email'] . ' - ' . $row['first_name'] . ' - ' . $row['surname'] . ' - ' . $row['ibad_id'] .'\n';
            sendMail($row['email'], $row['first_name'], $row['surname'], $row['ibad_id']);
        } while ($row = $process->fetch_array());
        echo "{$count} welcome emails sent.";
    } else {
        return false;
    }

}

?>
