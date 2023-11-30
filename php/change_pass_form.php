<?php
require_once 'database_functions.php';
require_once 'functions.php';

session_name('changePassSession'); session_start();

// Since if statement only executes when submit button is pressed, initial state is false
$show_error = false;

// Obtaining changePassword_code through POST from URL
$_SESSION['code'] = isset($_GET['code']) ? $_GET['code'] : '';

// Filters changePassword_code, then checks if valid. If not, redirect to index.html
if(!filterTokenCode($_SESSION['code'])){
    header("Location: ../error_message/error500");
    logError("Invalid characters used for code in " . __DIR__);
    exit();
}
elseif(!verifyChangePasswordCode(sanitizeInput($_SESSION['code']))){
    header("Location: index");
    exit();
}

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_button"])){
    // User-input variables
    $password = $_POST["change_pass"];
    $confirm_password = $_POST["confirm-pass"];

    $show_error = true; // Always true until filter is successful

    // "Empty Password" Error
    if(empty($password) || empty($confirm_password)){
        $error_display = 'ERROR: All fields are required';
    }
    // "Passwords do not match" Error
    elseif($password != $confirm_password){
        $error_display = 'ERROR: Passwords do not match';
    }
    // "Invalid Password Format" Error
    elseif(filterPassword($password) == false || filterPassword($confirm_password) == false){
        $error_display = 'ERROR: Invalid Password Format<br>(8 to 32 Characters, Alphanumeric + Special Characters)';
    }
    // Case [ACCEPT]: Inputs satisfied
    elseif(filterPassword($password) == true && filterPassword($confirm_password) == true && $password == $confirm_password){
        $password = sanitizeInput($password);
        $changeResult = changeCredentials($_SESSION['code'], $password);
        
        if($changeResult == true){
            $show_error = false;
            if(isset($_COOKIE['session_token'])){
                deleteCookie('session_token');
            }
            session_unset(); session_destroy(); deleteCookie("changePassSession"); 
            header("Location: login_student");
            exit();
        }
        else{
            $show_error = true;
            $error_display = 'ERROR: Invalid Code';
        }
    }
}
?>