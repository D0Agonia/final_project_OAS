<?php
require_once 'database_functions.php';
require_once 'functions.php';

$show_error = true; $error_message = "";

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["view_appointment"])){
    // User inputs
    $control_number = $_POST['control-no']; $lName = $_POST['last-name'];

    // Regex filters
    if(empty($control_number) == true){
        $error_message = "ERROR: Empty Control Number";
    }
    elseif(filterControlNumber($control_number) == false){
        $error_message = "ERROR: Invalid Control Number Format";
    }
    elseif(empty($lName) == true){
        $error_message = "ERROR: Empty Last Name";
    }
    elseif(filterName($lName) == false){
        $error_message = "ERROR: Invalid Last Name Format";
    }
    elseif(filterControlNumber($control_number) == true && filterName($lName) == true){
        $control_number = sanitizeInput($control_number);
        $lName = sanitizeInput($lName);
        $viewResult = verifyAppointment($control_number, $lName);
    }

    if(isset($viewResult) && $viewResult == true){
        $show_error = false;
        header('Location: view-appointment_page?control_number=' . $control_number . '&lName=' . $lName);
    }
    elseif(isset($viewResult) && $viewResult == false){
        $error_message = "ERROR: Appointment Not Found";
    }
}
?>