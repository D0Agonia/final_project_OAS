<?php
require_once '../php/functions.php';
require_once '../php/database_functions.php';

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest' && $_SERVER["REQUEST_METHOD"] === "POST") {
    // Inserts information and details, in preparation for regex
    if(isset($_POST['jsonData'])) {
        $userInput = json_decode($_POST['jsonData'], true);
    }
    else{
        echo json_encode(['processed' => false, 'error_message' => 'Something went wrong']);
        exit();
    }

    // Runs inputs through regex filters
    if(empty($userInput['fname']) || empty($userInput['lname'])){
        echo json_encode(['processed' => false, 'error_message' => 'Missing Name Information']);
        exit();
    }
    elseif(filterName($userInput['fname']) == false || filterName($userInput['lname']) == false || filterName($userInput['mname']) == false){
        echo json_encode(['processed' => false, 'error_message' => 'Invalid Name Format']);
        exit();
    }
    elseif(empty($userInput['email'])){
        echo json_encode(['processed' => false, 'error_message' => 'Missing Email Information']);
        exit();
    }
    elseif(filter_var($userInput['email'], FILTER_VALIDATE_EMAIL) == false || filterEmail($userInput['email']) == false){
        echo json_encode(['processed' => false, 'error_message' => 'Invalid Email Format']);
        exit();
    }
    elseif(filterPhoneNumber($userInput['contact_no']) == false){
        echo json_encode(['processed' => false, 'error_message' => 'Invalid Contact Number Format']);
        exit();
    }
    elseif(filterID($userInput['student']) == false){
        echo json_encode(['processed' => false, 'error_message' => 'Invalid Student ID Format']);
        exit();
    }
    elseif(filterName($userInput['appointmentType']) == false){
        echo json_encode(['processed' => false, 'error_message' => 'Invalid Appointment Type Format']);
        exit();
    }
    elseif(filterName($userInput['appointmentType']) == true && $userInput['appointmentType'] == 'Appointment Type'){
        echo json_encode(['processed' => false, 'error_message' => 'Please select an appointment type']);
        exit();
    }
    elseif(filterName($userInput['appointmentType']) == true && $userInput['appointmentType'] == 'document' && $userInput['selectedDocuments'] == NULL){
        echo json_encode(['processed' => false, 'error_message' => 'Please select a document to request']);
        exit();
    }
    else{
        $_SESSION['calendar_blacklist'] = fetchAppointmentBlacklist();
        echo json_encode(['processed' => true, 'calendar_blacklist' => json_encode($_SESSION['calendar_blacklist'])]);
    }
}
else {
    header("Location: ../error_message/error403");
    logError("Method Not Allowed");
    echo json_encode(['error' => 'Method Not Allowed']);
}
?>