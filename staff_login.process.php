<?php
session_start();
include("include/connection.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $password = $_POST['password']; // No need to sanitize password, as it's not directly used in the query

    // Query to find the user with the provided username (for staff)
    $query = "SELECT * FROM staff_table WHERE username = ?";
    $stmt = mysqli_prepare($connection, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            $stored_password = $row['password'];

            // Verify the password
            if (password_verify($password, $stored_password)) {
                // Password is correct, set the session variables
                $_SESSION['username'] = $row['username'];
                $_SESSION['staff_id'] = $row['staff_id']; // Assuming staff has a unique ID

                // Redirect to the staff dashboard
                header("Location: staff/staff_dashboard.php");
                exit();
            } else {
                // Incorrect password
                $_SESSION['error'] = "Invalid username or password!";
                header("Location: index.php");
                exit();
            }
        } else {
            // Username not found
            $_SESSION['error'] = "Invalid username or password!";
            header("Location: index.php");
            exit();
        }

        mysqli_stmt_close($stmt);
    } else {
        // Query preparation failed
        $_SESSION['error'] = "Error preparing query: " . mysqli_error($connection);
        header("Location: index.php");
        exit();
    }
}

// Close the database connection
mysqli_close($connection);
?>
