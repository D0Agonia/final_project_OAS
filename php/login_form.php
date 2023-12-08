<?php
require_once 'database_functions.php';
require_once 'functions.php';

$errorAttribute = 'hidden';
$errorMessage = '';

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login_button'])){
    $admin_username = sanitizeInput($_POST['admin_username']);
    $admin_password = sanitizeInput($_POST['admin_password']);

    if(preg_match('/^[a-zA-Z0-9]{8,16}$/', $admin_username) == false){
        $errorAttribute = ''; $errorMessage = "ERROR: Invalid Username Format";
    }
    elseif(filterPassword($admin_password) == false){
        $errorAttribute = ''; $errorMessage = "ERROR: Invalid Password Format";
    }
    elseif(preg_match('/^[a-zA-Z0-9]{8,16}$/', $admin_username) == true && filterPassword($admin_password) == true){
        $login_result = verifyAdminLogin($admin_username, $admin_password);
    }

    if(isset($login_result) && $login_result == '1'){
        $errorAttribute = ''; $errorMessage = "ERROR: Username Not Found";
    }
    elseif(isset($login_result) && $login_result == '2'){
        $errorAttribute = ''; $errorMessage = "ERROR: Wrong Password";
    }
    elseif(isset($login_result) && strlen($login_result) == 32){
        $errorAttribute = 'hidden'; $errorMessage = '';
        setcookie("session_token", $loginResult, time() + 86400, "/");
        header("Location: index");
        exit();
    }
}
?>