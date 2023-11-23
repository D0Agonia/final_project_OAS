<?php
require_once 'database_functions.php';
require_once 'functions.php';

// Checks if user is not logged in. Will redirect to index.html if so
tokenRedirect('', 'Location: index?i=1');

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["logout_button"])){
    DestroySessionToken($_COOKIE["session_token"]);
    deleteCookie('session_token');
    header("Location: index?i=1");
    exit();
}
?>