<?php
include("../include/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $event_id = $_POST['event_id'];
    $title = $_POST['edit_title'];
    $description = $_POST['edit_description'];
    $date = $_POST['edit_date'];

    // Handle image upload
    $image_path = null;
    if (isset($_FILES['edit_image']) && $_FILES['edit_image']['error'] == 0) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["edit_image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];

        // Check if image file is a valid image type
        if (in_array($imageFileType, $allowed_types)) {
            if (move_uploaded_file($_FILES["edit_image"]["tmp_name"], $target_file)) {
                $image_path = $target_file;
            } else {
                echo "Sorry, there was an error uploading your file.";
                exit();
            }
        } else {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            exit();
        }
    }

    // If no new image is uploaded, keep the existing image path
    if ($image_path === null) {
        $sql = "SELECT image_path FROM events WHERE id='$event_id'";
        $result = mysqli_query($connection, $sql);
        $row = mysqli_fetch_assoc($result);
        $image_path = $row['image_path'];
    }

    $sql = "UPDATE events SET title='$title', description='$description', date='$date', image_path='$image_path' WHERE id='$event_id'";

    if (mysqli_query($connection, $sql)) {
        header("Location: gallery_events_table_page.php");
    } else {
        echo "Error updating record: " . mysqli_error($connection);
    }

    mysqli_close($connection);
}
?>
