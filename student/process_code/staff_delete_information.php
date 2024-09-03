<?php
include("../../include/connection.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id'])) {
        $staff_id = $_POST['id'];

        // Delete staff from the database
        $delete_query = "DELETE FROM staff_table WHERE staff_id='$staff_id'";
        $delete_result = mysqli_query($connection, $delete_query);

        if ($delete_result) {
            $_SESSION['success'] = "staff deleted successfully!";
            header("Location: ../staff_information_page_data.php"); // Redirect to the page where staff records are displayed
            exit();
        } else {
            $_SESSION['error'] = "Failed to delete staff!";
            header("Location: ../staff_information_page_data.php"); // Redirect to the page where staff records are displayed
            exit();
        }
    } else {
        $_SESSION['error'] = "staff ID not provided!";
        header("Location: ../staff_information_page_data.php"); // Redirect to the page where staff records are displayed
        exit();
    }
} else {
    // Redirect to index page if accessed directly without POST request
    header("Location: ../staff_information_page_data.php");
    exit();
}
?>
