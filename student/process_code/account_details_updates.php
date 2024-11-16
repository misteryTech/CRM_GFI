<?php
session_start();
include("../../include/connection.php");

// Check if student is logged in
if (!isset($_SESSION['student_id'])) {
    $_SESSION['error'] = "You must be logged in to update your account details.";
    header("Location: ../login_student.php");
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
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $phone = mysqli_real_escape_string($connection, $_POST['phone']);
    $street = mysqli_real_escape_string($connection, $_POST['street']);
    $barangay = mysqli_real_escape_string($connection, $_POST['barangay']);
    $municipality = mysqli_real_escape_string($connection, $_POST['municipality']);
    $province = mysqli_real_escape_string($connection, $_POST['province']);
    $year = mysqli_real_escape_string($connection, $_POST['year']);
    $section = mysqli_real_escape_string($connection, $_POST['section']);
    $course = mysqli_real_escape_string($connection, $_POST['course']);
    $archive = mysqli_real_escape_string($connection, $_POST['archive']);
    

    // Update query
    $updateQuery = "
        UPDATE students_table
        SET
            username = '$username',
            password = '$password',
            first_name = '$first_name',
            last_name = '$last_name',
            dob = '$dob',
            gender = '$gender',
            email = '$email',
            phone = '$phone',
            street = '$street',
            barangay = '$barangay',
            municipality = '$municipality',
            province = '$province',
            year = '$year',
            section = '$section',
            course = '$course',
            archive = '$archive'
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
