<?php
include("admin_header.php");
session_start();
include("../include/connection.php");
?>

<body id="page-top" onload="generatePassword()">

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


                    <h2>Student Registration Form</h2>
                    <form action="process_code/student_registration.php" method="POST">
                        <!-- Student Information -->
                        <div class="form-group">
                           
                            <div class="form-row">
                                <div class="col-md-4">
                                    <label for="studentId">Student ID</label>
                                    <input type="text" class="form-control" id="studentId" name="student_id" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control" id="username" name="username" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="password">Password</label>
                                    <input type="text" class="form-control" id="password" name="password" required readonly>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-4">
                                    <label for="firstName">First Name</label>
                                    <input type="text" class="form-control" id="firstName" name="first_name" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="lastName">Last Name</label>
                                    <input type="text" class="form-control" id="lastName" name="last_name" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="dob">Date of Birth</label>
                                    <input type="date" class="form-control" id="dob" name="dob" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="gender">Gender</label>
                                <select class="form-control" id="gender" name="gender" required>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                        </div>
                        <!-- Contact Details -->
                        <div class="form-group">
                            <h3>Contact Details</h3>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="phone">Phone Number</label>
                                    <input type="text" class="form-control" id="phone" name="phone" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="street">Street</label>
                                <input type="text" class="form-control" id="street" name="street" required>
                            </div>
                            <div class="form-group">
                                <label for="barangay">Barangay</label>
                                <input type="text" class="form-control" id="barangay" name="barangay" required>
                            </div>
                            <div class="form-group">
                                <label for="municipality">Municipality</label>
                                <input type="text" class="form-control" id="municipality" name="municipality" required>
                            </div>
                            <div class="form-group">
                                <label for="province">Province</label>
                                <input type="text" class="form-control" id="province" name="province" required>
                            </div>
                        </div>

                           <!-- Course -->
                           <div class="form-group">
                            <h3>Course</h3>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <label for="year">Year</label>
                                    <input type="text" class="form-control" id="year" name="year" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="section">Section</label>
                                    <input type="text" class="form-control" id="section" name="section" required>
                                </div>
                            </div>
                            <div class="form-group">
                                  <label for="course">Course</label>
                                  <select class="form-control" id="course" name="course" required>
                                      <option value="">Select Course</option>
                                      <option value="Computer Science">Computer Science</option>
                                      <option value="Information Technology">Information Technology</option>
                                      <option value="Engineering">Engineering</option>
                                      <option value="Business Administration">Business Administration</option>
                                      <option value="Psychology">Psychology</option>
                                      <option value="Nursing">Nursing</option>
                                  </select>
                                </div>

                        </div>
                        <button type="submit" class="btn btn-success">Register</button>
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
    </div>
                        
