<?php
session_start();
include("../../include/connection.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and escape input
    $organization_name = mysqli_real_escape_string($connection, $_POST['organization_name']);
    $department = mysqli_real_escape_string($connection, $_POST['department']);
    $advisor_name = mysqli_real_escape_string($connection, $_POST['advisor_name']);
    $contact_email = mysqli_real_escape_string($connection, $_POST['contact_email']);
    
    // Handle file upload
    if (isset($_FILES['organization_logo']) && $_FILES['organization_logo']['error'] == 0) {
        $logo = $_FILES['organization_logo'];
        $logo_name = $logo['name'];
        $logo_tmp_name = $logo['tmp_name'];
        $logo_size = $logo['size'];
        $logo_error = $logo['error'];
        $logo_type = $logo['type'];

        // Check file type and size
        $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
        $logo_ext = explode('.', $logo_name);
        $logo_actual_ext = strtolower(end($logo_ext));

        if (in_array($logo_actual_ext, $allowed_types) && $logo_size <= 5000000) {
            $logo_new_name = uniqid('', true) . "." . $logo_actual_ext;
            $logo_destination = '../uploads/' . $logo_new_name;

            if (move_uploaded_file($logo_tmp_name, $logo_destination)) {
                // Insert organization data into the database
                $query = "INSERT INTO organizations (organization_name, department, advisor_name, contact_email, logo, created_at)
                          VALUES ('$organization_name', '$department', '$advisor_name', '$contact_email', '$logo_new_name', NOW())";

                if (mysqli_query($connection, $query)) {
                    $_SESSION['success'] = "Organization registered successfully!";
                } else {
                    $_SESSION['error'] = "Error: " . mysqli_error($connection);
                }
            } else {
                $_SESSION['error'] = "Error uploading file.";
            }
        } else {
            $_SESSION['error'] = "Invalid file type or size.";
        }
    } else {
        $_SESSION['error'] = "Error with file upload.";
    }

    mysqli_close($connection);

    header("Location: ../organization_registration_page.php");
    exit();
}
?>
