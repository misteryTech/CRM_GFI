<?php
session_start();
include("include//connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and retrieve form inputs
    $student_id = mysqli_real_escape_string($connection, $_POST['student_id']);
    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $password = password_hash(mysqli_real_escape_string($connection, $_POST['password']), PASSWORD_DEFAULT); // Hash the password
    $first_name = mysqli_real_escape_string($connection, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($connection, $_POST['last_name']);
    $dob = mysqli_real_escape_string($connection, $_POST['dob']);
    $gender = mysqli_real_escape_string($connection, $_POST['gender']);
    $year = mysqli_real_escape_string($connection, $_POST['year']);
    $section = mysqli_real_escape_string($connection, $_POST['section']);
    $course = mysqli_real_escape_string($connection, $_POST['course']);
    $archive = '0';

    // Insert query using prepared statements
    $query = "INSERT INTO students_table 
              (student_id, username, password, first_name, last_name, dob, gender, year, section, course, archive) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "sssssssssss", $student_id, $username, $password, $first_name, $last_name, $dob, $gender, $year, $section, $course, $archive);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['success'] = "Student registered successfully!";
        header("Location: registration.php");
        exit();
    } else {
        $_SESSION['error'] = "Error: " . mysqli_error($connection);
        header("Location: registration.php");
        exit();
    }

    // Close the statement and connection
    mysqli_stmt_close($stmt);
    mysqli_close($connection);
}
?>
