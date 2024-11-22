<?php
include("../../include/connection.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id'])) {
        $teachers_id = $_POST['id'];

        // Delete teachers from the database
        $delete_query = "DELETE FROM teachers_table WHERE teacher_id='$teachers_id'";
        $delete_result = mysqli_query($connection, $delete_query);

        if ($delete_result) {
            $_SESSION['success'] = "teachers deleted successfully!";
            header("Location: ../teachers_information_page_data.php"); // Redirect to the page where teachers records are displayed
            exit();
        } else {
            $_SESSION['error'] = "Failed to delete teachers!";
            header("Location: ../teachers_information_page_data.php"); // Redirect to the page where teachers records are displayed
            exit();
        }
    } else {
        $_SESSION['error'] = "teachers ID not provided!";
        header("Location: ../teachers_information_page_data.php"); // Redirect to the page where teachers records are displayed
        exit();
    }
} else {
    // Redirect to index page if accessed directly without POST request
    header("Location: ../teachers_information_page_data.php");
    exit();
}
?>
