<?php
require_once 'database_functions.php';
require_once 'functions.php';

global $conn;

if(isset($_GET['control_number'])){
    $control_number = sanitizeInput($_GET['control_number']);

    if(verifyAppointment($control_number) == false || filterControlNumber($control_number) == false){
        header("Location: ../error_message/error403");
        logError("ERROR: Invalid GET parameters in view-appointment_page");
    }
}
else{
    header("Location: ../error_message/error500");
    logError("ERROR: GET parameters not found in view-appointment_page");
}
?>