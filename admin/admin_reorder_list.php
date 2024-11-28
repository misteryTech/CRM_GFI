<?php
include("admin_header.php");

include("../include/connection.php");

// Fetch reorder medicine information with corresponding medicine details from the database

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
                            <h6 class="m-0 font-weight-bold text-primary">Medicine Information Logs</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="medicineTables" width="100%" cellspacing="0">
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
                                            <th>Medicine ID</th>
                                            <th>Medicine Name</th>
                                            <th>Remaining Stocks</th>
                                            <th>Additional Stocks</th>
                                            <th>Total Request</th>
                                            <th>Reording Point</th>
                                            <th>Reorder Date</th>
                                     
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                    <?php

                                        $query = "
                                        SELECT rm.*, m.medicine_name , m.reorder_point
                                        FROM reorder_medicine rm
                                        INNER JOIN medicines m ON rm.medicine_id = m.id

                                        WHERE rm.reorder_status = 'Pending'
                                        ";
                                        $result = mysqli_query($connection, $query);


                                    // Loop through each row of the result set
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>";
                                        echo "<td>" . $row['medicine_id'] . "</td>";
                                        echo "<td>" . $row['medicine_name'] . "</td>";
                                        echo "<td>" . $row['current_stock'] . "</td>";
                                        echo "<td>" . $row['reorder_quantity'] . "</td>";
                                        echo "<td>" . $row['total_request'] . "</td>";
                                        echo "<td>" . $row['reorder_point'] . "</td>";
                                        echo "<td>" . $row['reorder_date'] . "</td>";
                                    
                                        echo "<td>";
                                        echo "<button class='btn btn-primary' data-toggle='modal' data-target='#viewModal" . $row['medicine_id'] . "'>View</button> ";
                                        echo "<button class='btn btn-danger' data-toggle='modal' data-target='#deleteModal" . $row['medicine_id'] . "'>Archive</button>";
                                        echo "</td>";
                                        echo "</tr>";

                                        // View Modal
                                        echo "<div class='modal fade' id='viewModal" . $row['medicine_id'] . "' tabindex='-1' role='dialog' aria-labelledby='viewModalLabel" . $row['medicine_id'] . "' aria-hidden='true'>";
                                        echo "<div class='modal-dialog modal-lg' role='document'>";
                                        echo "<div class='modal-content'>";
                                        echo "<div class='modal-header'>";
                                        echo "<h5 class='modal-title' id='viewModalLabel" . $row['medicine_id'] . "'>Medicine List Request Details</h5>";
                                        echo "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
                                        echo "<span aria-hidden='true'>&times;</span>";
                                        echo "</button>";
                                        echo "</div>";
                                        echo "<div class='modal-body'>";
                                        echo "<div class='row'>";
                                        echo "<div class='col-md-6'>";
                                        echo "<p><strong>Medicine ID:</strong> " . $row['medicine_id'] . "</p>";
                                        echo "<p><strong>Medicine Name:</strong> " . $row['medicine_name'] . "</p>";
                                        echo "<p><strong>Current Stock:</strong> " . $row['current_stock'] . "</p>";
                                        echo "</div>";
                                        echo "<div class='col-md-6'>";

                                        echo "<p><strong>Reorder Quantity:</strong> " . $row['reorder_quantity'] . "</p>";
                                        echo "<p><strong>Reorder Date:</strong> " . $row['reorder_date'] . "</p>";
                                        echo "<p><strong>Reorder Status:</strong> " . $row['reorder_status'] . "</p>";
                                        echo "</div>";
                                        echo "</div>";
                                        echo "</div>";
                                        echo "<div class='modal-footer'>";
                                        echo "<button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>";
                                        echo "</div>";
                                        echo "</div>";
                                        echo "</div>";
                                        echo "</div>";


                        // Accept Modal
echo "<div class='modal fade' id='acceptModal" . $row['medicine_id'] . "' tabindex='-1' role='dialog' aria-labelledby='acceptModalLabel" . $row['medicine_id'] . "' aria-hidden='true'>";
echo "<div class='modal-dialog modal-lg' role='document'>";
echo "<div class='modal-content'>";
echo "<div class='modal-header'>";
echo "<h5 class='modal-title' id='acceptModalLabel" . $row['medicine_id'] . "'>Medicine Request Form</h5>";
echo "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
echo "<span aria-hidden='true'>&times;</span>";
echo "</button>";
echo "</div>";
echo "<div class='modal-body'>";
echo "<form action='process_code/order_list_accept.php' method='POST'>";
echo "<div class='form-row'>";

