<?php
// Database connection details
$host = "sql207.infinityfree.com:3306";
$dbname = "if0_35481943_OnlineAppointment";
$username = "if0_35481943";
$password = "V8cHrK2S8zu7";

// Establishing database connection
$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>