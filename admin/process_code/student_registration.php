<?php
session_start();
include("../../include/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = mysqli_real_escape_string($connection, $_POST['student_id']);
    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $email = mysqli_real_escape_string($connection, $_POST['email']);


        $query_student = "INSERT INTO students_table (student_id, username, email) VALUES('$student_id', '$username', '$email')";


    if (mysqli_query($connection, $query_student)) {
        $_SESSION['success'] = "Student registered successfully!";
        header("Location: ../student_registration_page.php");

        exit();
    } else {
        $_SESSION['error'] = "Error: " . $query_student . "<br>" . mysqli_error($connection);
        header("Location: ../student_registration_page.php");
        exit();
    }
}

mysqli_close($connection);
?>
