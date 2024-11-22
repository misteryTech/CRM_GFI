<?php
session_start();
include("../../include/connection.php");

// Check if staff is logged in
if (!isset($_SESSION['staff_id'])) {
    $_SESSION['error'] = "You must be logged in to update your account details.";
    header("Location: ../login_staff.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get staff ID from session
    $staff_id = mysqli_real_escape_string($connection, $_SESSION['staff_id']);

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
    $position = mysqli_real_escape_string($connection, $_POST['position']);
    $department = mysqli_real_escape_string($connection, $_POST['department']);
    $date_hired = mysqli_real_escape_string($connection, $_POST['date_hired']);
    $archive = mysqli_real_escape_string($connection, $_POST['archive']);

    // Update query
    $updateQuery = "
        UPDATE staff_table
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
            position = '$position',
            department = '$department',
            date_hired = '$date_hired',
            archive = '$archive'
        WHERE staff_id = '$staff_id'
    ";

    // Execute the query
    if (mysqli_query($connection, $updateQuery)) {
        $_SESSION['success'] = "Account details updated successfully.";
    } else {
        $_SESSION['error'] = "Failed to update account details. Error: " . mysqli_error($connection);
    }

    header("Location: ../account_details_page.php");
    exit();
} else {
    $_SESSION['error'] = "Invalid request.";
    header("Location: ../account_details_page.php");
    exit();
}

// Close the database connection
mysqli_close($connection);
?>
