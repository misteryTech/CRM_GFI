<?php
include("connection.php");

$student_id = $_POST['student_id'];
$illness = $_POST['illness'];
$symptoms = $_POST['symptoms'];
$date_diagnosed = $_POST['date_diagnosed'];
$note = $_POST['note'];
$medicines = $_POST['medicines']; // Array of medicine IDs
$dosages = $_POST['dosages']; // Array of corresponding dosages

// Begin a transaction
$connection->begin_transaction();

try {
    // Insert into student_clinic_record_table
    $stmt = $connection->prepare("INSERT INTO student_clinic_record_table (student_id, illness, symptoms, date_diagnosed, note) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $student_id, $illness, $symptoms, $date_diagnosed, $note);
    $stmt->execute();

    // Get the last inserted record ID
    $record_id = $connection->insert_id;

    // Insert each prescribed medicine
    $stmt_medicine = $connection->prepare("INSERT INTO prescribed_medicine_table (record_id, medicine_id, dosage) VALUES (?, ?, ?)");
    for ($i = 0; $i < count($medicines); $i++) {
        $medicine_id = $medicines[$i];
        $dosage = $dosages[$i];
        $stmt_medicine->bind_param("iis", $record_id, $medicine_id, $dosage);
        $stmt_medicine->execute();
    }

    // Commit the transaction
    $connection->commit();

    echo "Record added successfully!";
} catch (Exception $e) {
    // Rollback the transaction if something went wrong
    $connection->rollback();
    echo "Failed to add record: " . $e->getMessage();
}
?>
