<?php
include("admin_header.php");
session_start();
include("../include/connection.php");

// Check if message_id is set in the URL
if (isset($_GET['message_id'])) {
    $message_id = $_GET['message_id'];

    // Fetch the student's message
    $query = "SELECT * FROM message_request_tbl WHERE message_id = ?";
    $stmt = $connection->prepare($query);
    
    if ($stmt) {
        $stmt->bind_param("s", $message_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $message = $result->fetch_assoc();

        // If the message exists
        if ($message) {
            // Fetch student_id from the message
            $student_id = $message['student_id']; // Assuming student_id is a column in message_request_tbl

            // Display the message details
            ?>
            <div class="container">
                <h2>Reply to Message</h2>
                <div class="card">
                    <div class="card-header">
                        <h5>Message from Student ID: <?php echo htmlspecialchars($student_id); ?></h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Message:</strong></p>
                        <p><?php echo nl2br(htmlspecialchars($message['message'])); ?></p>
                        <p><strong>Date Submitted:</strong> <?php echo htmlspecialchars($message['date_send']); ?></p>
                        <hr>
                        <form action="process_code/reply_message_process.php" method="POST">
                            <input type="hidden" name="message_id" value="<?php echo htmlspecialchars($message['message_id']); ?>">
                            <div class="form-group">
                                <label for="replyMessage">Your Reply:</label>
                                <textarea class="form-control" id="replyMessage" name="reply_message" rows="4" required></textarea>
                            </div>
                            <input type="hidden" name="student_id" value="<?php echo htmlspecialchars($student_id); ?>">
                            <button type="submit" class="btn btn-primary">Send Reply</button>
                            <a href="message_request_table.php" class="btn btn-secondary">Back to Messages</a>
                        </form>
                    </div>
                </div>
            </div>
            <?php
            
        } else {
            echo "<div class='container'><p>No message found for this message ID.</p></div>";
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "<div class='container'><p>Error preparing the statement.</p></div>";
    }

    // Close the database connection
    $connection->close();
} else {
    echo "<div class='container'><p>No message ID provided.</p></div>";
}

include("admin_footer.php");
?>
