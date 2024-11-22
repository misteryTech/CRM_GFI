<?php
session_start();
include("../../include/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $staff_id = mysqli_real_escape_string($connection, $_POST['staff_id']);
    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $email = mysqli_real_escape_string($connection, $_POST['email']);


        $query_straff = "INSERT INTO staff_table (id_no, username, email) VALUES('$staff_id', '$username', '$email')";


    if (mysqli_query($connection, $query_straff)) {
        $_SESSION['success'] = "staff registered successfully!";
        header("Location: ../staff_registration_page.php");

        exit();
    } else {
        $_SESSION['error'] = "Error: " . $query_straff . "<br>" . mysqli_error($connection);
        header("Location: ../staff_registration_page.php");
        exit();
    }
}

mysqli_close($connection);
?>
