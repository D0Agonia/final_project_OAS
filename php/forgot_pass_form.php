<?php
require_once 'database_functions.php';
require_once 'email_logic.php';
require_once 'functions.php';

session_start();

// Since if statement only executes when submit button is pressed, initial state is false
$show_error = false;

// Checks if user has already logged in. Will redirect to index-student-guest.html if so
tokenRedirect('Location: index-student-guest.html', '');

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_button"])){
    // User-input variables
    $email = $_POST['email'];

    $show_error = true; // Always true until filter is successful

    // "Empty Email" Error
    if(empty($email)){
        $requestResult = '2'; $error_display = 'ERROR: Empty Email Parameter';
    }
    // "Invalid Email" Error
    elseif(filter_var($email, FILTER_VALIDATE_EMAIL) == false || filterEmail($email) == false){
        $requestResult = '2'; $error_display = 'ERROR: Invalid Email';
    }
    // Case [ACCEPT]: Inputs satisfied
    elseif(filter_var($email, FILTER_VALIDATE_EMAIL) == true && filterEmail($email) == true){
        $email = sanitizeInput($email);
        $requestResult = requestPasswordChange($email);
    }

    // "User does not exist" Error
    if($requestResult == '1'){
        $error_display = 'ERROR: User does not exist';
    }
    // Case [REDIRECT]: Correct
    elseif(strlen($requestResult) == 64){
        $show_error = false;

        $url = 'localhost/final_project_OAS/change_pass.php?' . http_build_query(['code' => $requestResult]);
        $message = "
        <!DOCTYPE html>
        <body>
            <h2>Password Reset</h2>
            <p>You have requested to reset your password. Click the link below to proceed:</p>
            <a href=\"$url\">Reset Password</a>
            <p>This link will expire in 1 hour for security reasons.</p>
            <p>If you did not request a password reset, please ignore this email.</p>
        </body>
        </html>
        ";
        sendMail($email, 'KLD OAS - Change Password', $message);

        header("Location: forgot_pass-msg.html");
        exit();
    }
}
?>