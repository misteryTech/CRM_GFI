<?php
include("../../include/connection.php");

// Fetch events from the database
$query = "SELECT id, title, description, date FROM events";
$result = mysqli_query($connection, $query);

$events = array();
while($row = mysqli_fetch_assoc($result)) {
    $events[] = array(
        'id' => $row['id'],
        'title' => $row['title'],
        'start' => $row['date'],
        'description' => $row['description']
    );
}

// Return the events as JSON
echo json_encode($events);

mysqli_close($connection);
?>
