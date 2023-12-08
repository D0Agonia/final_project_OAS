<?php
require_once '../php/database_functions.php';
require_once '../php/functions.php';
require_once '../php/sanitize_functions.php';

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest' && $_SERVER["REQUEST_METHOD"] === "POST") {
    // Inserts information and details, in preparation for regex
    if(isset($_POST['jsonData'])) {
        $userInput = json_decode($_POST['jsonData'], true);
    }
    else{
        echo json_encode(['processed' => false, 'error_message' => 'JSON Decoding Fail']);
        exit();
    }

    $userInput = json_decode(sanitizeInfoDetails($userInput), true);
    $userInput['blacklist'] = fetchAppointmentBlacklist();
    echo json_encode($userInput);
    exit();
}
else {
    header("Location: ../error_message/error403");
    logError("Method Not Allowed");
    echo json_encode(['error' => 'Method Not Allowed']);
}
?>