<?php
session_start();
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $medicine_id = mysqli_real_escape_string($connection, $_POST['medicine_id']);
    $current_stock = (int)mysqli_real_escape_string($connection, $_POST['current_stock']);
    $reorder_quantity = (int)mysqli_real_escape_string($connection, $_POST['reorder_quantity']); // Restock quantity
    $reorder_date = date('Y-m-d'); // Current date for reorder
    $reorder_status = "Pending"; // Default reorder status

    // Ensure reorder quantity is positive
    if ($reorder_quantity <= 0) {
        $_SESSION['error'] = "Restock quantity must be greater than zero.";
        header("Location: ../admin_med_stock.php");
        exit();
    }

    // Start the transaction
    mysqli_begin_transaction($connection);

    try {
        // Calculate the new stock
        $new_stock = $current_stock + $reorder_quantity;

        // Update the stock in the medicines table
        $update_stock_query = "UPDATE medicines SET stock='$new_stock' WHERE id='$medicine_id'";
        if (!mysqli_query($connection, $update_stock_query)) {
            throw new Exception("Failed to update stock: " . mysqli_error($connection));
        }

        // Insert into the reorder_medicine table
        $insert_reorder_query = "INSERT INTO reorder_medicine (
            medicine_id, current_stock, reorder_quantity, reorder_status, reorder_date, total_request
        ) VALUES (
            '$medicine_id', '$current_stock', '$reorder_quantity', '$reorder_status', '$reorder_date', '$new_stock'
        )";
        if (!mysqli_query($connection, $insert_reorder_query)) {
            throw new Exception("Failed to insert reorder data: " . mysqli_error($connection));
        }

        // Commit the transaction
        mysqli_commit($connection);
        $_SESSION['success'] = "Stock updated and reorder logged successfully!";
    } catch (Exception $e) {
        // Rollback the transaction on error
        mysqli_rollback($connection);
        $_SESSION['error'] = $e->getMessage();
    }

    // Redirect to the stock management page
    header("Location: ../admin_med_stock.php");
    exit();
}

mysqli_close($connection);
?>
