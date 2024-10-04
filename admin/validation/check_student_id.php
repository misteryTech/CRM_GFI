<?php
include("../process_code/connection.php");

if (isset($_POST['student_id'])) {
    $student_id = $_POST['student_id'];

    // Prepare a MySQL query to check if the student ID exists
    $query = "SELECT * FROM students_table WHERE student_id = ?";
    
    // Initialize the statement
    $stmt = mysqli_prepare($connection, $query);
    
    // Bind the parameter
    mysqli_stmt_bind_param($stmt, "s", $student_id);
    
    // Execute the statement
    mysqli_stmt_execute($stmt);
    
    // Store the result to check the number of rows
    mysqli_stmt_store_result($stmt);
    
    // Check if any rows were returned
    if (mysqli_stmt_num_rows($stmt) > 0) {
        echo "exists";  // Student ID found in the database
    } else {
        echo "not exists";  // Student ID does not exist
    }
    
    // Close the statement
    mysqli_stmt_close($stmt);
}

// Close the database connection
mysqli_close($connection);
?>
