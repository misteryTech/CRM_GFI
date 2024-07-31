<?php
include("admin_header.php");
session_start();
include("../include/connection.php");

// Fetch event data from the database
$sql = "SELECT id, title, description, date, image_path FROM events";
$result = $connection->query($sql);
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
                    <h2 class="mb-4">Events Management</h2>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Date</th>
                                <th>Image</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $row['title'] . "</td>";
                                echo "<td>" . $row['description'] . "</td>";
                                echo "<td>" . $row['date'] . "</td>";
                                echo "<td><img src='" . $row['image_path'] . "' alt='" . $row['title'] . "' width='100'></td>";
                                echo "<td>";
                                echo "<button type='button' class='btn btn-primary' data-toggle='modal' data-target='#editModal" . $row['id'] . "'>Edit</button>&nbsp;";
                                echo "<button type='button' class='btn btn-danger' data-toggle='modal' data-target='#deleteModal" . $row['id'] . "'>Delete</button>";
                                echo "</td>";
                                echo "</tr>";

                                // Edit Modal
                                echo "<div class='modal fade' id='editModal" . $row['id'] . "' tabindex='-1' role='dialog' aria-labelledby='editModalLabel' aria-hidden='true'>";
                                echo "<div class='modal-dialog' role='document'>";
                                echo "<div class='modal-content'>";
                                echo "<div class='modal-header'>";
                                echo "<h5 class='modal-title' id='editModalLabel'>Edit Event</h5>";
                                echo "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
                                echo "<span aria-hidden='true'>&times;</span>";
                                echo "</button>";
                                echo "</div>";
                                echo "<div class='modal-body'>";
                                echo "<form action='event_edit_information.php' method='POST' enctype='multipart/form-data'>";
                                echo "<input type='hidden' name='event_id' value='" . $row['id'] . "'>";
                                echo "<div class='form-group'>";
                                echo "<label for='editTitle'>Title</label>";
                                echo "<input type='text' class='form-control' id='editTitle' name='edit_title' value='" . $row['title'] . "' required>";
                                echo "</div>";
                                echo "<div class='form-group'>";
                                echo "<label for='editDescription'>Description</label>";
                                echo "<textarea class='form-control' id='editDescription' name='edit_description' required>" . $row['description'] . "</textarea>";
                                echo "</div>";
                                echo "<div class='form-group'>";
                                echo "<label for='editDate'>Date</label>";
                                echo "<input type='date' class='form-control' id='editDate' name='edit_date' value='" . $row['date'] . "' required>";
                                echo "</div>";
                                echo "<div class='form-group'>";
                                echo "<label for='editImage'>Image</label>";
                                echo "<input type='file' class='form-control' id='editImage' name='edit_image'>";
                                echo "</div>";
                                echo "<button type='submit' class='btn btn-primary'>Save Changes</button>";
                                echo "</form>";
                                echo "</div>";
                                echo "<div class='modal-footer'>";
                                echo "<button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>";
                                echo "</div>";
                                echo "</div>";
                                echo "</div>";
                                echo "</div>";

                                // Delete Modal
                                echo "<div class='modal fade' id='deleteModal" . $row['id'] . "' tabindex='-1' role='dialog' aria-labelledby='deleteModalLabel' aria-hidden='true'>";
                                echo "<div class='modal-dialog' role='document'>";
                                echo "<div class='modal-content'>";
                                echo "<div class='modal-header'>";
                                echo "<h5 class='modal-title' id='deleteModalLabel'>Delete Event</h5>";
                                echo "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
                                echo "<span aria-hidden='true'>&times;</span>";
                                echo "</button>";
                                echo "</div>";
                                echo "<div class='modal-body'>";
                                echo "<p>Are you sure you want to delete this event?</p>";
                                echo "</div>";
                                echo "<div class='modal-footer'>";
                                echo "<button type='button' class='btn btn-secondary' data-dismiss='modal'>Cancel</button>";
                                echo "<form action='process_code/event_delete_information.php' method='POST'>";
                                echo "<input type='hidden' name='event_id' value='" . $row['id'] . "'>";
                                echo "<button type='submit' class='btn btn-danger'>Delete</button>";
                                echo "</form>";
                                echo "</div>";
                                echo "</div>";
                                echo "</div>";
                                echo "</div>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->

            <?php include("admin_footer.php"); ?>
        </div>
    </div>
    <!-- End of Page Wrapper -->
