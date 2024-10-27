<?php
// Include your database connectionection file
include('connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $student_id = $_POST['student_id'];
    $chief_complain = $_POST['chief_complain'];

    // File upload
    if (isset($_FILES['documents']) && $_FILES['documents']['error'] === UPLOAD_ERR_OK) {
        // Set the upload directory and file name
        $uploadDir = 'uploads/';
        $fileName = basename($_FILES['documents']['name']);
        $uploadFilePath = $uploadDir . $fileName;

        // Move the uploaded file
        if (move_uploaded_file($_FILES['documents']['tmp_name'], $uploadFilePath)) {
            // Insert data into student_illnes table
            $query = "INSERT INTO student_illness (student_id, documents, chief_complain) VALUES (?, ?, ?)";
            $stmt = $connection->prepare($query);
            $stmt->bind_param("sss", $student_id, $fileName, $chief_complain);

            if ($stmt->execute()) {
                $_SESSION['success'] = "Medicine registered successfully!";
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

    // Close the database connectionection
    $connection->close();
}
?>
