<?php
include("admin_header.php");
session_start();
include("../include/connection.php");

// Fetch all organization information from the database
$query = "SELECT * FROM organizations";
$result = mysqli_query($connection, $query);
?>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php
        include("admin_sidebar.php");
        ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php
                include("admin_topbar.php");
                ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Organization Information Data</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="organizationTable" width="100%" cellspacing="0">
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

                                    <thead>
                                        <tr>
                                            <th>Organization Id</th>
                                            <th>Organization Name</th>
                                            <th>Department</th>
                                            <th>Advisor Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        // Loop through each row of the result set
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo "<tr>";
                                            echo "<td>" . $row['id'] . "</td>";
                                            echo "<td>" . $row['organization_name'] . "</td>";
                                            echo "<td>" . $row['department'] . "</td>";
                                            echo "<td>" . $row['advisor_name'] . "</td>";
                                            echo "<td>";
                                            echo "<a href='organization_view.php?id=" . $row['id'] . "' class='btn btn-success'>View</a> ";
                                            echo "<button class='btn btn-primary' data-toggle='modal' data-target='#editModal" . $row['id'] . "'>Edit</button> ";
                                            echo "<button class='btn btn-danger' data-toggle='modal' data-target='#deleteModal" . $row['id'] . "'>Delete</button>";
                                            echo "</td>";
                                            echo "</tr>";

                                            // Edit Modal
                                            echo "<div class='modal fade' id='editModal" . $row['id'] . "' tabindex='-1' role='dialog' aria-labelledby='editModalLabel' aria-hidden='true'>";
                                            echo "<div class='modal-dialog' role='document'>";
                                            echo "<div class='modal-content'>";
                                            echo "<div class='modal-header'>";
                                            echo "<h5 class='modal-title' id='editModalLabel'>Edit Organization</h5>";
                                            echo "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
                                            echo "<span aria-hidden='true'>&times;</span>";
                                            echo "</button>";
                                            echo "</div>";
                                            echo "<div class='modal-body'>";
                                            // Edit form with fields pre-filled with existing data
                                            echo "<form action='process_code/organization_edit_information.php' method='POST'>";
                                            echo "<input type='hidden' name='organization_id' value='" . $row['id'] . "'>";
                                            echo "<div class='form-group'>";
                                            echo "<label for='editOrganizationName'>Organization Name</label>";
                                            echo "<input type='text' class='form-control' id='editOrganizationName' name='edit_organization_name' value='" . $row['organization_name'] . "' required>";
                                            echo "</div>";
                                            echo "<div class='form-group'>";
                                            echo "<label for='editDepartment'>Department</label>";
                                            echo "<input type='text' class='form-control' id='editDepartment' name='edit_department' value='" . $row['department'] . "' required>";
                                            echo "</div>";
                                            echo "<div class='form-group'>";
                                            echo "<label for='editAdvisorName'>Advisor Name</label>";
                                            echo "<input type='text' class='form-control' id='editAdvisorName' name='edit_advisor_name' value='" . $row['advisor_name'] . "' required>";
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
                                            echo "<h5 class='modal-title' id='deleteModalLabel'>Delete Organization</h5>";
                                            echo "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
                                            echo "<span aria-hidden='true'>&times;</span>";
                                            echo "</button>";
                                            echo "</div>";
                                            echo "<div class='modal-body'>";
                                            echo "<p>Are you sure you want to delete this organization?</p>";
                                            echo "</div>";
                                            echo "<div class='modal-footer'>";
                                            echo "<button type='button' class='btn btn-secondary' data-dismiss='modal'>Cancel</button>";
                                            // Delete button - this will submit a form to handle the deletion query
                                            echo "<form action='process_code/organization_delete_information.php' method='POST'>";
                                            echo "<input type='hidden' name='organization_id' value='" . $row['id'] . "'>"; // Hidden field to pass organization ID
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
                        </div>
                    </div>

                </div>
                <!-- End of Main Content -->
            </div>
            <!-- End of Content Wrapper -->

        </div>

    </div>
    <!-- End of Page Wrapper -->

    <?php
    include("admin_footer.php");
    ?>
</body>
</html>
