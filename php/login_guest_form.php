<?php
require_once 'db_connect.php';
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

// Checks if user has already logged in. Will redirect to index-student-guest.html if so
tokenRedirect('Location: index-student-guest.html', '');

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["otp_send"])){
    // User-input variables
    $email = $_POST["email"];

    // Always set to these values until conditions are met
    $_SESSION['showError'] = true; $_SESSION['showSuccess'] = false;

    try{
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
            $sql = "SELECT insertGuest() AS STATUS";
            $queryResult = $conn->query($sql); $row = $queryResult->fetch_assoc();
            $otpResult = $row['STATUS']; $_SESSION['guestMade'] = true;

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
    }
    catch(Exception $e){
        echo "Error: " . $e->getMessage();
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
    try{
        // User-input variables
        $otp = $_POST["otp"];

        $_SESSION['showError'] = true; // Always true until login is successful

        // "Empty OTP" Error
        if(empty($otp)){
            $loginResult = '1'; $error_display = 'ERROR: Empty OTP Parameter';
        }
        elseif(filterOTP($otp) == false){
            $loginResult = '1'; $error_display = 'ERROR: Invalid OTP Format';
        }
        // Case [ACCEPT]: Inputs satisfied
        elseif(filterOTP($otp) == true){
            $sql = "SELECT verifyGuestLogin('$otp') AS STATUS";
            $queryResult = $conn->query($sql); $row = $queryResult->fetch_assoc();
            $loginResult = $row['STATUS'];
        }

        // Case '1': Wrong OTP Code
        if($loginResult == '1'){
            $error_display = 'ERROR: Wrong OTP Code';
        }
        // Case [TOKEN]: Correct
        elseif(strlen($loginResult) == 32){
            $show_error = false; $_SESSION['finished'] = true;
            session_unset(); session_destroy(); deleteCookie("guestSession"); 
            setcookie("session_token", $loginResult, time() + 86400, "/");
            header("Location: index-student-guest.html");
            exit();
        }
    }
    catch(Exception $e){
        echo "Error: " . $e->getMessage();
    }
}
?>