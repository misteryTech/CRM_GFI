<?php
include("../process_code/connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['staff_id'])) {
    $id_no = trim($_POST['staff_id']); // Sanitize input

    // Check if the ID number is not empty
    if (empty($id_no)) {
        echo "invalid"; // Invalid input
        exit;
    }

    // Prepare the MySQL query to check if the ID number exists
    $query = "SELECT 1 FROM staff_table WHERE staff_id = ?";
    
    if ($stmt = mysqli_prepare($connection, $query)) {
        // Bind the parameter to the prepared statement
        mysqli_stmt_bind_param($stmt, "s", $id_no);

        // Execute the statement
        mysqli_stmt_execute($stmt);

        // Store the result to check the number of rows
        mysqli_stmt_store_result($stmt);

        // Respond based on the query result
        if (mysqli_stmt_num_rows($stmt) > 0) {
            echo "exists";  // ID number found in the database
        } else {
            echo "available";  // ID number does not exist
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        echo "error"; // Error in preparing the statement
    }
} else {
    echo "invalid_request"; // Invalid request method or missing parameters
}

// Close the database connection
mysqli_close($connection);
?>
