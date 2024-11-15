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


                    <h2>Admin/Staff Registration Form</h2>
                    <form action="process_code/staff_registration.php" method="POST">
                        <!-- Admin/Staff Information -->
                        <div class="form-group">

                            <div class="form-row">
                                <div class="col-md-4">
                                    <label for="staffId">Staff ID</label>
                                    <input type="text" class="form-control" id="staffId" name="staff_id" required>

                                    <span id="staffIdError" style="color:red; display:none;">Staff ID already exists!</span>
                                    <span id="staffIdAvail" style="color:green; display:none;">Staff ID Available!</span>

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
                                    <input type="text" class="form-control" id="phone" name="phone" maxlength="11" required>
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

                        <!-- Position Details -->
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
                                        <option value="">Select Department</option>
                                        <option value="Administration">Administration</option>
                                        <option value="Finance">Finance</option>
                                        <option value="Human Resources">Human Resources</option>
                                        <option value="IT">IT</option>
                                        <option value="Maintenance">Maintenance</option>
                                        <option value="Library">Library</option>
                                        <option value="Mathematics">Mathematics</option>
                                        <option value="Science">Science</option>
                                        <option value="English">English</option>
                                        <option value="Social Studies">Social Studies</option>
                                        <option value="Physical Education">Physical Education</option>
                                        <option value="Arts">Arts</option>
                                        <option value="Music">Music</option>
                                        <option value="Foreign Languages">Foreign Languages</option>
                                        <option value="Special Education">Special Education</option>
                                    </select>

                                </div>
                                <div class="col-md-6">

                                    <label for="dob">Date Hired</label>
                                    <input type="date" class="form-control" id="date_hired" name="date_hired" required>
                                </div>


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


    <script>

document.getElementById('phone').addEventListener('input', function (e) {
        e.target.value = e.target.value.replace(/[^0-9]/g, ''); // Allow only numbers
    });

    
                    $(document).ready(function() {
                        // AJAX check for duplicate staff ID
                        $("#staffId").blur(function() {
                            var staffId = $(this).val();
                            $.ajax({
                                url: "validation/check_staff_id.php",
                                method: "POST",
                                data: { staff_id: staffId },
                                success: function(response) {
                                    if (response == "exists") {
    $("#staffIdError").show();
    $("#staffIdAvail").hide();
    $("#staffIdError").html('staff ID already exists.');
    $("button[type='submit']").prop('disabled', true);
    $("#staffId").css('border-color', 'red');  // Red border for duplicate ID
} else {
    $("#staffIdError").hide();
    $("#staffIdAvail").show();
    $("#staffIdError").html('staff is Available.');
    $("button[type='submit']").prop('disabled', false);
    $("#staffId").css('border-color', 'green');  // Green border for available ID
}
                                }
                            });
                        });
                    });
                </script>

