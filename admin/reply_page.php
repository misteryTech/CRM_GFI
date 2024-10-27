<?php
include("admin_header.php");
session_start();
include("../include/connection.php");

// Check if student_id is set in the URL
if (isset($_GET['student_id'])) {
    $student_id = $_GET['student_id'];

    // Fetch the student's message
    $query = "SELECT * FROM message_request_tbl WHERE student_id = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("s", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $message = $result->fetch_assoc();

    // If the message exists
    if ($message) {
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
                    <p><strong>Date Submitted:</strong> <?php echo htmlspecialchars($message['date_send'] ); ?></p>
                    <hr>
                    <form action="process_code/reply_message_process.php" method="POST">

                                    <input type="text" value="<?php echo htmlspecialchars($student_id); ?>" >
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
        echo "<div class='container'><p>No message found for this student.</p></div>";
    }

    // Close the statement and connection
    $stmt->close();
    $connection->close();
} else {
    echo "<div class='container'><p>No student ID provided.</p></div>";
}

include("admin_footer.php");
?>
