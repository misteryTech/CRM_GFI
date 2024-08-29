<?php
include("admin_header.php");
session_start();
include("../include/connection.php");

$reorder_table = "5";
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
                            <a class="nav-link active" id="pills-instock-tab" data-toggle="pill" href="#pills-instock" role="tab" aria-controls="pills-instock" aria-selected="true">In Stock</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="pills-reorder-tab" data-toggle="pill" href="#pills-reorder" role="tab" aria-controls="pills-reorder" aria-selected="false">Reorder</a>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content" id="pills-tabContent">

                        <!-- In Stock Tab -->
                        <div class="tab-pane fade show active" id="pills-instock" role="tabpanel" aria-labelledby="pills-instock-tab">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">In Stock</h6>
                                </div>
                                <div class="card-body">
                                    <?php
                                    $query = "SELECT * FROM medicines WHERE stock > $reorder_table";
                                    $result = mysqli_query($connection, $query);

                                    if (mysqli_num_rows($result) > 0) {
                                        echo "<table class='table table-bordered'>";
                                        echo "<thead>";
                                        echo "<tr>";
                                        echo "<th>medicine ID</th>";
                                        echo "<th>medicine Name</th>";
                                        echo "<th>Stock</th>";

                                        echo "</tr>";
                                        echo "</thead>";
                                        echo "<tbody>";

                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo "<tr>";
                                            echo "<td>" . $row['id'] . "</td>";
                                            echo "<td>" . $row['medicine_name'] . "</td>";
                                            echo "<td>" . $row['stock'] . "</td>";


                                            echo "</tr>";
                                        }

                                        echo "</tbody>";
                                        echo "</table>";
                                    } else {
                                        echo "<p>No medicines in stock.</p>";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>

                        <!-- Reorder Tab -->
                        <div class="tab-pane fade" id="pills-reorder" role="tabpanel" aria-labelledby="pills-reorder-tab">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Reorder</h6>
                                </div>
                                <div class="card-body">
                                    <?php
                                    $query = "SELECT * FROM medicines WHERE stock <= $reorder_table";
                                    $result = mysqli_query($connection, $query);

                                    if (mysqli_num_rows($result) > 0) {
                                        echo "<table class='table table-bordered'>";
                                        echo "<thead>";
                                        echo "<tr>";
                                        echo "<th>medicine ID</th>";
                                        echo "<th>medicine Name</th>";
                                        echo "<th>Stock</th>";
                                        echo "<th>Status</th>";
                                        echo "<th>Action</th>";
                                        echo "</tr>";
                                        echo "</thead>";
                                        echo "<tbody>";

                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo "<tr>";
                                            echo "<td>" . $row['id'] . "</td>";
                                            echo "<td>" . $row['medicine_name'] . "</td>";
                                            echo "<td>" . $row['stock'] . "</td>";
                                            echo "<td>" . $row['status'] . "</td>";
                                            echo "<td>";
                                            echo "<button class='btn btn-danger' data-toggle='modal' data-target='#viewModal" . $row['id'] . "'>Reorder</button> ";
                                            echo "</td>";
                                            echo "</tr>";
    // View Modal
    echo "<div class='modal fade' id='viewModal" . $row['id'] . "' tabindex='-1' role='dialog' aria-labelledby='viewModalLabel" . $row['id'] . "' aria-hidden='true'>";
    echo "<div class='modal-dialog modal-lg' role='document'>"; // Changed to modal-lg for larger width
    echo "<div class='modal-content'>";
    echo "<div class='modal-header'>";
    echo "<h5 class='modal-title' id='viewModalLabel" . $row['id'] . "'>staff Details</h5>";
    echo "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
    echo "<span aria-hidden='true'>&times;</span>";
    echo "</button>";
    echo "</div>";
    echo "<div class='modal-body'>";
    echo "<form action='process_code/reorder_medicine_process.php' method='POST'>";
    echo "<input type='hidden' name='medicine_id' value='" . $row['id'] . "'>";
    echo "<div class='row'>";

    // Medicine Name
    echo "<div class='col-md-6'>";
    echo "<div class='form-group'>";
    echo "<label for='medicine_name" . $row['id'] . "'>Medicine Name</label>";
    echo "<input type='text' class='form-control' id='medicine_name" . $row['id'] . "' name='edit_medicine_name' value='" . $row['medicine_name'] . "' required>";
    echo "</div>";

    echo "<div class='form-group'>";
    echo "<label for='stock" . $row['id'] . "'>Stock</label>";
    echo "<input type='number' class='form-control' id='stock" . $row['id'] . "' name='current_stock' value='" . $row['stock'] . "' required>";
    echo "</div>";


    echo "</div>";

    // Stock
    echo "<div class='col-md-6'>";
    echo "<div class='form-group'>";
    echo "<label for='manufacturer" . $row['id'] . "'>Manufacturer</label>";
    echo "<input type='text' class='form-control' id='manufacturer" . $row['id'] . "' name='manufacturer' value='" . $row['manufacturer'] . "' required>";
    echo "</div>";


    echo "<div class='form-group'>";
    echo "<label for='reorder" . $row['id'] . "'>Reorder Quantity</label>";
    echo "<input type='number' class='form-control' id='reorder" . $row['id'] . "' name='reorder_quantity' value='' required>";
    echo "</div>";

    echo "</div>"; // End of the right column

    echo "</div>"; // End of row

    echo "<button type='submit' class='btn btn-primary'>Send Request</button>";
    echo "</form>";



    echo "</div>";
    echo "<div class='modal-footer'>";
    echo "<button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
    echo "</div>";



                                        }

                                        echo "</tbody>";
                                        echo "</table>";
                                    } else {
                                        echo "<p>No medicines need reordering.</p>";
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
</body>
