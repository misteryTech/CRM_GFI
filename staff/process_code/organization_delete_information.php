<?php
session_start();
include("../../include/connection.php");

if (isset($_POST['organization_id'])) {
    $organization_id = mysqli_real_escape_string($connection, $_POST['organization_id']);

    $query = "DELETE FROM organizations WHERE id='$organization_id'";

    if (mysqli_query($connection, $query)) {
        $_SESSION['success'] = "Organization deleted successfully.";
    } else {
        $_SESSION['error'] = "Failed to delete organization.";
    }

    header("Location: ../view_organization_reg_page.php");
    exit();
} else {
    $_SESSION['error'] = "Invalid request.";
    header("Location: ../view_organization_reg_page.php");
    exit();
}
?>
