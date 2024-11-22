<?php
session_start();
include("../../include/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
    $stock = mysqli_real_escape_string($connection, $_POST['stock']);

    $query = "INSERT INTO medicines (
        medicine_name, brand_name, medicine_type, expiry_date, manufacturer, dosage, frequency, duration, storage_temperature, storage_instructions, stock
    ) VALUES (
        '$medicine_name', '$brand_name', '$medicine_type', '$expiry_date', '$manufacturer', '$dosage', '$frequency', '$duration', '$storage_temperature', '$storage_instructions', '$stock'
    )";

    if (mysqli_query($connection, $query)) {
        $_SESSION['success'] = "Medicine registered successfully!";
        header("Location: ../admin_medicine_registration.php");
        exit();
    } else {
        $_SESSION['error'] = "Error: " . $query . "<br>" . mysqli_error($connection);
        header("Location: ../admin_medicine_registration.php");
        exit();
    }
}

mysqli_close($connection);
?>
