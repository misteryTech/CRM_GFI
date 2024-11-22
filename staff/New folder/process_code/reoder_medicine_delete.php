<?php
include("../../include/connection.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['reorder_id'])) {
        $reorder_id = $_POST['reorder_id'];

        // Delete Reorder from the database
        $delete_query = "DELETE FROM reorder_medicine WHERE reorder_id='$reorder_id'";
        $delete_result = mysqli_query($connection, $delete_query);

        if ($delete_result) {
            $_SESSION['success'] = "Reorder deleted successfully!";
            header("Location: ../admin_reorder_list.php"); // Redirect to the page where Reorder records are displayed
            exit();
        } else {
            $_SESSION['error'] = "Failed to delete Reorder!";
            header("Location: ../admin_reorder_list.php"); // Redirect to the page where Reorder records are displayed
            exit();
        }
    } else {
        $_SESSION['error'] = "Reorder ID not provided!";
        header("Location: ../admin_reorder_list.php"); // Redirect to the page where Reorder records are displayed
        exit();
    }
} else {
    // Redirect to index page if accessed directly without POST request
    header("Location: ../admin_reorder_list.php");
    exit();
}
?>
