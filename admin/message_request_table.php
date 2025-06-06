<?php
include("admin_header.php");
include("../include/connection.php");

$reorder_threshold = 5; // Set reorder threshold

?>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php include("admin_sidebar.php"); ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php include("admin_topbar.php"); ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">
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

                    <!-- Tab Pills -->
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="pills-instock-tab" data-toggle="pill" href="#pills-instock" role="tab" aria-controls="pills-instock" aria-selected="true">Unread</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="pills-reorder-tab" data-toggle="pill" href="#pills-reorder" role="tab" aria-controls="pills-reorder" aria-selected="false">Read</a>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content" id="pills-tabContent">

                        <!-- In Stock Tab -->
                        <div class="tab-pane fade show active" id="pills-instock" role="tabpanel" aria-labelledby="pills-instock-tab">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Request Message</h6>
                                </div>
                                <div class="card-body">
                                    <?php
                                    $query = "SELECT s.first_name, m.message, m.date_send, m.message_id
                                              FROM message_request_tbl AS m
                                              INNER JOIN students_table AS s ON m.student_id = s.student_id
                                              WHERE m.status = 'Request'
                                                ORDER BY message_id DESC
                                              ";
                                    $result = mysqli_query($connection, $query);

                                    if (mysqli_num_rows($result) > 0) {
                                        echo "<table class='table table-bordered' id='Unread'>";
                                        echo "<thead>";
                                        echo "<tr>";
                                        echo "<th>Student</th>";
                                        echo "<th>Message</th>";
                                        echo "<th>Date Submitted</th>";
                                        echo "<th>Action</th>";
                                        echo "</tr>";
                                        echo "</thead>";
                                        echo "<tbody>";

                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo "<tr>";
                                            echo "<td>" . htmlspecialchars($row['first_name']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['message']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['date_send']) . "</td>";
                                            echo "<td><a class='btn btn-primary reply-btn' data-message-id='" . $row['message_id'] . "' href='reply_page.php?message_id=" . urlencode($row['message_id']) . "'>Reply Message</a></td>";

                                            echo "</tr>";
                                        }

                                        echo "</tbody>";
                                        echo "</table>";
                                    } else {
                                        echo "<p>No messages in stock.</p>";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>

                        <!-- Reorder Tab -->
                        <div class="tab-pane fade" id="pills-reorder" role="tabpanel" aria-labelledby="pills-reorder-tab">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Read</h6>
                                </div>
                                <div class="card-body">
                                    <?php
                                    $query = "SELECT s.first_name, m.message, m.date_send, m.message_id
                                              FROM message_request_tbl AS m
                                              INNER JOIN students_table AS s ON m.student_id = s.student_id
                                              WHERE m.status = 'Read'
                                              ORDER BY message_id DESC
                                              ";
                                    $result = mysqli_query($connection, $query);

                                    if (mysqli_num_rows($result) > 0) {
                                        echo "<table class='table table-bordered' id='messagetable'>";
                                        echo "<thead>";
                                        echo "<tr>";
                                        echo "<th>Student</th>";
                                        echo "<th>Message</th>";
                                        echo "<th>Date Submitted</th>";
                                        echo "<th>Action</th>";
                                        echo "</tr>";
                                        echo "</thead>";
                                        echo "<tbody>";

                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo "<tr>";
                                            echo "<td>" . htmlspecialchars($row['first_name']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['message']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['date_send']) . "</td>";
                                            echo "<td><a class='btn btn-primary' href='reply_page.php?message_id=" . urlencode($row['message_id']) . "'>Reply Message</a></td>";
                                            echo "</tr>";
                                        }

                                        echo "</tbody>";
                                        echo "</table>";
                                    } else {
                                        echo "<p>No messages in stock.</p>";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <?php
         include("admin_footer.php");
         ?>

<script>
$(document).ready(function() {


    $(document).ready(function() {
    // Initialize DataTables
    $('#Unread').DataTable();
    $('#messagetable').DataTable();

    // Handle Reply Button Click
    $(document).on('click', '.reply-btn', function(event) {
        event.preventDefault(); // Prevent immediate navigation
        var messageId = $(this).data('message-id'); // Get message ID
        var redirectUrl = $(this).attr('href'); // Get the reply page URL

        // Send AJAX request to update status
        $.ajax({
            url: 'process_code/update_message_status.php', // PHP script to handle status update
            type: 'POST',
            data: { message_id: messageId },
            success: function(response) {
                console.log(response); // Optional: log the response for debugging
                // Navigate to the reply page after updating status
                window.location.href = redirectUrl;
            },
            error: function(xhr, status, error) {
                console.error("Error updating status: ", error);
            }
        });
    });
});


    $('#Unread').DataTable();
    $('#messagetable').DataTable();
});
</script>
