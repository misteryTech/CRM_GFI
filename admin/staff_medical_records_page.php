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
        if (isset($_GET['staff_id'])) {
            $staff_id = $_GET['staff_id'];

            // Prepare the SQL statement
            $stmt = $connection->prepare("SELECT * FROM staff_table WHERE staff_id = ?");

            if ($stmt) {
                // Bind the staff_id parameter
                $stmt->bind_param('i', $staff_id);

                // Execute the query
                $stmt->execute();

                // Get the result
                $result = $stmt->get_result();

                // Fetch the row
                $staff_data = $result->fetch_assoc();

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

                    <h2 class="text-center" style="font-family: 'Arial', sans-serif;">Staff Medical Record</h2>

                    <!-- staff Information -->
                    <div class="form-group">
                        <div class="form-row studentinfo">
                            <div class="col-md-4">
                                <label for="staffId">Staff ID</label>
                                <h1><?php echo htmlspecialchars($staff_data['staff_id'] ?? 'N/A'); ?></h1>
                            </div>

                            <div class="col-md-4">
                                <label for="staffName">Staff Name</label>
                                <h4><?php echo htmlspecialchars($staff_data['first_name'] . ' ' . $staff_data['last_name']); ?></h4>
                            </div>

                            <div class="col-md-4">
                                <label for="course">Position / Department</label>
                                <h4><?php echo htmlspecialchars($staff_data['position'] . ' ' . $staff_data['department']); ?></h4>
                            </div>
                        </div>

                        <div class="form-row">
                            <a class="btn btn-danger" style="margin-right: 10px;" href="staff_medical_records.php">Back to Staff Medical Records</a>
                            <a class="btn btn-primary" style="margin-right: 10px;" href="view_medical_records.php?user_id=<?php echo htmlspecialchars($staff_data['staff_id']); ?>">View Medical History</a>

                            <button class="btn btn-warning" id="printData">Print Clinic History</button>
                        </div>
                    </div>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Staff Medical Data</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered text-center" id="medicalRecordTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Record Id</th>
                                      
                                            <th>Chief Complaint</th>
                                            <th>Symstoms</th>
                                            <th>Date Diagnosed</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    // Fetching and displaying medical records
                                    $stmt = $connection->prepare("SELECT * FROM staff_clinic_record_table WHERE staff_id = ?");
                                    if ($stmt) {
                                        $stmt->bind_param('i', $staff_id);
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        while ($record = $result->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td>" . htmlspecialchars($record['record_id']) . "</td>";
                                            echo "<td>" . htmlspecialchars($record['illness']) . "</td>";
                                            echo "<td>" . htmlspecialchars($record['symptoms']) . "</td>";
                                            echo "<td>" . htmlspecialchars($record['date_diagnosed']) . "</td>";
                                     
                                            echo "<td><a href='staff_release_medicine_page.php?record_id=" . htmlspecialchars($record['record_id']) . "' class='btn btn-success'>Release Medicine</a></td>";
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
    <!-- End of Page Wrapper -->

    <?php include('admin_footer.php'); ?>

    <script>
        document.getElementById('printData').addEventListener('click', function () {
            // Create a new window
            const printWindow = window.open('', '', 'height=600,width=800');
            printWindow.document.write('<html><head><title>Print staff Data</title>');
            printWindow.document.write('<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">'); // Include Bootstrap CSS
            printWindow.document.write('</head><body>');
            printWindow.document.write('<h2 class="text-center">staff Medical Record</h2>');
            printWindow.document.write('<h3>staff ID: <?php echo htmlspecialchars($staff_data['staff_id'] ?? 'N/A'); ?></h3>');
            printWindow.document.write('<h3>staff Name: <?php echo htmlspecialchars($staff_data['first_name'] . " " . $staff_data['last_name']); ?></h3>');
            printWindow.document.write('<h3>Course: <?php echo htmlspecialchars($staff_data['course'] . " " . $staff_data['year']); ?></h3>');
            printWindow.document.write('<h3>Clinic Records:</h3>');
            
            // Fetch medical records again for printing
            printWindow.document.write('<table class="table table-bordered text-center" border="1" cellpadding="5" style="border-collapse:collapse;">');
            printWindow.document.write('<tr><th>Record Id</th><th>Date Diagnosed</th><th>Chief Complaint</th><th>Symtoms</th></tr>');
            
            <?php
            // Fetching and displaying medical records for printing
            $stmt = $connection->prepare("SELECT * FROM staff_clinic_record_table WHERE staff_id = ?");
            if ($stmt) {
                $stmt->bind_param('i', $staff_id);
                $stmt->execute();
                $result = $stmt->get_result();
                while ($record = $result->fetch_assoc()) {
                    echo "printWindow.document.write('<tr><td>" . htmlspecialchars($record['record_id']) . "</td><td>" . htmlspecialchars($record['date_diagnosed']) . "</td><td>" . htmlspecialchars($record['illness']) . "</td><td>" . htmlspecialchars($record['symptoms']) . "</td></tr>');";
                }
                $stmt->close();
            }
            ?>
            
            printWindow.document.write('</table>');
            printWindow.document.write('</body></html>');
            printWindow.document.close(); // Necessary for IE >= 10
            printWindow.focus(); // Necessary for IE >= 10
            printWindow.print();
        });
    </script>

    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fc;
        }
        h2, h3 {
            font-weight: bold;
            color: #4e73df;
            text-align: center;
        }
        .table th, .table td {
            text-align: center;
        }
        .btn {
            font-weight: bold;
        }
    </style>
</body>
