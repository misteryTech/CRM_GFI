<?php
include("admin_header.php");
session_start();
include("../include/connection.php");


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
                            <h6 class="m-0 font-weight-bold text-primary">Clinic Information Data</h6>
                        </div>
                        <div class="card-body">

                            <!-- Date Filter -->
                            <div class="form-group row">
                                <div class="col-sm-4 mb-3 mb-sm-0">
                                    <label for="startDate">Start Date:</label>
                                    <input type="date" id="startDate" class="form-control">
                                </div>
                                <div class="col-sm-4">
                                    <label for="endDate">End Date:</label>
                                    <input type="date" id="endDate" class="form-control">
                                </div>
                                <div class="col-sm-4">
                                    <button id="filterDate" class="btn btn-primary mt-4">Filter & Print</button>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered" id="ClinicReportTable" width="100%" cellspacing="0">
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
                                            <th>Student Id</th>
                                            <th>Chief Complain</th>
                                            <th>Systoms</th>
                                            <th>Reccomendation</th>

                                            <th>Diagnosed Date</th>
                                            <th>Note</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                    <?php
                                    // Loop through each row of the result set
                                    // Fetch all student information from the database
$query = "SELECT * FROM student_clinic_record_table";
$result = mysqli_query($connection, $query);


                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>";
                                        echo "<td>" . $row['student_id'] . "</td>";
                                        echo "<td>" . $row['illness'] . "</td>";
                                        echo "<td>" . $row['symptoms']."</td>";
                                        echo "<td>" . $row['recommendation']."</td>";
                                        echo "<td>" . $row['date_diagnosed'] . "</td>";
                                        echo "<td>" . $row['note'] . "</td>";

                                        echo "</tr>";
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

    <script>
        $(document).ready(function() {
            var table = $('#ClinicReportTable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'print'
                ]
            });

            // Date filter and print
            $('#filterDate').on('click', function() {
                var startDate = $('#startDate').val();
                var endDate = $('#endDate').val();

                if (startDate && endDate) {
                    // Custom filtering for date range
                    $.fn.dataTable.ext.search.push(
                        function(settings, data, dataIndex) {
                            var regDate = new Date(data[3]); // Registration Date column index
                            var start = new Date(startDate);
                            var end = new Date(endDate);

                            return regDate >= start && regDate <= end;
                        }
                    );
                    table.draw();
                    $.fn.dataTable.ext.search.pop();
                }


            });
        });
    </script>
</body>
</html>
