<?php
require_once 'database_functions.php';
require_once 'db_connect.php';

function deleteCookie($cookieName){
    // Deletes and unsets a cookie
    setcookie($cookieName, "", time() - 1, "/");
    unset($_COOKIE[$cookieName]);
}

function filterAlphanumeric($input){
    // Filter that only allows alphanumeric characters
    $filter = '/^[a-zA-Z0-9]+$/';

    // Simple if-else check. Returns "true" if correct, "false" if wrong
    if(preg_match($filter, $input)){
        return true;
    }
    else{
        return false;
    }
}

function filterEmail($input){
    // Email regex filter
    $filter = '/^[a-zA-Z0-9\._-]+@[a-zA-Z0-9\._-]+\.[a-zA-Z]{2,6}$/';

    // Simple if-else check. Returns "true" if correct, "false" if wrong
    if(preg_match($filter, $input)){
        return true;
    }
    else{
        return false;
    }
}

function filterName($input){
    // Name regex filter
    $filter = '/^[a-zA-Z\s]{0,32}$/';

    // Simple if-else check. Returns "true" if correct, "false" if wrong
    if(preg_match($filter, $input)){
        return true;
    }
    else{
        return false;
    }
}

function filterOTP($input){
    // 6-Character lowercase numeric regex filter
    $filter = '/^[a-z0-9]{6}$/';

    // Simple if-else check. Returns "true" if correct, "false" if wrong
    if(preg_match($filter, $input)){
        return true;
    }
    else{
        return false;
    }
}

function filterPhoneNumber($input){
    // Regex for both global and local phone numbers
    $global_filter = '/^\+[0-9]{10,15}$/';
    $local_filter = '/^09[0-9]{9}$/';

    // Simple if-else check. Returns "true" if correct, "false" if wrong
    if(preg_match($global_filter, $input) || preg_match($local_filter, $input)){
        return true;
    }
    else{
        return false;
    }
}

function filterID($input){
    // 'KLD-xx-xxxxxx' regex filter, with x being a number
    $filter = '/^KLD-[0-9]{2}-[0-9]{6}$/';

    // Simple if-else check. Returns "true" if correct, "false" if wrong
    if(preg_match($filter, $input)){
        return true;
    }
    else{
        return false;
    }
}

function filterPassword($input){
    // Filter that only allows alphanumeric characters and some special characters
    $filter = '/^[a-zA-Z0-9\!@$^&-._]{8,32}+$/';

    // Simple if-else check. Returns "true" if correct, "false" if wrong
    if(preg_match($filter, $input)){
        return true;
    }
    else{
        return false;
    }
}

function logError($error){
    $logDirectory = __DIR__ . '/log';
    $logFilePath = $logDirectory . '/database_error_log.txt';

    if (!is_dir($logDirectory)){
        mkdir($logDirectory, 0755, true);
    }
    if (!file_exists($logFilePath)){
        touch($logFilePath);
    }

    $timestamp = date("Y-m-d H:i:s");
    if($error instanceof Exception){
        $errorMessage = "Error: " . $error->getMessage();
    }
    else{
        $errorMessage = "Error: " . $error;
    }
    $logMessage = "[" . $timestamp . "]" . " - " . $errorMessage . "\n";
  
    file_put_contents($logFilePath, $logMessage, FILE_APPEND);
}

function labelID($input_id){
    if(preg_match("/^KLD/", $input_id)){
        return "STUDENT";
    }
    elseif(preg_match("/^GUEST/", $input_id)){
        return "GUEST";
    }
    else{
        header("Location: ../error_message/error500");
        logError("Invalid ID type stored at \$input_id in " . __DIR__);
        exit();
    }
}

function lowercaseNumericString($length) {
    // Characters generated by the function
    $characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
    $charactersLength = strlen($characters);

    $randomString = '';
    // Generate random characters from the character set
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }

    return $randomString;
}

function tokenRedirect($header_ifTrue, $header_ifFalse){
    global $conn;

    // Checks if the token cookie hasn't expired and has valid characters. Sets $input_token to an empty string if non-existent.
    if(isset($_COOKIE['session_token']) && !filterAlphanumeric($_COOKIE['session_token'])){
        header("Location: ../error_message/error500");
        logError("Invalid characters used for token in " . __DIR__);
        exit();
    }
    elseif(isset($_COOKIE['session_token']) && filterAlphanumeric($_COOKIE['session_token'])){
        $input_token = $_COOKIE['session_token'];
    }
    else{
        $input_token = '';
    }

    // Runs an SQL function to verify the token
    $tokenResult = verifyToken($input_token);

    // Checks if token is verified (true)
    if($tokenResult == true){
        if(!empty($header_ifTrue)){
            header($header_ifTrue);
            exit();
        }
    }
    else{
        deleteCookie('session_token');
        if(!empty($header_ifFalse)){
            header($header_ifFalse);
            exit();
        }
    }
}

function sanitizeInput($input){
    $input = htmlspecialchars(stripslashes(trim($input)));

    return $input;
}
?>