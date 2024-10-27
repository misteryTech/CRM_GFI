<?php
include("admin_header.php");
session_start();
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
                    <?php endif; ?>s

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
                                    $query = "SELECT * FROM message_request_tbl WHERE status = 'Request'";
                                    $result = mysqli_query($connection, $query);

                                    if (mysqli_num_rows($result) > 0) {
                                        echo "<table class='table table-bordered' id='Unread'>";
                                        echo "<thead>";
                                        echo "<tr>";
                                        echo "<th>Student</th>";
                                        echo "<th>Message</th>"; // Fixed typo from "MEssage"
                                        echo "<th>Date Submitted</th>";
                                        echo "<th>Action</th>";
                                        echo "</tr>";
                                        echo "</thead>";
                                        echo "<tbody>";

                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo "<tr>";
                                            echo "<td>" . htmlspecialchars($row['student_id']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['message']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['date_send']) . "</td>";
                                            echo "<td><a class='btn btn-primary' href='reply_page.php?message_id=" . urlencode($row['message_id']) . "'>Reply Message</a></td>";
                                            echo "</tr>";
                                        }

                                        echo "</tbody>";
                                        echo "</table>";
                                    } else {
                                        echo "<p>No messages in stock.</p>"; // Changed to be more descriptive
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
                                    $query = "SELECT * FROM message_request_tbl WHERE status = 'Read'";
                                    $result = mysqli_query($connection, $query);

                                    if (mysqli_num_rows($result) > 0) {
                                        echo "<table class='table table-bordered' id='stocktable'>";
                                        echo "<thead>";
                                        echo "<tr>";
                                        echo "<th>Student</th>";
                                        echo "<th>Message</th>"; // Fixed typo from "MEssage"
                                        echo "<th>Date Submitted</th>";
                                        echo "<th>Action</th>";
                                        echo "</tr>";
                                        echo "</thead>";
                                        echo "<tbody>";

                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo "<tr>";
                                            echo "<td>" . htmlspecialchars($row['student_id']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['message']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['date_send']) . "</td>";
                                            echo "<td><a class='btn btn-primary' href='reply_page.php?message_id=" . urlencode($row['message_id']) . "'>Reply Message</a></td>";
                                            echo "</tr>";
                                        }

                                        echo "</tbody>";
                                        echo "</table>";
                                    } else {
                                        echo "<p>No messages in stock.</p>"; // Changed to be more descriptive
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

    <?php include("admin_footer.php"); ?>
</body>
