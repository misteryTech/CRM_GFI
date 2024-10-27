<?php
session_start();
include("connection.php");

// Check if form data is set
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['message_id'], $_POST['student_id'], $_POST['reply_message'])) {
        $message_id = $_POST['message_id'];
        $reply_message = $_POST['reply_message'];

        // Assuming the user session has a user_id or similar identifier
        $user_id = $_SESSION['staff_id']; // Fetching user ID from the session

        // Prepare the insert query for message_conversation
        $insert_query = "INSERT INTO message_conversation (message_title_id, user_id, reply, date_reply) VALUES (?, ?, ?, NOW())";
        $insert_stmt = $connection->prepare($insert_query);
        
        if ($insert_stmt) {
            $insert_stmt->bind_param("sss", $message_id, $user_id, $reply_message);
            $insert_stmt->execute();

            if ($insert_stmt->affected_rows > 0) {
                // Update the status of the message in message_request_tbl to "Read"
                $update_query = "UPDATE message_request_tbl SET status = 'Read' WHERE message_id = ?";
                $update_stmt = $connection->prepare($update_query);
                
                if ($update_stmt) {
                    $update_stmt->bind_param("s", $message_id);
                    $update_stmt->execute();
                    $update_stmt->close();
                }

                // Redirect back to the message page with a success message
                $_SESSION['success_message'] = "Reply sent successfully and message marked as read!";
                header("Location: ../message_request_table.php");
                exit();
            } else {
                $_SESSION['error_message'] = "Failed to send reply.";
            }

            // Close the insert statement
            $insert_stmt->close();
        } else {
            $_SESSION['error_message'] = "Error preparing the insert statement.";
        }
    } else {
        $_SESSION['error_message'] = "Required data not found.";
    }
}

// Redirect back to the message page if something goes wrong
header("Location: ../message_request_table.php");
exit();
?>
