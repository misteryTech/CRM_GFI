<?php
include("../process_code/connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'])) {
    $username = trim($_POST['username']); // Sanitize input

    // Check if the username is not empty
    if (empty($username)) {
        echo "error"; // Invalid input
        exit;
    }

    // Prepare a query to check if the username exists in the staff_table
    $query = "SELECT 1 FROM staff_table WHERE username = ?";

    if ($stmt = mysqli_prepare($connection, $query)) {
        // Bind the parameter
        mysqli_stmt_bind_param($stmt, "s", $username);

        // Execute the statement
        mysqli_stmt_execute($stmt);

        // Store the result
        mysqli_stmt_store_result($stmt);

        // Check if any rows were returned
        if (mysqli_stmt_num_rows($stmt) > 0) {
            echo "exists"; // Username found in the database
        } else {
            echo "available"; // Username does not exist
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        echo "error"; // Error preparing the statement
    }
} else {
    echo "error"; // Invalid request method or missing parameters
}

// Close the database connection
mysqli_close($connection);
?>
