<?php
include("admin_header.php");
session_start();
include("../include/connection.php");

// Fetch all student information from the database
$query = "SELECT * FROM students";
$result = mysqli_query($connection, $query);

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

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Student Information Data</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="studentTable" width="100%" cellspacing="0">
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

                                    <thead>
                                        <tr>
                                            <th>Student Id</th>
                                            <th>Username</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>

                                            <th>Email</th>

                                            <th>Year</th>
                                            <th>Section</th>
                                            <th>Course</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        // Loop through each row of the result set
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo "<tr>";
                                            echo "<td>" . $row['student_id'] . "</td>";
                                            echo "<td>" . $row['username'] . "</td>";
                                            echo "<td>" . $row['first_name'] . "</td>";
                                            echo "<td>" . $row['last_name'] . "</td>";

                                            echo "<td>" . $row['email'] . "</td>";

                                            echo "<td>" . $row['year'] . "</td>";
                                            echo "<td>" . $row['section'] . "</td>";
                                            echo "<td>" . $row['course'] . "</td>";
                                            echo "<td>";
                                            echo "<button class='btn btn-primary' data-toggle='modal' data-target='#editModal" . $row['id'] . "'>Edit</button> ";
                                            echo "<button class='btn btn-danger' data-toggle='modal' data-target='#deleteModal" . $row['id'] . "'>Delete</button>";
                                            echo "</td>";
                                            echo "</tr>";

                                            // Edit Modal
                                            echo "<div class='modal fade' id='editModal" . $row['id'] . "' tabindex='-1' role='dialog' aria-labelledby='editModalLabel' aria-hidden='true'>";
                                            echo "<div class='modal-dialog' role='document'>";
                                            echo "<div class='modal-content'>";
                                            echo "<div class='modal-header'>";
                                            echo "<h5 class='modal-title' id='editModalLabel'>Edit Student</h5>";
                                            echo "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
                                            echo "<span aria-hidden='true'>&times;</span>";
                                            echo "</button>";
                                            echo "</div>";
                                            echo "<div class='modal-body'>";
                                            // Edit form with fields pre-filled with existing data
                                            echo "<form action='process_code/student_edit_information.php' method='POST'>";
                                            echo "<input type='hidden' name='student_id' value='" . $row['id'] . "'>";
                                            echo "<div class='form-group'>";
                                            echo "<label for='editUsername'>Username</label>";
                                            echo "<input type='text' class='form-control' id='editUsername' name='edit_username' value='" . $row['username'] . "' required>";
                                            echo "</div>";
                                            echo "<div class='form-group'>";
                                            echo "<label for='editFirstName'>First Name</label>";
                                            echo "<input type='text' class='form-control' id='editFirstName' name='edit_first_name' value='" . $row['first_name'] . "' required>";
                                            echo "</div>";
                                            echo "<div class='form-group'>";
                                            echo "<label for='editLastName'>Last Name</label>";
                                            echo "<input type='text' class='form-control' id='editLastName' name='edit_last_name' value='" . $row['last_name'] . "' required>";
                                            echo "</div>";
                                            echo "<div class='form-group'>";
                                            echo "<label for='editDob'>Date of Birth</label>";
                                            echo "<input type='date' class='form-control' id='editDob' name='edit_dob' value='" . $row['dob'] . "' required>";
                                            echo "</div>";
                                            echo "<div class='form-group'>";
                                            echo "<label for='editGender'>Gender</label>";
                                            echo "<select class='form-control' id='editGender' name='edit_gender' required>";
                                            echo "<option value='Male'" . ($row['gender'] == 'Male' ? ' selected' : '') . ">Male</option>";
                                            echo "<option value='Female'" . ($row['gender'] == 'Female' ? ' selected' : '') . ">Female</option>";
                                            echo "</select>";
                                            echo "</div>";
                                            echo "<div class='form-group'>";
                                            echo "<label for='editEmail'>Email</label>";
                                            echo "<input type='email' class='form-control' id='editEmail' name='edit_email' value='" . $row['email'] . "' required>";
                                            echo "</div>";
                                            echo "<div class='form-group'>";
                                            echo "<label for='editPhone'>Phone Number</label>";
                                            echo "<input type='text' class='form-control' id='editPhone' name='edit_phone' value='" . $row['phone'] . "' required>";
                                            echo "</div>";
                                            echo "<div class='form-group'>";
                                            echo "<label for='editStreet'>Street</label>";
                                            echo "<input type='text' class='form-control' id='editStreet' name='edit_street' value='" . $row['street'] . "' required>";
                                            echo "</div>";
                                            echo "<div class='form-group'>";
                                            echo "<label for='editBarangay'>Barangay</label>";
                                            echo "<input type='text' class='form-control' id='editBarangay' name='edit_barangay' value='" . $row['barangay'] . "' required>";
                                            echo "</div>";
                                            echo "<div class='form-group'>";
                                            echo "<label for='editMunicipality'>Municipality</label>";
                                            echo "<input type='text' class='form-control' id='editMunicipality' name='edit_municipality' value='" . $row['municipality'] . "' required>";
                                            echo "</div>";
                                            echo "<div class='form-group'>";
                                            echo "<label for='editProvince'>Province</label>";
                                            echo "<input type='text' class='form-control' id='editProvince' name='edit_province' value='" . $row['province'] . "' required>";
                                            echo "</div>";
                                            echo "<div class='form-group'>";
                                            echo "<label for='editYear'>Year</label>";
                                            echo "<input type='text' class='form-control' id='editYear' name='edit_year' value='" . $row['year'] . "' required>";
                                            echo "</div>";
                                            echo "<div class='form-group'>";
                                            echo "<label for='editSection'>Section</label>";
                                            echo "<input type='text' class='form-control' id='editSection' name='edit_section' value='" . $row['section'] . "' required>";
                                            echo "</div>";
                                            echo "<div class='form-group'>";
                                            echo "<label for='editCourse'>Course</label>";
                                            echo "<select class='form-control' id='editCourse' name='edit_course' required>";
                                            echo "<option value=''>Select Course</option>";
                                            echo "<option value='Computer Science'" . ($row['course'] == 'Computer Science' ? ' selected' : '') . ">Computer Science</option>";
                                            echo "<option value='Information Technology'" . ($row['course'] == 'Information Technology' ? ' selected' : '') . ">Information Technology</option>";
                                            echo "<option value='Engineering'" . ($row['course'] == 'Engineering' ? ' selected' : '') . ">Engineering</option>";
                                            echo "<option value='Business Administration'" . ($row['course'] == 'Business Administration' ? ' selected' : '') . ">Business Administration</option>";
                                            echo "<option value='Psychology'" . ($row['course'] == 'Psychology' ? ' selected' : '') . ">Psychology</option>";
                                            echo "<option value='Nursing'" . ($row['course'] == 'Nursing' ? ' selected' : '') . ">Nursing</option>";
                                            echo "</select>";
                                            echo "</div>";
                                            echo "<button type='submit' class='btn btn-primary'>Save Changes</button>";
                                            echo "</form>";
                                            echo "</div>";
                                            echo "<div class='modal-footer'>";
                                            echo "<button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>";
                                            echo "</div>";
                                            echo "</div>";
                                            echo "</div>";
                                            echo "</div>";

                                            // Delete Modal
                                            echo "<div class='modal fade' id='deleteModal" . $row['id'] . "' tabindex='-1' role='dialog' aria-labelledby='deleteModalLabel' aria-hidden='true'>";
                                            echo "<div class='modal-dialog' role='document'>";
                                            echo "<div class='modal-content'>";
                                            echo "<div class='modal-header'>";
                                            echo "<h5 class='modal-title' id='deleteModalLabel'>Delete Student</h5>";
                                            echo "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
                                            echo "<span aria-hidden='true'>&times;</span>";
                                            echo "</button>";
                                            echo "</div>";
                                            echo "<div class='modal-body'>";
                                            echo "<p>Are you sure you want to delete this student?</p>";
                                            echo "</div>";
                                            echo "<div class='modal-footer'>";
                                            echo "<button type='button' class='btn btn-secondary' data-dismiss='modal'>Cancel</button>";
                                            // Delete button - this will submit a form to handle the deletion query
                                            echo "<form action='process_code/student_delete_information.php' method='POST'>";
                                            echo "<input type='hidden' name='student_id' value='" . $row['id'] . "'>"; // Hidden field to pass student ID
                                            echo "<button type='submit' class='btn btn-danger'>Delete</button>";
                                            echo "</form>";
                                            echo "</div>";
                                            echo "</div>";
                                            echo "</div>";
                                            echo "</div>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- End of Main Content -->
            </div>
            <!-- End of Content Wrapper -->

        </div>

    </div>
    <!-- End of Page Wrapper -->

    <?php
    include("admin_footer.php");
    ?>
