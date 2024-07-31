<?php
session_start();
include("../../include/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $department_name = mysqli_real_escape_string($connection, $_POST['department_name']);


    $query = "INSERT INTO department (
        department_name
    ) VALUES (
        '$department_name'
    )";
s
    if (mysqli_query($connection, $query)) {
        $_SESSION['success'] = "Department registered successfully!";
        header("Location: ../department_registration_page.php");
        exit();
    } else {
        $_SESSION['error'] = "Error: " . $query . "<br>" . mysqli_error($connection);
        header("Location: ../department_registration_page.php");
        exit();
    }s
}

mysqli_close($connection);
?>
