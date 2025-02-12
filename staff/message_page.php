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


?>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php include("staff_sidebar.php"); ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php include("staff_topbar.php"); ?>

                <div class="container mt-5 mb-5">
                    <?php if (isset($_SESSION['success'])): ?>
                        <div class="alert alert-success">
                            <?php
                            echo $_SESSION['success'];
                            unset($_SESSION['success']);
                            ?>
                        </div>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger">
                            <?php
                            echo $_SESSION['error'];
                            unset($_SESSION['error']);
                            ?>
                        </div>
                    <?php endif; ?>

                    <h2>Send Message to School Nurse</h2>
                    <form action="process_code/message_request.php" method="POST" enctype="multipart/form-data">
                        <!-- staff Information -->
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-md-4">
                                    <input type="text" class="form-control" id="staffId" name="staffId" value="<?php echo $staff['staff_id']; ?>" hidden readonly>
                                </div>
                            </div>
                            <br>
                            <div class="form-row">
                                <div class="col-md-12">
                                    <label for="Complain">Message Nurse</label>
                                    <textarea class="form-control" name="message" required></textarea>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success">Send Message</button>
                    </form>

                    <hr>

                    <h2>Your Message Requests</h2>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Message ID</th>
                                <th>Message</th>
                                <th>Date Sent</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        
                            <?php
                            // Fetch staff details from the database
$staffQuery = "SELECT * FROM staff_table WHERE staff_id = '$staff_id'";
$staffResult = mysqli_query($connection, $staffQuery);
$staff = mysqli_fetch_assoc($staffResult);

// Fetch message requests sent by the staff
$messageQuery = "SELECT * FROM message_request_tbl WHERE student_id = '$staff_id'";
$messageResult = mysqli_query($connection, $messageQuery);

                            while ($message = mysqli_fetch_assoc($messageResult)): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($message['message_id']); ?></td>
                                    <td><?php echo nl2br(htmlspecialchars($message['message'])); ?></td>
                                    <td><?php echo htmlspecialchars($message['date_send']); ?></td>
                                    <td><?php echo htmlspecialchars($message['status']); ?></td>
                                    <td>
                                        <a href="view_conversation.php?message_id=<?php echo urlencode($message['message_id']); ?>" class="btn btn-info">View Conversation</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>

                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <?php include("staff_footer.php"); ?>
</body>
</html>
