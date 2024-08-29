<?php
session_start();
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = mysqli_real_escape_string($connection, $_POST['teacher_id']);

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


    $date_hired = mysqli_real_escape_string($connection, $_POST['edit_date_hired']);
    $department = mysqli_real_escape_string($connection, $_POST['edit_department']);
    $position = mysqli_real_escape_string($connection, $_POST['edit_position']);


    $username = mysqli_real_escape_string($connection, $_POST['edit_username']);
    $password = mysqli_real_escape_string($connection, $_POST['edit_password']);

    $query = "UPDATE teachers_table SET
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
        date_hired='$date_hired',
        department='$department',
        position='$position',
        username='$username',
        password='$password'
        WHERE teacher_id='$id'";

    if (mysqli_query($connection, $query)) {
        $_SESSION['success'] = "teacher information updated successfully!";
    } else {
        $_SESSION['error'] = "Error: " . $query . "<br>" . mysqli_error($connection);
    }

    header("Location: ../teachers_information_page_data.php"); // Change this to the appropriate page
    exit();
}

mysqli_close($connection);
?>
