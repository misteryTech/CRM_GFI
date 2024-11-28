<?php
include("connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message_id'])) {
    $message_id = intval($_POST['message_id']); // Get and sanitize the message ID

    // Update the message status to 'Read'
    $update_query = "UPDATE message_request_tbl SET status = 'Read' WHERE message_id = ?";
    $stmt = mysqli_prepare($connection, $update_query);
    mysqli_stmt_bind_param($stmt, 'i', $message_id);

    if (mysqli_stmt_execute($stmt)) {
        echo "Status updated successfully.";
    } else {
        echo "Error updating status: " . mysqli_error($connection);
    }

    mysqli_stmt_close($stmt);
}
?>
