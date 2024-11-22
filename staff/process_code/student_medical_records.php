<?php
session_start();
include("connection.php");

$student_id = $_POST['student_id'];
$illness = $_POST['illness'];
$symptoms = $_POST['symptoms'];
$date_diagnosed = $_POST['date_diagnosed'];
$note = $_POST['note'];
$medicines = $_POST['medicine_id']; // Array of medicine IDs
$quantities = $_POST['quantity']; // Array of corresponding quantities
$role = 1; // Assuming role is an integer

// Begin a transaction
$connection->begin_transaction();

try {
    // Insert into student_clinic_record_table
    $stmt = $connection->prepare("INSERT INTO student_clinic_record_table (student_id, illness, symptoms, date_diagnosed, note) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $student_id, $illness, $symptoms, $date_diagnosed, $note);
    $stmt->execute();

    // Get the last inserted record ID
    $record_id = $connection->insert_id;

    // Prepare statement for inserting prescribed medicine
    $stmt_medicine = $connection->prepare("INSERT INTO prescribed_medicine_table (record_id, medicine_id, quantity, role) VALUES (?, ?, ?, ?)");

    // Prepare statement for querying current stock
    $stmt_check_stock = $connection->prepare("SELECT stock FROM medicines WHERE id = ?");

    // Prepare statement for updating medicine stock
    $stmt_stock = $connection->prepare("UPDATE medicines SET stock = stock - ? WHERE id = ?");

    // Process each medicine in the arrays
    for ($i = 0; $i < count($medicines); $i++) {
        $medicine_id = $medicines[$i];
        $quantity = $quantities[$i];

        if (!empty($medicine_id) && !empty($quantity) && $quantity > 0) {
            // Check current stock
            $stmt_check_stock->bind_param("i", $medicine_id);
            $stmt_check_stock->execute();

            // Fetch the result and store it
            $stmt_check_stock->store_result();
            $stmt_check_stock->bind_result($current_stock);

            if (!$stmt_check_stock->fetch()) {
                throw new Exception("Medicine ID: $medicine_id does not exist.");
            }

            // Free the result set to avoid "Commands out of sync" error
            $stmt_check_stock->free_result();

            // Check if there is enough stock
            if ($current_stock < $quantity) {
                throw new Exception("Insufficient stock for medicine ID: $medicine_id");
            }

            // Insert into prescribed_medicine_table
            $stmt_medicine->bind_param("iiii", $record_id, $medicine_id, $quantity, $role);
            $stmt_medicine->execute();

            // Update medicine stock
            $stmt_stock->bind_param("ii", $quantity, $medicine_id);
            $stmt_stock->execute();

            // Check if the stock update was successful
            if ($stmt_stock->affected_rows === 0) {
                throw new Exception("Failed to update medicine stock for medicine ID: $medicine_id");
            }
        }
    }

    // Commit the transaction
    $connection->commit();

    $_SESSION['success'] = "Medical record successfully added!";
    header("Location: ../student_release_form_page.php?student_id=$student_id");
    exit();

} catch (Exception $e) {
    // Rollback the transaction if something went wrong
    $connection->rollback();
    $_SESSION['error'] = "Failed to add record: " . $e->getMessage();
    header("Location: ../student_release_form_page.php?student_id=$student_id");
    exit();
}
?>
