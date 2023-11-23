<?php
require_once 'database_functions.php';
require_once 'email_logic.php';
require_once 'functions.php';

session_name('guestSession'); session_start();

// Initial values for session variables and error_display
if(!isset($_SESSION['guestMade'])){
    $_SESSION['guestMade'] = false;
    $_SESSION['otpCooldown'] = time();
    $_SESSION['sendMail'] = false; 
}
$_SESSION['showError'] = false;
$_SESSION['showSuccess'] = false;
$guestEmail_value_email = "";

// Checks if user has already logged in. Will redirect to index-student-guest.html if so
tokenRedirect('Location: index-student-guest', '');

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["otp_send"])){
    // To display in value attribute of textbox
    $guestEmail_value_email = $_POST["email"];
    
    // User-input variables
    $email = $_POST["email"];

    // Always set to these values until conditions are met
    $_SESSION['showError'] = true; $_SESSION['showSuccess'] = false;

    // "Empty Email" Error
    if(empty($email)){
        $error_display = 'ERROR: Empty Email Parameter';
    }
    // "Invalid Email" Error
    elseif(filter_var($email, FILTER_VALIDATE_EMAIL) == false || filterEmail($email) == false){
        $error_display = 'ERROR: Invalid Email';
    }
    // "OTP Cooldown" Error
    elseif($_SESSION['otpCooldown'] > time()){
        $error_display = 'ERROR: OTP Cooldown';
    }
    // Case [ACCEPT]: Inputs satisfied (First creation of guest user)
    elseif(filter_var($email, FILTER_VALIDATE_EMAIL) == true && filterEmail($email) == true 
    && $_SESSION['otpCooldown'] <= time() && $_SESSION['guestMade'] == false){
        $email = sanitizeInput($email);
        $otpResult = insertGuest();

        $_SESSION['otpCooldown'] = time() + 60;
        $_SESSION['sendMail'] = true;
        $_SESSION['showError'] = false;

        $success_display = 'SUCCESS: OTP Code Sent';
        $_SESSION['showSuccess'] = true;
    }
    // Case [ACCEPT]: Inputs satisfied (Rerequest of OTP)
    elseif(filter_var($email, FILTER_VALIDATE_EMAIL) == true && filterEmail($email) == true 
    && $_SESSION['otpCooldown'] <= time() && $_SESSION['guestMade'] == true){
        $_SESSION['otpCooldown'] = time() + 60;
        $_SESSION['sendMail'] = true;
        $_SESSION['showError'] = false;

        $success_display = 'SUCCESS: OTP Code Resent';
        $_SESSION['showSuccess'] = true;
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
}

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_button"])){
    // To display in value attribute of textbox
    $guestEmail_value_email = $_POST["email"];

    // User-input variables
    $otp = $_POST["otp"];

    $_SESSION['showError'] = true; // Always true until login is successful

    // "Empty OTP" Error
    if(empty($otp)){
        $loginResult = '2'; $error_display = 'ERROR: Empty OTP Parameter';
    }
    // "Invalid OTP Format" Error
    elseif(filterOTP($otp) == false){
        $loginResult = '2'; $error_display = 'ERROR: Invalid OTP Format';
    }
    // Case [ACCEPT]: Inputs satisfied
    elseif(filterOTP($otp) == true){
        $otp = sanitizeInput($otp);
        $loginResult = verifyGuestLogin($otp);
    }

    // Case '1': Wrong OTP Code
    if($loginResult == '1'){
        $error_display = 'ERROR: Wrong OTP Code';
    }
    // Case [TOKEN]: Correct
    elseif(strlen($loginResult) == 32){
        $show_error = false;
        session_unset(); session_destroy(); deleteCookie("guestSession"); 
        setcookie("session_token", $loginResult, time() + 86400, "/");
        header("Location: index-student-guest");
        exit();
    }
}
?>