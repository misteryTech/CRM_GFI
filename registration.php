<?php
session_start();
include("include/connection.php");
include("header.php");
?>

<style>
.bg-gfi-school {
  background-color: #FB0601;
  background-image: linear-gradient(180deg, #FC9C8A 10%, #FB0601 100%);
  background-size: cover;
}

.card {
  margin-top: 50px;
}

.form-row .form-group {
  padding-right: 15px;
  padding-left: 15px;
}
</style>

<body class="bg-gfi-school">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg">
                    <div class="card-body p-4">
                        <div class="text-center">
                            <h1 class="h5 text-gray-900 mb-4">Patient Registration</h1>
                        </div>
                        <?php
                        if (isset($_SESSION['error'])) {
                            echo "<div class='alert alert-danger'>" . $_SESSION['error'] . "</div>";
                            unset($_SESSION['error']);
                        }
                        if (isset($_SESSION['success'])) {
                            echo "<div class='alert alert-success'>" . $_SESSION['success'] . "</div>";
                            unset($_SESSION['success']);
                        }
                        ?>
                        <form action="admin/process_code/student_registration.php" method="POST" enctype="multipart/form-data">
                            <!-- Student Information -->
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-md-4">
                                        <label for="studentId">Student ID</label>
                                        <input type="text" class="form-control" id="studentId" name="student_id" required>
                                        <span id="studentIdError" style="color:red; display:none;">Student ID already exists!</span>
                                        <span id="studentIdAvail" style="color:green; display:none;">Student ID Available!</span>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="username">Username</label>
                                        <input type="text" class="form-control" id="username" name="username" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="password">Password</label>
                                        <input type="text" class="form-control" id="password" name="password" required>
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

                            <!-- Course -->
                            <div class="form-group">
                                <h3>Course</h3>
                                <div class="form-row">
                                    <div class="col-md-4">
                                        <label for="year">Year</label>
                                        <input type="text" class="form-control" id="year" name="year" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="section">Section</label>
                                        <input type="text" class="form-control" id="section" name="section" required>
                                    </div>
                                    <div class="col-md-4">
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
                            </div>

                            <!-- Medical History -->
                            <div class="form-group">
                                <h3>Medical History</h3>
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <label for="pre_condition">Pre-existing Condition</label>
                                        <input type="text" class="form-control" id="pre_condition" name="pre_condition">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="documents">Documents</label>
                                        <input type="file" class="form-control" id="documents" name="documents">
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-success">Register</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
</body>
</html>
