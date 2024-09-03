<?php
session_start(); // Start or resume the session

// Destroy the session
session_destroy();

// Redirect to the login page
header("Location: ../login_student.php");
exit(); // Exit the script to ensure the redirection occurs
?>
