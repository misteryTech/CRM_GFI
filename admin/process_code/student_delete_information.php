<?php
include("../../include/connection.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['student_id'])) {
        $student_id = $_POST['student_id'];

        // Delete student from the database
        $delete_query = "DELETE FROM students WHERE id='$student_id'";
        $delete_result = mysqli_query($connection, $delete_query);

        if ($delete_result) {
            $_SESSION['success'] = "Student deleted successfully!";
            header("Location: ../student_information_page_data.php"); // Redirect to the page where student records are displayed
            exit();
        } else {
            $_SESSION['error'] = "Failed to delete student!";
            header("Location: ../student_information_page_data.php"); // Redirect to the page where student records are displayed
            exit();
        }
    } else {
        $_SESSION['error'] = "Student ID not provided!";
        header("Location: ../student_information_page_data.php"); // Redirect to the page where student records are displayed
        exit();
    }
} else {
    // Redirect to index page if accessed directly without POST request
    header("Location: ../student_information_page_data.php");
    exit();
}
?>
