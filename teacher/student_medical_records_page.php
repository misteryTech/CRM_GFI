<?php
include("teacher_header.php");
session_start();
include("../include/connection.php");


?>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <?php include("teacher_sidebar.php"); ?>
        <?php

if (isset($_GET['student_id'])) {
    $student_id = $_GET['student_id'];

    // Prepare the SQL statement
    $stmt = $connection->prepare("SELECT * FROM students_table WHERE student_id = ?");

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
                <?php include("teacher_topbar.php"); ?>

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

                    <h2>Student Medical Record</h2>

                    <!-- Student Information -->
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-4">
                                <label for="studentId">Student ID</label>
                                <h1><?php echo htmlspecialchars($student_data['student_id'] ?? 'N/A'); ?></h1>
                            </div>

                            <div class="col-md-4">
                                <label for="studentName">Student Name</label>
                                <h4><?php echo htmlspecialchars($student_data['first_name'] .' ' . $student_data['last_name']); ?></h4>
                            </div>

                            <div class="col-md-4">
                                <label for="course">Course</label>
                                <h4><?php echo htmlspecialchars($student_data['course'] .' ' . $student_data['year']); ?></h4>
                            </div>
                        </div>

                        <div class="form-row">
                                <a class="btn btn-danger" href="student_medical_records.php">Back to Student Medical Records</a>
                        </div>
                    </div>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Student Medical Data</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="medicalRecordTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Record Id</th>
                                            <th>Date Diagnosed</th>
                                            <th>Illness</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    // Placeholder for fetching and displaying medical records
                                    $stmt = $connection->prepare("SELECT * FROM student_clinic_record_table WHERE student_id = ?");
                                    if ($stmt) {
                                        $stmt->bind_param('i', $student_id);
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        while ($record = $result->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td>" . htmlspecialchars($record['record_id']) . "</td>";
                                            echo "<td>" . htmlspecialchars($record['date_diagnosed']) . "</td>";
                                            echo "<td>" . htmlspecialchars($record['illness']) . "</td>";

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
<?php
    include('teacher_footer.php');

?>