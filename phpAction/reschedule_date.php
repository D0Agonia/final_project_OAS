<?php
require_once '../php/database_functions.php';
require_once '../php/functions.php';

global $conn;

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest' && $_SERVER["REQUEST_METHOD"] === "POST") {
    // Inserts information and details, in preparation for regex
    if(isset($_POST['jsonData'])) {
        $userInput = json_decode($_POST['jsonData'], true);
    }
    else{
        echo json_encode(['processed' => false, 'error_message' => 'JSON Decoding Fail']);
        exit();
    }
    if(filterControlNumber($userInput['controlNumber']) == false){
        echo json_encode(['processed' => false, 'error_message' => 'Wrong Control Number']);
        exit();
    }
    try{
        $query = "SELECT appointment_datetime FROM AppointmentList WHERE control_number = ?";
        $stmt = $conn->prepare($query); $stmt->bind_param("s", $userInput['controlNumber']);
        $stmt->execute(); $stmt->store_result(); $stmt->bind_result($original_datetime);
        $stmt->fetch(); $stmt->close();
    }
    catch(Exception $e){
        header("Location: ../error_message/error500");
        logError($e);
    }

    if(preg_match('/^\d{4}-\d{2}-\d{2}$/', $userInput['appointmentDate']) == true){
        echo json_encode(['processed' => false, 'error_message' => 'Please select a date']);
        exit();
    }
    elseif(filterDate($userInput['appointmentDate']) == false){
        echo json_encode(['processed' => false, 'error_message' => 'Invalid date format (Y-m-d H:i)']);
        exit();
    }
    elseif($userInput['appointmentDate'] . ':00' == $original_datetime){
        echo json_encode(['processed' => false, 'error_message' => 'New date must not match original date']);
        exit();
    }
    else{
        try{
            $query = "UPDATE AppointmentList SET appointment_datetime = ? WHERE control_number = ?";
            $stmt = $conn->prepare($query); $stmt->bind_param("ss", $userInput['appointmentDate'], $userInput['controlNumber']);
            $stmt->execute(); $stmt->close();
        }
        catch(Exception $e){
            header("Location: ../error_message/error500");
            logError($e);
        }
        echo json_encode(['processed' => true]);
        exit();
    }
}
else {
    header("Location: ../error_message/error403");
    logError("Method Not Allowed");
    echo json_encode(['error' => 'Method Not Allowed']);
}
?>