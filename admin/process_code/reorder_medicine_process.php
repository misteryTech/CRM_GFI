<?php
session_start();
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $medicine_id = mysqli_real_escape_string($connection, $_POST['medicine_id']);
    $current_stock = mysqli_real_escape_string($connection, $_POST['current_stock']);
    $reorder_quantity = mysqli_real_escape_string($connection, $_POST['reorder_quantity']);
    $reorder_date = date('Y-m-d');  // Assuming the reorder date is the current date
    $reorder_status = "Pending";    // Default status for a new reorder
    $status = "On Process";         // New status for the medicine

    // Update the status in the medicines table
    $update_query = "UPDATE medicines SET status='$status' WHERE id='$medicine_id'";

    if (mysqli_query($connection, $update_query)) {
        // Insert the reorder information into reorder_medicine table
        $insert_query = "INSERT INTO reorder_medicine (
            medicine_id, current_stock, reorder_quantity, reorder_status, reorder_date
        ) VALUES (
            '$medicine_id', '$current_stock', '$reorder_quantity', '$reorder_status', '$reorder_date'
        )";

        if (mysqli_query($connection, $insert_query)) {
            $_SESSION['success'] = "Reorder request created successfully!";
        } else {
            $_SESSION['error'] = "Error: " . $insert_query . "<br>" . mysqli_error($connection);
        }
    } else {
        $_SESSION['error'] = "Error: " . $update_query . "<br>" . mysqli_error($connection);
    }

    header("Location: ../admin_med_stock.php");
    exit();
}

mysqli_close($connection);
?>
