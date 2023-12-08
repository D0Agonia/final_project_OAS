<?php
require_once '../php/database_functions.php';
require_once '../php/functions.php';

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest' && $_SERVER["REQUEST_METHOD"] === "POST") {
    // Inserts information and details, in preparation for regex
    if(isset($_POST['jsonData'])) {
        $userInput = json_decode($_POST['jsonData'], true);
    }
    else{
        echo json_encode(['processed' => false, 'error_message' => 'JSON Decoding Fail']);
        exit();
    }

    if(preg_match('/^\d{4}-\d{2}-\d{2}$/', $userInput['appointmentDate']) == true){
        echo json_encode(['processed' => false, 'error_message' => 'Please select a date']);
        exit();
    }
    elseif(filterDate($userInput['appointmentDate']) == false){
        echo json_encode(['processed' => false, 'error_message' => 'Invalid date format (Y-m-d H:i)']);
        exit();
    }
    else{
        $userInput['processed'] = true;
        echo json_encode($userInput);
        exit();
    }
}
else {
    header("Location: ../error_message/error403");
    logError("Method Not Allowed");
    echo json_encode(['error' => 'Method Not Allowed']);
}
?>