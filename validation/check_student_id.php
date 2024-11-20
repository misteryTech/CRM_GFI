<?php
include("../include/connection.php");


if (isset($_POST['student_id'])) {
    $student_id = $_POST['student_id'];

    // Prepare a MySQL query to check if the student ID exists and fetch the username
    $query = "SELECT username FROM students_table WHERE student_id = ?";

    // Initialize the statement
    $stmt = mysqli_prepare($connection, $query);

    // Bind the parameter
    mysqli_stmt_bind_param($stmt, "s", $student_id);

    // Execute the statement
    mysqli_stmt_execute($stmt);

    // Store the result
    mysqli_stmt_store_result($stmt);

    // Check if any rows were returned (meaning the student ID exists)
    if (mysqli_stmt_num_rows($stmt) > 0) {
        // Fetch the username
        mysqli_stmt_bind_result($stmt, $username);
        mysqli_stmt_fetch($stmt);

        // Return the username as part of the response
        echo json_encode(["status" => "exists", "username" => $username]);
    } else {
        // If no student found with the given ID, return 'available'
        echo json_encode(["status" => "available"]);
    }

    // Close the statement
    mysqli_stmt_close($stmt);
}

// Close the database connection
mysqli_close($connection);
?>
