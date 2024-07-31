<?php
include("../../include/connection.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $id = $_POST['id'];
    $role = $_POST['role'];
    $organization_name = $_POST['organization_name'];

    // Update the registration information in the database
    $regQuery = "UPDATE registrations SET role = ?, organization_name = ? WHERE student_id = ?";
    $stmt = $connection->prepare($regQuery);
    $stmt->bind_param("ssi", $role, $organization_name, $id);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Student information updated successfully!";
    } else {
        $_SESSION['error'] = "Failed to update registration information.";
    }

    $stmt->close();
    $connection->close();

    // Redirect back to the main page 
    header("Location: ../organization_information_page_view.php");
    exit();
} else {
    $_SESSION['error'] = "Invalid request method.";
    header("Location: admin_students.php");
    exit();
}
?>
