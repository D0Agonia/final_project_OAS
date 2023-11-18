<?php
require_once 'db_connect.php';
require_once 'functions.php';

session_start();

// Since if statement only executes when submit button is pressed, initial state is false
$show_error = false;

// Obtaining changePassword_code through POST from URL
$_SESSION['code'] = isset($_GET['code']) ? $_GET['code'] : '';

// Checking if changePassword_code is valid; if not, redirect to landing.html
try{
    $sql = "SELECT verifyChangePasswordCode('{$_SESSION['code']}') AS STATUS";
    $queryResult = $conn->query($sql); $row = $queryResult->fetch_assoc();
    $checkResult = $row['STATUS'];

    if($checkResult == false){
        header("Location: landing.html");
    }
}
catch(Exception $e){
    echo "Error: " . $e->getMessage();
}

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_button"])){
    try{
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
            $sql = "CALL ChangeCredentials('{$_SESSION['code']}', '$password')"; $conn->query($sql);
            
            if($conn->affected_rows > 0){
                $show_error = false;
                if(isset($_COOKIE['session_token'])){
                    deleteCookie('session_token');
                }
                header("Location: login_student.php");
                exit();
            }
            else{
                $show_error = true;
                $error_display = 'ERROR: Invalid Code';
            }
        }
    }
    catch(Exception $e){
        echo "Error: " . $e->getMessage();
    }
}
?>