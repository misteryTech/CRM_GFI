<?php
include("../include/connection.php");

if (isset($_POST['staff_id'])) {
    $staff_id = $_POST['staff_id'];

    // Prepare a MySQL query to check if the staff ID exists and fetch the username
    $query = "SELECT username, department FROM staff_table WHERE id_no = ?";

    // Initialize the statement
    $stmt = mysqli_prepare($connection, $query);

    // Bind the parameter
    mysqli_stmt_bind_param($stmt, "s", $staff_id);

    // Execute the statement
    mysqli_stmt_execute($stmt);

    // Store the result
    mysqli_stmt_store_result($stmt);

    // Check if any rows were returned (meaning the staff ID exists)
    if (mysqli_stmt_num_rows($stmt) > 0) {
        // Fetch the username and department
        mysqli_stmt_bind_result($stmt, $username, $department);
        mysqli_stmt_fetch($stmt);

        // Return the username and department as part of the response
        echo json_encode(["status" => "exists", "username" => $username, "department" => $department]);
    } else {
        // If no staff found with the given ID, return 'available'
        echo json_encode(["status" => "available"]);
    }

    // Close the statement
    mysqli_stmt_close($stmt);
}

// Close the database connection
mysqli_close($connection);
?>
