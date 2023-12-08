<?php
require_once '../php/database_functions.php';
require_once '../php/email_logic.php';
require_once '../php/functions.php';

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest' && $_SERVER["REQUEST_METHOD"] === "POST") {
    // Inserts information and details, in preparation for regex
    if(isset($_POST['jsonData'])) {
        $data = json_decode($_POST['jsonData'], true);
    }
    else{
        echo json_encode(['processed' => false, 'error_message' => 'JSON Decoding Fail']);
        exit();
    }

    // Output array to assign data to
    $output = array();

    // Ported session data
    $_SESSION = $data['session'];
    
    // User-input variables
    $email = $data["email"];

    // "Empty Email" Error
    if(empty($email)){
        $output['processed'] = false; $output['message'] = 'ERROR: Empty Email Parameter';
    }
    // "Invalid Email" Error
    elseif(filter_var($email, FILTER_VALIDATE_EMAIL) == false || filterEmail($email) == false){
        $output['processed'] = false; $output['message'] = 'ERROR: Invalid Email';
    }
    // "OTP Cooldown" Error
    elseif($_SESSION['otpCooldown'] > time()){
        $output['processed'] = false; $output['message'] = 'ERROR: OTP Cooldown';
    }
    // Case [ACCEPT]: Inputs satisfied
    elseif(filter_var($email, FILTER_VALIDATE_EMAIL) == true && filterEmail($email) == true 
    && $_SESSION['otpCooldown'] <= time()){
        $email = sanitizeInput($email);
        $otpResult = insertGuest($email);

        $_SESSION['otpCooldown'] = time() + 60;
        $_SESSION['sendMail'] = true;

        $output['processed'] = true;
    }

    // Send Mail Logic
    if($_SESSION['sendMail'] == true){
        $message = "
        <!DOCTYPE html>
        <body>
            <h2>Your OTP Code</h2>
            <p>Please use the following one-time password (OTP) code to login using a guest account:</p>
            <strong>$otpResult</strong>
            <p>Do not share this OTP code with anyone for security reasons.</p>
            <p>If you did not request this OTP code, please ignore this email.</p>
        </body>
        </html>
        ";

        sendMail($email, 'KLD OAS - OTP Code', $message);
        $_SESSION['sendMail'] = false;
    }

    $output['session'] = $_SESSION;
    echo json_encode($output);

    exit();
}
else {
    header("Location: ../error_message/error403");
    logError("Method Not Allowed");
    echo json_encode(['error' => 'Method Not Allowed']);
}
?>