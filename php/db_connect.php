<?php
// Database connection details
$host = "localhost";
$dbname = "OnlineAppointment";
$username = "root";
$password = "";

// Establishing database connection
$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>