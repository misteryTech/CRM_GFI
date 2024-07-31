<?php 
include("../include/connection.php");
?>

<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $Date = $_POST['date'];
      $Time = $_POST['time'];
      $Title = $_POST['title'];
      $Description = $_POST['description'];
      $Location = $_POST['location'];

      $insert_sql= "INSERT INTO `events`(date, time, title, description, location)
       VALUES ('$Date','$Time','$Title','$Description','$Location')";

$result = $connection->query($insert_sql);

header("Location: admin_event.php");
                exit();

    }
                ?>