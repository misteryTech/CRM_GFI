<?php
session_start();
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
    $department = mysqli_real_escape_string($connection, $_POST['department']);
    $position = mysqli_real_escape_string($connection, $_POST['position']);
    $date_hired = mysqli_real_escape_string($connection, $_POST['date_hired']);

    $query = "INSERT INTO teachers_table (
        username, password, first_name, last_name, dob, gender, email, phone, street, barangay, municipality, province, department, position, date_hired
    ) VALUES (
        '$username', '$password', '$first_name', '$last_name', '$dob', '$gender', '$email', '$phone', '$street', '$barangay', '$municipality', '$province', '$department', '$position', '$date_hired'
    )";

    if (mysqli_query($connection, $query)) {
        $_SESSION['success'] = "Teacher registered successfully!";
        header("Location: ../teacher_registration_page.php");
        exit();
    } else {
        $_SESSION['error'] = "Error: " . $query . "<br>" . mysqli_error($connection);
        header("Location: ../teacher_registration_page.php");
        exit();
    }
}

mysqli_close($connection);
?>
