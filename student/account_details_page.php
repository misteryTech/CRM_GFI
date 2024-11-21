<?php
include("student_header.php");
include("../include/connection.php");



$student_id = $_SESSION['student_id'];
$username = $_SESSION['username'];


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

// Check if data was fetched successfully
if (mysqli_num_rows($studentResult) == 1) {
    $student = mysqli_fetch_assoc($studentResult);

    // Check for missing details
    $requiredFields = ['username', 'password', 'first_name', 'last_name', 'dob', 'gender', 'email', 'year', 'section', 'course'];
    $missingDetails = false;

    foreach ($requiredFields as $field) {
        if (empty($student[$field])) {
            $missingDetails = true;
            break;
        }
    }

    // Set a session error if details are missing
    if ($missingDetails) {
        $_SESSION['error'] = "Please complete your account details.";

    }
} else {
    // Student not found in the database
    $_SESSION['error'] = "Student record not found.";
    header("Location: ../login_student.php");
    exit();
}
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

                    <h2>Account Details</h2>
                    <form action="process_code/account_details_updates.php" method="POST">
                        <!-- student Information -->
                        <div class="form-group">
                            <div class="form-row">

                                    <input type="hidden" name="archive" value="<?php echo $student['archive']; ?>">
                                <div class="col-md-4">
                                    <label for="studentId">student ID</label>
                                    <input type="text" class="form-control" id="studentId" name="student_id" value="<?php echo $student['student_id']; ?>" required readonly>
                                </div>
                                <div class="col-md-4">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control" id="username" name="username" value="<?php echo $student['username']; ?>" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="password">Password</label>
                                    <input type="text" class="form-control" id="password" name="password" value="<?php echo $student['password']; ?>" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-4">
                                    <label for="firstName">First Name</label>
                                    <input type="text" class="form-control" id="firstName" name="first_name" value="<?php echo $student['first_name']; ?>" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="lastName">Last Name</label>
                                    <input type="text" class="form-control" id="lastName" name="last_name" value="<?php echo $student['last_name']; ?>" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="dob">Date of Birth</label>
                                    <input type="date" class="form-control" id="dob" name="dob" value="<?php echo $student['dob']; ?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="gender">Gender</label>
                                <select class="form-control" id="gender" name="gender" required>
                                    <option value="Male" <?php echo ($student['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                                    <option value="Female" <?php echo ($student['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                                </select>
                            </div>
                        </div>

                            <!-- Contact Details -->
                            <div class="form-group">
                            <h3>Contact Details</h3>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $student['email']; ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="phone">Phone Number</label>
                                    <input type="text" class="form-control" id="phone" name="phone" maxlength="11" value="<?php echo $student['phone']; ?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="street">Street</label>
                                <input type="text" class="form-control" id="street" name="street"  value="<?php echo $student['street']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="barangay">Barangay</label>
                                <input type="text" class="form-control" id="barangay" name="barangay" value="<?php echo $student['barangay']; ?>"  required>
                            </div>
                            <div class="form-group">
                                <label for="municipality">Municipality</label>
                                <input type="text" class="form-control" id="municipality" name="municipality" value="<?php echo $student['municipality']; ?>"  required>
                            </div>
                            <div class="form-group">
                                <label for="province">Province</label>
                                <input type="text" class="form-control" id="province" name="province" value="<?php echo $student['province']; ?>"  required>
                            </div>
                        </div>

                           <!-- Course -->
                        <div class="form-group">
                            <h3>Course</h3>
                            <div class="form-row">
                                <div class="col-md-4">
                                    <label for="year">Year</label>
                                    <input type="text" class="form-control" id="year" name="year" value="<?php echo $student['year']; ?>"  required>
                                </div>
                                <div class="col-md-4">
                                    <label for="section">Section</label>
                                    <input type="text" class="form-control" id="section" name="section" value="<?php echo $student['section']; ?>"  required>
                                </div>

                                <div class="col-md-4">
                                <label for="course">Course</label>
                                <select class="form-control" id="course" name="course" required>
    <option value="<?php echo $student['course']; ?>" selected><?php echo $student['course']; ?></option>
    <option value="BS in Accountancy">𝐁𝐒 𝐢𝐧 𝐀𝐜𝐜𝐨𝐮𝐧𝐭𝐚𝐧𝐜𝐲</option>
    <option value="BS in Management Accounting">BS in Management Accounting</option>
    <option value="BS in Secondary Education">BS Secondary Education</option>
    <option value="BS in Computer Science">BS in Computer Science</option>
    <option value="BS in Information Technology">BS in Information Technology</option>
    <option value="BS in Engineering">BS in Engineering</option>
    <option value="BS in Business Administration">BS in Business Administration</option>
    <option value="BS in Psychology">BS in Psychology</option>
    <option value="BS in Nursing">BS in Nursing</option>
</select>

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
<!-- JavaScript to show notification at the bottom if details are incomplete -->
<?php if (isset($_SESSION['error'])): ?>
    <script>
        // Show notification at the bottom
        const errorMessage = "<?php echo $_SESSION['error']; ?>";
        const notification = document.createElement('div');
        notification.classList.add('alert', 'alert-danger', 'fixed-bottom', 'mb-5', 'w-100');
        notification.style.zIndex = '9999';
        notification.innerText = errorMessage;
        document.body.appendChild(notification);

        // Auto-hide the notification after 5 seconds
        setTimeout(function() {
            notification.remove();
        }, 5000);
    </script>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>