echo "<input type='hidden' name='reorder_id' value='" . $row['reorder_id'] . "' >";

echo "<div class='form-group col-md-6'>";

echo "<label for='medicineID" . $row['medicine_id'] . "'>Medicine ID:</label>";
echo "<input type='text' name='medicine_id' class='form-control' id='medicineID" . $row['medicine_id'] . "' value='" . $row['medicine_id'] . "' readonly>";
echo "</div>";
echo "<div class='form-group col-md-6'>";
echo "<label for='medicineName" . $row['medicine_id'] . "'>Medicine Name:</label>";
echo "<input type='text' name='medicine_name' class='form-control' id='medicineName" . $row['medicine_id'] . "' value='" . $row['medicine_name'] . "' readonly>";
echo "</div>";
echo "</div>";
echo "<div class='form-row'>";
echo "<div class='form-group col-md-6'>";
echo "<label for='currentStock" . $row['medicine_id'] . "'>Current Stock:</label>";
echo "<input type='number' name='medicine_stock' class='form-control' id='currentStock" . $row['medicine_id'] . "' value='" . $row['current_stock'] . "' readonly>";
echo "</div>";
echo "<div class='form-group col-md-6'>";
echo "<label for='reorderQuantity" . $row['medicine_id'] . "'>Reorder Quantity:</label>";
echo "<input type='number' name='medicine_reorder_quantity' class='form-control' id='reorderQuantity" . $row['medicine_id'] . "' value='" . $row['reorder_quantity'] . "' readonly>";
echo "</div>";
echo "</div>";

echo "<div class='form-group'>";
echo "<label for='additionalNotes" . $row['medicine_id'] . "'>Additional Notes:</label>";
echo "<textarea class='form-control' name='medicine_additional_notes' id='additionalNotes" . $row['medicine_id'] . "' name='notes' rows='3'></textarea>";
echo "</div>";
echo "<input type='hidden' name='medicine_id' value='" . $row['medicine_id'] . "'>";
echo "<button type='submit' class='btn btn-primary'>Submit Request</button>";
echo "</form>";
echo "</div>";
echo "<div class='modal-footer'>";
echo "<button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>";
echo "</div>";
echo "</div>";
echo "</div>";
echo "</div>";


                                        // Delete Modal
                                        echo "<div class='modal fade' id='deleteModal" . $row['medicine_id'] . "' tabindex='-1' role='dialog' aria-labelledby='deleteModalLabel" . $row['medicine_id'] . "' aria-hidden='true'>";
                                        echo "<div class='modal-dialog modal-lg' role='document'>";
                                        echo "<div class='modal-content'>";
                                        echo "<div class='modal-header'>";
                                        echo "<h5 class='modal-title' id='deleteModalLabel" . $row['medicine_id'] . "'>Delete Reorder</h5>";
                                        echo "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
                                        echo "<span aria-hidden='true'>&times;</span>";
                                        echo "</button>";
                                        echo "</div>";
                                        echo "<div class='modal-body'>";
                                        echo "<p>Are you sure you want to delete this reorder " . $row['reorder_id'] . " ?</p>";
                                        echo "</div>";
                                        echo "<div class='modal-footer'>";
                                        echo "<form action='process_code/reorder_medicine_delete.php' method='POST'>";
                                        echo "<input type='hidden' name='reorder_id' value='" . $row['reorder_id'] . "'>";
                                        echo "<button type='submit' class='btn btn-danger'>Delete</button>";
                                        echo "<button type='button' class='btn btn-secondary' data-dismiss='modal'>Cancel</button>";
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
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <?php
            include("admin_footer.php");
            ?>

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <?php
    include("admin_footer.php");
    ?>
    <script>
     $(document).ready(function() {
        $('#medicineTables').DataTable({
    dom: 'Bfrtip', // Adds the Buttons container
    buttons: [
        {
            extend: 'print',
            text: 'Print Table', // Customize the print button text
            exportOptions: {
                columns: function (index, data, node) {
                    // Exclude the 8th column (index 7)
                    return index !== 7; // Exclude the 8th column
                }
            },
            customize: function (win) {
                // Get the current date
                const currentDate = new Date().toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });

                // Add a header to the print view
                $(win.document.body)
                    .prepend('<h3 style="text-align:center;">Medicine Stock Report</h3>')
                    .prepend('<h5 style="text-align:center;">Printed on: ' + currentDate + '</h5>');
            }
        }
    ]
});

        });

    </script>