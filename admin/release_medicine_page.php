<?php
include("admin_header.php");
session_start();
include("../include/connection.php");


?>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <?php include("admin_sidebar.php"); ?>
        <?php

if (isset($_GET['record_id'])) {
    $record_id = $_GET['record_id'];

    // Prepare the SQL statement
    $stmt = $connection->prepare("SELECT * FROM prescribed_medicine_table WHERE record_id = ?");

    if ($stmt) {
        // Bind the student_id parameter
        $stmt->bind_param('i', $student_id);

        // Execute the query
        $stmt->execute();

        // Get the result
        $result = $stmt->get_result();

        // Fetch the row
        $student_data = $result->fetch_assoc();

        // Close the statement
        $stmt->close();
    } else {
        // Handle SQL error
        $_SESSION['error'] = "Failed to prepare the SQL statement.";
    }
}

        ?>
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <?php include("admin_topbar.php"); ?>

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

                    <h2>Student Release Record</h2>

                    <!-- Student Information -->


                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Student Release Data</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="medicalReleaseRecordTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Record Id</th>
                                            <th>Medicine Name</th>
                                            <th>Quantity</th>
                                            <th>Date</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                            // Prepare the SQL query to fetch and display medical records
                                            $stmt = $connection->prepare("
                                                SELECT smt.*, m.medicine_name , scrt.date_diagnosed



                                                FROM prescribed_medicine_table AS smt
                                                INNER JOIN medicines AS m ON m.id = smt.medicine_id
                                                INNER JOIN student_clinic_record_table AS scrt ON scrt.record_id = smt.record_id
                                                WHERE smt.record_id = ? AND smt.role = '1'
                                            ");

                                            if ($stmt) {
                                                $stmt->bind_param('i', $record_id);
                                                $stmt->execute();
                                                $result = $stmt->get_result();

                                                while ($record = $result->fetch_assoc()) {
                                                    echo "<tr>";
                                                    echo "<td>" . htmlspecialchars($record['record_id']) . "</td>";
                                                    echo "<td>" . htmlspecialchars($record['medicine_name']) . "</td>";
                                                    echo "<td>" . htmlspecialchars($record['quantity']) . "</td>";
                                                    echo "<td>" . htmlspecialchars($record['date_diagnosed']) . "</td>";

                                                    echo "</tr>";
                                                }

                                                $stmt->close();
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
        </div>
        <!-- End of Content Wrapper -->
    </div>


<?php
            include("admin_footer.php");
?>
