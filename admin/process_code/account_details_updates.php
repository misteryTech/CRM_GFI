<?php
session_start();
include("../../include/connection.php");

// Check if student is logged in
if (!isset($_SESSION['student_id'])) {
    $_SESSION['error'] = "You must be logged in to update your account details.";
    header("Location: ../../login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get student ID from session
    $student_id = mysqli_real_escape_string($connection, $_SESSION['student_id']);
    
    // Get form data
    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);
    $first_name = mysqli_real_escape_string($connection, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($connection, $_POST['last_name']);
    $dob = mysqli_real_escape_string($connection, $_POST['dob']);
    $gender = mysqli_real_escape_string($connection, $_POST['gender']);
    
    // Update query
    $updateQuery = "
        UPDATE students
        SET 
            username = '$username',
            password = '$password',
            first_name = '$first_name',
            last_name = '$last_name',
            dob = '$dob',
            gender = '$gender'
        WHERE student_id = '$student_id'
    ";
    
    if (mysqli_query($connection, $updateQuery)) {
        $_SESSION['success'] = "Account details updated successfully.";
    } else {
        $_SESSION['error'] = "Failed to update account details. Please try again.";
    }
    
    header("Location: ../account_details_page.php");
    exit();
} else {
    $_SESSION['error'] = "Invalid request.";
    header("Location: ../account_details_page.php");
    exit();
}
?>
