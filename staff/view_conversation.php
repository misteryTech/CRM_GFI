<?php
include("staff_header.php");
include("../include/connection.php");


// Check if the staff is logged in
if (!isset($_SESSION['staff_id'])) {


    $_SESSION['error'] = "You must be logged in to view this page.";
    header("Location: ../login_staff.php");
    exit();
    
}


$staff_id = $_SESSION['staff_id'];
$username = $_SESSION['username'];




// Fetch staff details from the database
$staffQuery = "SELECT * FROM staff_table WHERE staff_id = '$staff_id'";
$staffResult = mysqli_query($connection, $staffQuery);

// Check if data was fetched successfully
if (mysqli_num_rows($staffResult) == 1) {
    $staff = mysqli_fetch_assoc($staffResult);

    // Check for missing details
    $requiredFields = ['username', 'password', 'first_name', 'last_name', 'dob', 'gender', 'email'];
    $missingDetails = false;

    foreach ($requiredFields as $field) {
        if (empty($staff[$field])) {
            $missingDetails = true;
            break;
        }
    }

    // Set a session error if details are missing
    if ($missingDetails) {
        $_SESSION['error'] = "Please complete your account details.";
        header("Location: account_details_page.php");
    }
} else {
    // staff not found in the database
    $_SESSION['error'] = "staff record not found.";
    header("Location: ../login_staff.php");
    exit();
}



// Get staff ID from session
$staff_id = mysqli_real_escape_string($connection, $_SESSION['staff_id']);

// Fetch staff details from the database
$staffQuery = "SELECT * FROM staff_table WHERE staff_id = '$staff_id'";
$staffResult = mysqli_query($connection, $staffQuery);
$staff = mysqli_fetch_assoc($staffResult);




// Get message_id from the URL
$message_id = isset($_GET['message_id']) ? mysqli_real_escape_string($connection, $_GET['message_id']) : null;

// Fetch conversation details
if ($message_id) {
    $conversationQuery = "SELECT * FROM message_conversation WHERE message_title_id = '$message_id'";
    $conversationResult = mysqli_query($connection, $conversationQuery);
}

// Handle reply submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reply'])) {
    $reply = mysqli_real_escape_string($connection, $_POST['reply']);
    $user_id = $_SESSION['staff_id']; // Assuming staff_id is the user ID
    $insertQuery = "INSERT INTO message_conversation (message_title_id, user_id, reply, date_reply) VALUES ('$message_id', '$user_id', '$reply', NOW())";
    mysqli_query($connection, $insertQuery);
    header("Location: conversation_details.php?message_id=$message_id"); // Redirect to refresh the conversation
    exit();
}
?>

<body id="page-top">

    <div id="wrapper">
        <?php include("staff_sidebar.php"); ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include("staff_topbar.php"); ?>

                <div class="container mt-5 mb-5">
                    <h2>Conversation Details</h2>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Reply</th>
                                <th>Date Reply</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($conversationResult && mysqli_num_rows($conversationResult) > 0): ?>
                                <?php while ($conversation = mysqli_fetch_assoc($conversationResult)): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($conversation['user_id']); ?></td>
                                        <td><?php echo nl2br(htmlspecialchars($conversation['reply'])); ?></td>
                                        <td><?php echo htmlspecialchars($conversation['date_reply']); ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3">No conversation found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>

                    <!-- Reply Button -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#replyModal">Reply</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Reply Modal -->
    <div class="modal fade" id="replyModal" tabindex="-1" role="dialog" aria-labelledby="replyModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="replyModalLabel">Reply to Conversation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="reply">Your Reply</label>
                            <textarea class="form-control" id="reply" name="reply" rows="4" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Send Reply</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include("staff_footer.php"); ?>
</body>
</html>