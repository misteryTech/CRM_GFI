<?php
session_start();
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $studentId = mysqli_real_escape_string($connection, $_POST['studentId']);
    $message = mysqli_real_escape_string($connection, $_POST['message']);
    $status = "Request";

 


    $query = "INSERT INTO message_request_tbl (
        student_id, message, status
    ) VALUES (
        '$studentId', '$message', '$status'
    )";

    if (mysqli_query($connection, $query)) {
        $_SESSION['success'] = "Request Message Send!";
        header("Location: ../message_page.php");
        exit();
    } else {
        $_SESSION['error'] = "Error: " . $query . "<br>" . mysqli_error($connection);
        header("Location: ../message_page.php");
        exit();
    }
}

mysqli_close($connection);
?>
s