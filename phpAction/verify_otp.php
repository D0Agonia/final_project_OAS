<?php
require_once '../php/database_functions.php';
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

    // User-input variables
    $email = $data["email"]; $otp = $data["otp"];

    $output['processed'] = false; // Always false until login is successful

    // "Empty Email" Error
    if(empty($email)){
        $loginResult = '4'; $output['processed'] = false; $output['message'] = 'ERROR: Empty Email Parameter';
    }
    // "Invalid Email" Error
    elseif(filter_var($email, FILTER_VALIDATE_EMAIL) == false || filterEmail($email) == false){
        $loginResult = '4'; $output['processed'] = false; $output['message'] = 'ERROR: Invalid Email';
    }
    // "Empty OTP" Error
    elseif(empty($otp)){
        $loginResult = '4'; $output['message'] = 'ERROR: Empty OTP Parameter';
    }
    // "Invalid OTP Format" Error
    elseif(filterOTP($otp) == false){
        $loginResult = '4'; $output['message'] = 'ERROR: Invalid OTP Format';
    }
    // Case [ACCEPT]: Inputs satisfied
    elseif(filterOTP($otp) == true){
        $email = sanitizeInput($email);
        $otp = sanitizeInput($otp);
        $loginResult = verifyGuestLogin($email, $otp);
    }

    // Case '1': OTP Expired
    if($loginResult == '1'){
        $output['message'] = 'ERROR: OTP Expired';
    }
    // Case '2': Wrong OTP Code
    if($loginResult == '2'){
        $output['message'] = 'ERROR: Wrong OTP Code';
    }
    // Case '3': Wrong Email
    if($loginResult == '3'){
        $output['message'] = 'ERROR: Wrong Email';
    }
    // Case [TOKEN]: Correct
    elseif(strlen($loginResult) == 32){
        $output['processed'] = true;
        deleteCookie("guestSession");
        setcookie("session_token", $loginResult, time() + 86400, "/");
        echo json_encode($output);
        exit();
    }

    echo json_encode($output);
    exit();
}
else {
    header("Location: ../error_message/error403");
    logError("Method Not Allowed");
    echo json_encode(['error' => 'Method Not Allowed']);
}
?>