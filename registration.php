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
                            <h1 class="h5 text-gray-900 mb-4">Registration</h1>
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
                        
                        <!-- Registration Type Selector -->
                        <div class="form-group text-center">
                            <label for="registrationType">Select Registration Type:</label>
                            <select id="registrationType" class="form-control" style="width: 200px; margin: 0 auto;">
                                <option value="student">Student</option>
                                <option value="staff">Staff</option>
                            </select>
                        </div>

                        <!-- Student Registration Form -->
                        <form id="studentForm" action="admin/process_code/student_registration.php" method="POST" enctype="multipart/form-data" style="display: block;">
                            <h3>Student Registration</h3>
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
                                        <input type="password" class="form-control" id="password" name="password" required>
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

                            <!-- Additional Student Fields -->
                            <div class="form-group">
                                <h3>Course Details</h3>
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

                            <button type="submit" class="btn btn-success">Register</button>
                        </form>

                        <!-- Staff Registration Form -->
                        <form id="staffForm" action="admin/process_code/staff_registration.php" method="POST" enctype="multipart/form-data" style="display: none;">
                            <h3>Staff Registration</h3>
                            <!-- Staff Information -->
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-md-4">
                                        <label for="staffId">Staff ID</label>
                                        <input type="text" class="form-control" id="staffId" name="staff_id" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="usernameStaff">Username</label>
                                        <input type="text" class="form-control" id="usernameStaff" name="username" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="passwordStaff">Password</label>
                                        <input type="password" class="form-control" id="passwordStaff" name="password" required>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <label for="firstNameStaff">First Name</label>
                                        <input type="text" class="form-control" id="firstNameStaff" name="first_name" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="lastNameStaff">Last Name</label>
                                        <input type="text" class="form-control" id="lastNameStaff" name="last_name" required>
                                    </div>
                                </div>
                                <div class="form-group">
    <label for="position">Position</label>
    <select class="form-control" id="position" name="position" required>
        <option value="">Select Position</option>
        <option value="Teacher">Teacher</option>
        <option value="Administrative Staff">Administrative Staff</option>
        <option value="Librarian">Librarian</option>
        <option value="Guidance Counselor">Guidance Counselor</option>
        <option value="Janitor">Janitor</option>
        <option value="Security Guard">Security Guard</option>
    </select>
</div>

                            </div>

                            <button type="submit" class="btn btn-success">Register</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('registrationType').addEventListener('change', function() {
            const studentForm = document.getElementById('studentForm');
            const staffForm = document.getElementById('staffForm');
            if (this.value === 'student') {
                studentForm.style.display = 'block';
                staffForm.style.display = 'none';
            } else {
                studentForm.style.display = 'none';
                staffForm.style.display = 'block';
            }
        });
    </script>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
</body>
</html>
