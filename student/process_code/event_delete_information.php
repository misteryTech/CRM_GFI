<?php
include("../../include/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $event_id = $_POST['event_id'];

    // Fetch the current image path to delete the file
    $sql = "SELECT image_path FROM events WHERE id='$event_id'";
    $result = mysqli_query($connection, $sql);
    $row = mysqli_fetch_assoc($result);
    $image_path = $row['image_path'];

    // Delete the event from the database
    $sql = "DELETE FROM events WHERE id='$event_id'";

    if (mysqli_query($connection, $sql)) {
        // Optionally delete the image file from the server
        if ($image_path && file_exists($image_path)) {
            unlink($image_path);
        }
        header("Location: admin_events.php");
    } else {
        echo "Error deleting record: " . mysqli_error($connection);
    }

    mysqli_close($connection);
}
?>
