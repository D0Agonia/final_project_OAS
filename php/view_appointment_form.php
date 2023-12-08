<?php
require_once 'database_functions.php';
require_once 'functions.php';

$show_error = true; $error_message = "";

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["view_appointment"])){
    // User inputs
    $control_number = $_POST['control-no'];

    // Regex filters
    if(empty($control_number) == true){
        $error_message = "ERROR: Empty Control Number";
    }
    elseif(filterControlNumber($control_number) == false){
        $error_message = "ERROR: Invalid Control Number Format";
    }
    elseif(filterControlNumber($control_number) == true){
        $control_number = sanitizeInput($control_number);
        $viewResult = verifyAppointment($control_number);
    }

    if(isset($viewResult) && $viewResult == true){
        $show_error = false;
        header('Location: view-appointment_page?control_number=' . $control_number);
    }
    elseif(isset($viewResult) && $viewResult == false){
        $error_message = "ERROR: Control Number does not exist";
    }
}
?>