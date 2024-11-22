<?php
include("../../include/connection.php");

if (isset($_POST['id'])) {
    $event_id = $_POST['id'];

    $query = "SELECT title, description, date, image_path FROM events WHERE id = '$event_id'";
    $result = mysqli_query($connection, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $event = mysqli_fetch_assoc($result);
        echo json_encode($event);
    } else {
        echo json_encode(['error' => 'Event not found']);
    }   
}
?>
s