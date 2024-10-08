<?php
session_start();
include("include/connection.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);

    // Query to find the user with the provided username
    $query = "SELECT * FROM students_table WHERE username = '$username'";
    $result = mysqli_query($connection, $query);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $stored_password = $row['password'];


        // Verify the password
        if ($password === $stored_password) {
            // Password is correct, set the session variables
            $_SESSION['username'] = $row['username'];
            $_SESSION['student_id'] = $row['student_id'];

            header("Location: student/student_dashboard.php");
            // Redirect based on role
            exit();
        } else {
            // Incorrect password
            $_SESSION['error'] = "Invalid username or password!";
            header("Location: login.php");
            exit();
        }
    } else {
        // Username not found
        $_SESSION['error'] = "Invalid username or password!";
        header("Location: login.php");
        exit();
    }
}

// Close the database connection
mysqli_close($connection);
?>
