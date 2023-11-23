<?php
require_once 'database_functions.php';
require_once 'functions.php';

// Checks if user has already logged in. Will redirect to index-student-guest.html if so
tokenRedirect('Location: index-student-guest', '');

// Initial states of some variables
$studentID_value_text = ""; $show_error = false;

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_button"])){
    // To display in value attribute of textbox
    $studentID_value_text = $_POST["student_id"];

    // User-input variables
    $student_id = $_POST["student_id"];
    $password = $_POST["password"];

    $show_error = true; // Always true until login is successful
    
    // If-else chain for filtering student_id and password user inputs
    // "Empty ID" Error
    if(empty($student_id)){
        $loginResult = '3'; $error_display = 'ERROR: Empty ID Parameter';
    }
    // "Invalid characters on ID" Error
    elseif(filterID($student_id) == false){
        $loginResult = '3'; $error_display = 'ERROR: Invalid ID Format (KLD-xx-xxxxxx)';
    }
    // "Empty Password" Error
    elseif(empty($password)){
        $loginResult = '3'; $error_display = 'ERROR: Empty Password Parameter';
    }
    // "Invalid characters on Password" Error
    elseif(filterPassword($password) == false){
        $loginResult = '3'; $error_display = 'ERROR: Invalid Password Format<br>(8 to 32 Characters, Alphanumeric + Special Characters)';
    }
    // Case [ACCEPT]: Inputs satisfied
    elseif(filterID($student_id) == true && filterPassword($password) == true){
        // Sanitizes user inputs
        $student_id = sanitizeInput($student_id);
        $password = sanitizeInput($password);

        // Verifies id and password through a PHP function
        $loginResult = verifyUserLogin($student_id, $password);
    }

    // These are cases for when the database has been successfully queried
    // Case '1': ID does not exist
    if($loginResult == '1'){
        $error_display = 'ERROR: ID does not exist';
    }
    // Case '2': Wrong password
    elseif($loginResult == '2'){
        $error_display = 'ERROR: Wrong Password';
    }
    // Case [TOKEN]: Correct
    elseif(strlen($loginResult) == 32){
        $show_error = false;
        setcookie("session_token", $loginResult, time() + 86400, "/");
        header("Location: index-student-guest");
        exit();
    }
}
?>