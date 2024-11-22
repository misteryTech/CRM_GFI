<?php
session_start();
include("../../include/connection.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize and validate input
    $medicine_name = mysqli_real_escape_string($connection, $_POST['medicine_name']);
    $brand_name = mysqli_real_escape_string($connection, $_POST['brand_name']);
    $medicine_type = mysqli_real_escape_string($connection, $_POST['medicine_type']);
    $expiry_date = mysqli_real_escape_string($connection, $_POST['expiry_date']);
    $manufacturer = mysqli_real_escape_string($connection, $_POST['manufacturer']);
    $dosage = mysqli_real_escape_string($connection, $_POST['dosage']);
    $frequency = mysqli_real_escape_string($connection, $_POST['frequency']);
    $duration = mysqli_real_escape_string($connection, $_POST['duration']);
    $storage_temperature = mysqli_real_escape_string($connection, $_POST['storage_temperature']);
    $storage_instructions = mysqli_real_escape_string($connection, $_POST['storage_instructions']);
    $stock = (int)$_POST['stock']; // Cast to integer for safety
    $reorder = (int)$_POST['reorder']; // Cast to integer for safety

    // Insert into medicines table
    $medicine_query = "INSERT INTO medicines (
        medicine_name, brand_name, medicine_type, expiry_date, manufacturer, dosage, frequency, duration, storage_temperature, storage_instructions, stock, reorder_point
    ) VALUES (
        '$medicine_name', '$brand_name', '$medicine_type', '$expiry_date', '$manufacturer', '$dosage', '$frequency', '$duration', '$storage_temperature', '$storage_instructions', $stock, $reorder
    )";

    if (mysqli_query($connection, $medicine_query)) {
        // Get the ID of the inserted medicine
        $medicine_id = mysqli_insert_id($connection);

        // Insert into reorder_medicine table
        $reorder_query = "INSERT INTO reorder_medicine (medicine_id, current_stock) VALUES ($medicine_id, $stock)";

        if (mysqli_query($connection, $reorder_query)) {
            $_SESSION['success'] = "Medicine and reorder information registered successfully!";
        } else {
            $_SESSION['error'] = "Medicine registered, but failed to save reorder information: " . mysqli_error($connection);
        }
    } else {
        $_SESSION['error'] = "Error registering medicine: " . mysqli_error($connection);
    }

    // Redirect back to the registration page
    header("Location: ../admin_medicine_registration.php");
    exit();
}

// Close the database connection
mysqli_close($connection);
?>
