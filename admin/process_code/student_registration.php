<?php
session_start();
include("../../include/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = mysqli_real_escape_string($connection, $_POST['student_id']);
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
    $role = "Students";

    $query = "INSERT INTO students (
        student_id, username, password, first_name, last_name, dob, gender, email, phone, street, barangay, municipality, province, year, section, course, role
    ) VALUES (
        '$student_id', '$username', '$password', '$first_name', '$last_name', '$dob', '$gender', '$email', '$phone', '$street', '$barangay', '$municipality', '$province', '$year', '$section', '$course', '$role'
    )";

    if (mysqli_query($connection, $query)) {
        $_SESSION['success'] = "Student registered successfully!";
        header("Location: ../student_information_page_data.php");
        exit();
    } else {
        $_SESSION['error'] = "Error: " . $query . "<br>" . mysqli_error($connection);
        header("Location: ../student_information_page_data.php");
        exit();
    }
}

mysqli_close($connection);
?>
