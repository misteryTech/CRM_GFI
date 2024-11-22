<?php
include("staff_header.php");
include("../include/connection.php");



$staff_id = $_SESSION['staff_id'];
$username = $_SESSION['username'];


// Check if staff is logged in
if (!isset($_SESSION['staff_id'])) {
    $_SESSION['error'] = "You must be logged in to view this page.";
    header("Location: ../index.php");
    exit();
}

// Get staff ID from session
$staff_id = mysqli_real_escape_string($connection, $_SESSION['staff_id']);

// Fetch staff details from the database
$staffQuery = "SELECT * FROM staff_table WHERE staff_id = '$staff_id'";
$staffResult = mysqli_query($connection, $staffQuery);

// Check if data was fetched successfully
if (mysqli_num_rows($staffResult) == 1) {
    $staff = mysqli_fetch_assoc($staffResult);

    // Check for missing details
    $requiredFields = ['username', 'password', 'first_name', 'last_name', 'dob', 'gender', 'email', 'year', 'section', 'course'];
    $missingDetails = false;

    foreach ($requiredFields as $field) {
        if (empty($staff[$field])) {
            $missingDetails = true;
            break;
        }
    }

    // Set a session error if details are missing
    if ($missingDetails) {
        $_SESSION['error'] = "Please complete your account details.";

    }
} else {
    // staff not found in the database
    $_SESSION['error'] = "Staff record not found.";
    header("Location: ../index.php");
    exit();
}
?>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php
        include("staff_sidebar.php");
        ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php
                include("staff_topbar.php");
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
                        <!-- staff Information -->
                        <div class="form-group">
                            <div class="form-row">

                                    <input type="hidden" name="archive" value="<?php echo $staff['archive']; ?>">
                                <div class="col-md-4">
                                    <label for="staffId">staff ID</label>
                                    <input type="text" class="form-control" id="staffId" name="staff_id" value="<?php echo $staff['staff_id']; ?>" required readonly>
                                </div>
                                <div class="col-md-4">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control" id="username" name="username" value="<?php echo $staff['username']; ?>" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="password">Password</label>
                                    <input type="text" class="form-control" id="password" name="password" value="<?php echo $staff['password']; ?>" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-4">
                                    <label for="firstName">First Name</label>
                                    <input type="text" class="form-control" id="firstName" name="first_name" value="<?php echo $staff['first_name']; ?>" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="lastName">Last Name</label>
                                    <input type="text" class="form-control" id="lastName" name="last_name" value="<?php echo $staff['last_name']; ?>" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="dob">Date of Birth</label>
                                    <input type="date" class="form-control" id="dob" name="dob" value="<?php echo $staff['dob']; ?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="gender">Gender</label>
                                <select class="form-control" id="gender" name="gender" required>
                                    <option value="Male" <?php echo ($staff['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                                    <option value="Female" <?php echo ($staff['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                                </select>
                            </div>
                        </div>

                            <!-- Contact Details -->
                            <div class="form-group">
                            <h3>Contact Details</h3>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $staff['email']; ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="phone">Phone Number</label>
                                    <input type="text" class="form-control" id="phone" name="phone" maxlength="11" value="<?php echo $staff['phone']; ?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="street">Street</label>
                                <input type="text" class="form-control" id="street" name="street"  value="<?php echo $staff['street']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="barangay">Barangay</label>
                                <input type="text" class="form-control" id="barangay" name="barangay" value="<?php echo $staff['barangay']; ?>"  required>
                            </div>
                            <div class="form-group">
                                <label for="municipality">Municipality</label>
                                <input type="text" class="form-control" id="municipality" name="municipality" value="<?php echo $staff['municipality']; ?>"  required>
                            </div>
                            <div class="form-group">
                                <label for="province">Province</label>
                                <input type="text" class="form-control" id="province" name="province" value="<?php echo $staff['province']; ?>"  required>
                            </div>
                        </div>

                           <!-- Department -->
                           <div class="form-group">
                            <h3>Position Details</h3>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <label for="position">Position</label>
                             
                                    <select class="form-control" id="position" name="position" required>
                                        <option value="">Select Position</option>
                                        <option value="Administrator">Administrator</option>
                                        <option value="Staff">Staff</option>
                              
                                    </select>



                                </div>
                                <div class="col-md-6">
                                <label for="department">Department</label>
    <select class="form-control" id="department" name="department" required>
        <option value="" disabled selected>Select Department</option>
        <option value="Administration" <?php echo ($staff['department'] == 'Administration') ? 'selected' : ''; ?>>Administration</option>
        <option value="Finance" <?php echo ($staff['department'] == 'Finance') ? 'selected' : ''; ?>>Finance</option>
        <option value="Human Resources" <?php echo ($staff['department'] == 'Human Resources') ? 'selected' : ''; ?>>Human Resources</option>
        <option value="IT" <?php echo ($staff['department'] == 'IT') ? 'selected' : ''; ?>>IT</option>
        <option value="Maintenance" <?php echo ($staff['department'] == 'Maintenance') ? 'selected' : ''; ?>>Maintenance</option>
        <option value="Library" <?php echo ($staff['department'] == 'Library') ? 'selected' : ''; ?>>Library</option>
        <option value="Mathematics" <?php echo ($staff['department'] == 'Mathematics') ? 'selected' : ''; ?>>Mathematics</option>
        <option value="Science" <?php echo ($staff['department'] == 'Science') ? 'selected' : ''; ?>>Science</option>
        <option value="English" <?php echo ($staff['department'] == 'English') ? 'selected' : ''; ?>>English</option>
        <option value="Social Studies" <?php echo ($staff['department'] == 'Social Studies') ? 'selected' : ''; ?>>Social Studies</option>
        <option value="Physical Education" <?php echo ($staff['department'] == 'Physical Education') ? 'selected' : ''; ?>>Physical Education</option>
        <option value="Arts" <?php echo ($staff['department'] == 'Arts') ? 'selected' : ''; ?>>Arts</option>
        <option value="Music" <?php echo ($staff['department'] == 'Music') ? 'selected' : ''; ?>>Music</option>
        <option value="Foreign Languages" <?php echo ($staff['department'] == 'Foreign Languages') ? 'selected' : ''; ?>>Foreign Languages</option>
        <option value="Special Education" <?php echo ($staff['department'] == 'Special Education') ? 'selected' : ''; ?>>Special Education</option>
    </select>

                                </div>
                                <div class="col-md-6">

                                    <label for="dob">Date Hired</label>
                                    <input type="date" class="form-control" id="date_hired" name="date_hired" required>
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
    include("staff_footer.php");
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