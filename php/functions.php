<?php
require_once 'db_connect.php';

function deleteCookie($cookieName){
    // Deletes and unsets a cookie
    setcookie($cookieName, "", time() - 1, "/");
    unset($_COOKIE[$cookieName]);
}

function filterID($input){
    // Filter that only allows numbers and specific characters like K, L, D and hyphens (-)
    $filter = '/^[0-9KLD\-]+$/';

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
    $filter = '/^[a-zA-Z0-9\!@#$%^&]+$/';

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