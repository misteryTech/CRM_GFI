<?php
// Include the database connection file
include("connection.php");

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data from POST
    $medicine_id = $_POST['medicine_id'];
    $medicine_stock = $_POST['medicine_stock'];
    $medicine_reorder_quantity = $_POST['medicine_reorder_quantity'];
    $medicine_additional_notes = $_POST['medicine_additional_notes'];
    $reorder_id = $_POST['reorder_id'];

    $status = "Received";
    $medicine_status  = "Received";
    $date = date("Y-m-d");

    // Start a database transaction
    $connection->begin_transaction();

    // Flag to track if all operations are successful
    $success = true;

    // Retrieve the current quantity in stock for the specific medicine
    $stmt = $connection->prepare("SELECT stock FROM medicines WHERE id = ?");
    $stmt->bind_param("i", $medicine_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the medicine exists
    if ($result->num_rows === 0) {
        $success = false;
        echo "Medicine not found.";
    } else {
        // Fetch the current stock quantity
        $current_stock = $result->fetch_assoc()['stock'];
        $stmt->close();

        // Calculate new stock quantity after reorder
        $new_stock = $current_stock + $medicine_reorder_quantity;

        // Update the quantity in stock for the medicine
        $stmt = $connection->prepare("UPDATE medicines SET stock = ?, status = ? WHERE id = ?");
        $stmt->bind_param("iss", $new_stock, $medicine_status, $medicine_id);
        if (!$stmt->execute()) {
            $success = false;
            echo "Error updating stock.";
        }
        $stmt->close();

        // Update the reorders table with new information
        $stmt = $connection->prepare("UPDATE reorder_medicine SET reorder_status = ?, additional_notes = ?, reorder_process_date = ? WHERE reorder_id = ?");
        $stmt->bind_param("sssi", $status, $medicine_additional_notes, $date, $reorder_id);
        if (!$stmt->execute()) {
            $success = false;
            echo "Error updating reorder.";
        }
        $stmt->close();
    }

    if ($success) {
        // Commit the transaction if all operations succeed
        $connection->commit();
        // Redirect to a success page or display a success message
        header('Location: ../admin_reorder_list.php');
        exit();
    } else {
        // Rollback the transaction if any operation fails
        $connection->rollback();
        echo "Transaction failed. Please try again.";
    }
}
?>
