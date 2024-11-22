<?php
session_start();
include("../../include/connection.php");

if (isset($_POST['organization_id'])) {
    $organization_id = mysqli_real_escape_string($connection, $_POST['organization_id']);
    $organization_name = mysqli_real_escape_string($connection, $_POST['edit_organization_name']);
    $department = mysqli_real_escape_string($connection, $_POST['edit_department']);
    $advisor_name = mysqli_real_escape_string($connection, $_POST['edit_advisor_name']);

    $query = "UPDATE organizations SET organization_name='$organization_name', department='$department', advisor_name='$advisor_name' WHERE id='$organization_id'";

    if (mysqli_query($connection, $query)) {
        $_SESSION['success'] = "Organization information updated successfully.";
    } else {
        $_SESSION['error'] = "Failed to update organization information.";
    }

    header("Location: ../view_organization_reg_page.php");
    exit();
} else {
    $_SESSION['error'] = "Invalid request.";
    header("Location: ../view_organization_reg_page.php");
    exit();
}
?>
