<?php
require_once 'database_functions.php';
require_once 'functions.php';

session_name('appointmentSession'); session_start();

// Checks if user is not logged in. Will redirect to index.html if so
tokenRedirect('', 'Location: index');

// Fetches user details and stores it. Refer to database_functions -> fetchDetails() for variable names
$_SESSION = array_merge($_SESSION, fetchDetails($_COOKIE['session_token']));

// Checks if user is a student or guest
$userType = labelID($_SESSION['loginID']);

// List of variables in page
/*
$_POST["fname"];
$_POST["lname"];
$_POST["email"];
$_POST["contact_no"];
$_POST["id_select"];
$_POST["identification"];
$_POST["appointment_type"];
*/
?>