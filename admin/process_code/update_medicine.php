<?php
// Include database connection
include('connection.php'); // Ensure to replace this with your actual database connection file

// Check if the form is submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the posted data
    $id = $_POST['id'];
    $medicine_name = $_POST['medicine_name'];
    $stock = $_POST['stock'];
    $reorder_point = $_POST['reorder_point'];

    // Validate inputs
    if (empty($medicine_name) || empty($stock) || empty($reorder_point)) {
        // Handle errors if fields are empty
        echo "All fields are required.";
        exit;
    }

    // Prepare SQL query to update the medicine record
    $query = "UPDATE medicines SET medicine_name = ?, stock = ?, reorder_point = ? WHERE id = ?";

    // Prepare the statement
    if ($stmt = mysqli_prepare($connection, $query)) {
        // Bind the parameters
        mysqli_stmt_bind_param($stmt, "ssii", $medicine_name, $stock, $reorder_point, $id);

        // Execute the statement
        if (mysqli_stmt_execute($stmt)) {
            // Redirect back to the previous page (or to a success page)
            header("Location: ../admin_med_stock.php?update=success"); // Update the URL as needed
            exit;
        } else {
            // Handle errors if execution fails
            echo "Error updating record: " . mysqli_error($connection);
        }

        // Close the prepared statement
        mysqli_stmt_close($stmt);
    } else {
        // Handle errors if preparation fails
        echo "Error preparing statement: " . mysqli_error($connection);
    }

    // Close the database connection
    mysqli_close($connection);
}
?>
