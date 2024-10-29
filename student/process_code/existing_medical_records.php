<?php
// Include your database connection file
include('connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $student_id = $_POST['student_id'];
    $chief_complain = $_POST['chief_complain'];
    $illness = $_POST['illness'];
    $allergic_reaction = $_POST['allergic_reaction'];
    $medication = $_POST['medication'];
    $dose = $_POST['dose'];
    $times_per_day = $_POST['times_per_day'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // File upload
    if (isset($_FILES['documents']) && $_FILES['documents']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        $fileName = basename($_FILES['documents']['name']);
        $uploadFilePath = $uploadDir . $fileName;

        // Move the uploaded file
        if (move_uploaded_file($_FILES['documents']['tmp_name'], $uploadFilePath)) {
            // Insert data into student_illness table
            $query = "INSERT INTO student_illness (student_id, documents, chief_complain, illness, allergic_reaction, medication, dose, times_per_day, start_date, end_date) 
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $connection->prepare($query);
            $stmt->bind_param("ssssssssss", $student_id, $fileName, $chief_complain, $illness, $allergic_reaction, $medication, $dose, $times_per_day, $start_date, $end_date);

            if ($stmt->execute()) {
                $_SESSION['success'] = "Medical record updated successfully!";
                header("Location: ../pre_existing_medical_records.php");
                exit();
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "File upload failed.";
        }
    } else {
        echo "No file uploaded or there was an upload error.";
    }

    // Close the database connection
    $connection->close();
}
?>
