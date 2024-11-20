<?php
include("../process_code/connection.php");

if (isset($_POST['username'])) {
    $username = $_POST['username'];

    // Prepare a MySQL query to check if the username exists in the students table
    $query = "SELECT * FROM students_table WHERE username = ?";

    // Initialize the statement
    $stmt = mysqli_prepare($connection, $query);

    // Bind the parameter
    mysqli_stmt_bind_param($stmt, "s", $username);

    // Execute the statement
    mysqli_stmt_execute($stmt);

    // Store the result to check if any rows were returned
    mysqli_stmt_store_result($stmt);

    // Check if any rows were returned (i.e., the username exists)
    if (mysqli_stmt_num_rows($stmt) > 0) {
        echo "exists";  // Username found in the database
    } else {
        echo "available";  // Username does not exist
    }

    // Close the statement
    mysqli_stmt_close($stmt);
}

// Close the database connection
mysqli_close($connection);
?>
