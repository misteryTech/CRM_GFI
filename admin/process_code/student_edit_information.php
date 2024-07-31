<?php
session_start();
include("../../include/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = mysqli_real_escape_string($connection, $_POST['student_id']);
    $username = mysqli_real_escape_string($connection, $_POST['edit_username']);
    $first_name = mysqli_real_escape_string($connection, $_POST['edit_first_name']);
    $last_name = mysqli_real_escape_string($connection, $_POST['edit_last_name']);
    $dob = mysqli_real_escape_string($connection, $_POST['edit_dob']);
    $gender = mysqli_real_escape_string($connection, $_POST['edit_gender']);
    $email = mysqli_real_escape_string($connection, $_POST['edit_email']);
    $phone = mysqli_real_escape_string($connection, $_POST['edit_phone']);
    $street = mysqli_real_escape_string($connection, $_POST['edit_street']);
    $barangay = mysqli_real_escape_string($connection, $_POST['edit_barangay']);
    $municipality = mysqli_real_escape_string($connection, $_POST['edit_municipality']);
    $province = mysqli_real_escape_string($connection, $_POST['edit_province']);
    $year = mysqli_real_escape_string($connection, $_POST['edit_year']);
    $section = mysqli_real_escape_string($connection, $_POST['edit_section']);
    $course = mysqli_real_escape_string($connection, $_POST['edit_course']);

    $query = "UPDATE students SET 
        username='$username', 
        first_name='$first_name', 
        last_name='$last_name', 
        dob='$dob', 
        gender='$gender', 
        email='$email', 
        phone='$phone', 
        street='$street', 
        barangay='$barangay', 
        municipality='$municipality', 
        province='$province', 
        year='$year', 
        section='$section', 
        course='$course' 
        WHERE id='$student_id'";

    if (mysqli_query($connection, $query)) {
        $_SESSION['success'] = "Student information updated successfully!";
    } else {
        $_SESSION['error'] = "Error: " . $query . "<br>" . mysqli_error($connection);
    }

    header("Location: ../student_information_page_data.php"); // Change this to the appropriate page
    exit();
}

mysqli_close($connection);
?>
