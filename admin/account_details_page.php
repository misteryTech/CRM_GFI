<?php
include("admin_header.php");
session_start();
include("../include/connection.php");

// Check if staff is logged in
if (!isset($_SESSION['staff_id'])) {
    $_SESSION['error'] = "You must be logged in to view this page.";
    header("Location: ../login.php");
    exit();
}

// Get staff ID from session
$staff_id = mysqli_real_escape_string($connection, $_SESSION['staff_id']);

// Fetch staff details from the database
$staffQuery = "SELECT * FROM staff_table WHERE staff_id = '$staff_id'";
$staffResult = mysqli_query($connection, $staffQuery);
$staff = mysqli_fetch_assoc($staffResult);

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
                                <div class="col-md-4">
                                    <label for="staffId">Staff ID</label>
                                    <input type="text" class="form-control" id="staffId" name="staff_id" value="<?php echo $staff['staff_id']; ?>" required readonly>
                                </div>
                                <div class="col-md-4">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control" id="username" name="username" value="<?php echo $staff['username']; ?>" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="password">Password</label>
                                              <div class="input-group">
                                                <input type="password" class="form-control" id="password" name="password" value="<?php echo $staff['password']; ?>" required>
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                                        Show
                                                    </button>
                                                </div>
                                            </div>
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
                                
                                <div class="col-md-4">
                                <label for="gender">Gender</label>
                                <select class="form-control" id="gender" name="gender" required>
                                    <option value="Male" <?php echo ($staff['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                                    <option value="Female" <?php echo ($staff['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
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
    include("admin_footer.php");
    ?>
</body>
</html>
