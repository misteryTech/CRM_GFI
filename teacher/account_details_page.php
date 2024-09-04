<?php
include("teacher_header.php");
session_start();
include("../include/connection.php");

// Check if teacher is logged in
if (!isset($_SESSION['teacher_id'])) {
    $_SESSION['error'] = "You must be logged in to view this page.";
    header("Location: ../login_teacher.php");
    exit();
}

// Get teacher ID from session
$teacher_id = mysqli_real_escape_string($connection, $_SESSION['teacher_id']);

// Fetch teacher details from the database
$teacherQuery = "SELECT * FROM teachers_table WHERE teacher_id = '$teacher_id'";
$teacherResult = mysqli_query($connection, $teacherQuery);
$teacher = mysqli_fetch_assoc($teacherResult);

?>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php
        include("teacher_sidebar.php");
        ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php
                include("teacher_topbar.php");
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
                        <!-- teacher Information -->
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-md-4">
                                    <label for="teacherId">teacher ID</label>
                                    <input type="text" class="form-control" id="teacherId" name="teacher_id" value="<?php echo $teacher['teacher_id']; ?>" required readonly>
                                </div>
                                <div class="col-md-4">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control" id="username" name="username" value="<?php echo $teacher['username']; ?>" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="password">Password</label>
                                    <input type="text" class="form-control" id="password" name="password" value="<?php echo $teacher['password']; ?>" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-4">
                                    <label for="firstName">First Name</label>
                                    <input type="text" class="form-control" id="firstName" name="first_name" value="<?php echo $teacher['first_name']; ?>" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="lastName">Last Name</label>
                                    <input type="text" class="form-control" id="lastName" name="last_name" value="<?php echo $teacher['last_name']; ?>" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="dob">Date of Birth</label>
                                    <input type="date" class="form-control" id="dob" name="dob" value="<?php echo $teacher['dob']; ?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="gender">Gender</label>
                                <select class="form-control" id="gender" name="gender" required>
                                    <option value="Male" <?php echo ($teacher['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                                    <option value="Female" <?php echo ($teacher['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                                </select>
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
    include("teacher_footer.php");
    ?>
</body>
</html>
