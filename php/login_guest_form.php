<?php
require_once 'functions.php';

session_name('guestSession'); session_start();

// Initial values for session variables
$_SESSION['otpCooldown'] = time();
$_SESSION['sendMail'] = false; 

// Checks if user has already logged in. Will redirect to index-student-guest.html if so
tokenRedirect('Location: index-student-guest', '');
?>