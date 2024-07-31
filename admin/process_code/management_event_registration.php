<?php
session_start();

// Database connection parameters
if ($_SERVER["REQUEST_METHOD"] == "POST") {


    $title = htmlspecialchars($_POST['title']);
    $description = htmlspecialchars($_POST['description']);
    $date = htmlspecialchars($_POST['date']);




$servername = "localhost";
$username = "root";
$password = "";
$dbname = "soms_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and bind the INSERT statement
$stmt = $conn->prepare("INSERT INTO management_events (title, description, date) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $title, $description, $date);

// Set parameters and execute


if ($stmt->execute()) {
    $_SESSION['message'] = "New event added successfully";
    $_SESSION['message_type'] = "alert-success";
} else {
    $_SESSION['message'] = "Error: " . $stmt->error;
    $_SESSION['message_type'] = "alert-danger";
}

// Close statement and connection
$stmt->close();
$conn->close();

// Redirect back to the form page
header("Location: ../management_event_page.php");
exit();
}
?>
