<?php
session_start();
include("include//connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and retrieve form inputs
    $student_id = mysqli_real_escape_string($connection, $_POST['student_id']);
    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $password = password_hash(mysqli_real_escape_string($connection, $_POST['password']), PASSWORD_DEFAULT); // Hash the password
    $archive = '0';



    $updateQuery = "
    
    UPDATE students_table
    SET
        username = '$username',
        password = '$password',
        archive = '$archive'

    WHERE student_id = '$student_id'
";

if (mysqli_query($connection, $updateQuery)) {
    $_SESSION['success'] = "Account details updated successfully.";
} else {
    $_SESSION['error'] = "Failed to update account details. Please try again.";
}

header("Location: index.php");
exit();
} else {
$_SESSION['error'] = "Invalid request.";
header("Location: index.php");
exit();
}

?>
