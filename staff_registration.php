<?php
session_start();
include("include/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and retrieve form inputs
    $staff_id = mysqli_real_escape_string($connection, $_POST['staff_id']);
    $username = mysqli_real_escape_string($connection, $_POST['staffUsername']);
    $password = password_hash(mysqli_real_escape_string($connection, $_POST['password']), PASSWORD_DEFAULT); // Hash the password
    $department = mysqli_real_escape_string($connection, $_POST['department']); // Sanitize department input
    $archive = '0';

    // Update query for staff_table
    $updateQuery = "
    UPDATE staff_table
    SET
        username = '$username',
        password = '$password',
        department = '$department',
        archive = '$archive'
    WHERE staff_id = '$staff_id'
    ";

    // Execute the query and handle the result
    if (mysqli_query($connection, $updateQuery)) {
        $_SESSION['success'] = "Staff account details updated successfully.";
    } else {
        $_SESSION['error'] = "Failed to update account details. Please try again.";
    }

    // Redirect to the index page
    header("Location: index.php");
    exit();
} else {
    $_SESSION['error'] = "Invalid request.";
    header("Location: index.php");
    exit();
}
?>
