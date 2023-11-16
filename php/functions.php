<?php
require_once 'db_connect.php';

function deleteCookie($cookieName){
    // Deletes and unsets a cookie
    setcookie($cookieName, "", time() - 1, "/");
    unset($_COOKIE[$cookieName]);
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
    $filter = '/^[a-zA-Z0-9\!@#$%^&]{8,32}+$/';

    // Simple if-else check. Returns "true" if correct, "false" if wrong
    if(preg_match($filter, $input)){
        return true;
    }
    else{
        return false;
    }
}

function tokenRedirect($header_ifTrue, $header_ifFalse){
    global $conn;

    // Checks if the token cookie hasn't expired. Sets $input_token to an empty string if non-existent.
    if(isset($_COOKIE['session_token'])){
        $input_token = $_COOKIE['session_token'];
    }
    else{
        $input_token = '';
    }

    // Runs an SQL function to verify the token
    try{
        $sql = "SELECT verifyToken('$input_token') AS STATUS";
        $queryResult = $conn->query($sql); $row = $queryResult->fetch_assoc();
        $tokenResult = $row['STATUS'];
    }
    catch(Exception $e){
        echo "Error: " . $e->getMessage();
    }

    // Checks if token is verified (true)
    if($tokenResult == true){
        header($header_ifTrue);
        exit();
    }
    else{
        deleteCookie('session_token');
        if(!empty($header_ifFalse)){
            header($header_ifFalse);
            exit();
        }
    }
}
?>