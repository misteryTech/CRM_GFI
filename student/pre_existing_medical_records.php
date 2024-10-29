<?php
include("student_header.php");
include("../include/connection.php");

// Check if student is logged in
if (!isset($_SESSION['student_id'])) {
    $_SESSION['error'] = "You must be logged in to view this page.";
    header("Location: ../login_student.php");
    exit();
}

// Get student ID from session
$student_id = mysqli_real_escape_string($connection, $_SESSION['student_id']);

// Fetch student details from the database
$studentQuery = "SELECT * FROM students_table WHERE student_id = '$student_id'";
$studentResult = mysqli_query($connection, $studentQuery);
$student = mysqli_fetch_assoc($studentResult);

?>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php
        include("student_sidebar.php");
        ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php
                include("student_topbar.php");
                ?>

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

                    <h2>Medical Records</h2>
                    <form action="process_code/existing_medical_records.php" method="POST" enctype="multipart/form-data">
    <!-- Student Information -->
    <div class="form-group">
        <div class="form-row">
            <div class="col-md-4">
                <label for="studentId">Student ID</label>
                <input type="text" class="form-control" id="studentId" name="student_id" value="<?php echo $student['student_id']; ?>" required readonly>
            </div>
            <div class="col-md-8">
                <label for="documents">Documents</label>
                <input type="file" class="form-control" id="documents" name="documents" required>
            </div>
        </div>
        <br>

        <div class="form-row">
            <div class="col-md-12">
                <label for="chiefComplain">Chief Complaint</label>
                <textarea class="form-control" name="chief_complain" id="chiefComplain"></textarea>
            </div>
        </div>

        <div class="form-row">
            <div class="col-md-6">
                <label for="illness">Illness</label>
                <input type="text" class="form-control" id="illness" name="illness" required>
            </div>
            <div class="col-md-6">
                <label for="allergicReaction">Allergic Reaction</label>
                <input type="text" class="form-control" id="allergicReaction" name="allergic_reaction" required>
            </div>
        </div>

        <div class="form-row">
            <div class="col-md-4">
                <label for="medication">Medication</label>
                <input type="text" class="form-control" id="medication" name="medication" required>
            </div>
            <div class="col-md-4">
                <label for="dose">Dose</label>
                <input type="text" class="form-control" id="dose" name="dose" required>
            </div>
            <div class="col-md-4">
                <label for="timesPerDay">Times Per Day</label>
                <input type="text" class="form-control" id="timesPerDay" name="times_per_day" required>
            </div>
        </div>

        <br>

        <div class="form-row">
            <div class="col-md-4">
                <label for="startDate">Start Date</label>
                <input type="date" class="form-control" id="startDate" name="start_date" required>
            </div>
            <div class="col-md-4">
                <label for="endDate">End Date</label>
                <input type="date" class="form-control" id="endDate" name="end_date" required>
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-success">Update</button>
</form>

                </div>

                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <?php
    include("student_footer.php");
    ?>
</body>
</html>
 