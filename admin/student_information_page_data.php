<?php
include("admin_header.php");


  $localhost= "localhost";
  $username= "root";
  $password= "";
  $dbname= "crm_gfi";

  $connection = mysqli_connect($localhost,$username,$password,$dbname);

  //if($connection){
   // echo"connected";
//}else{
 //   echo "disconnected";
//}

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
                                            <th>Student Name</th>

                                            <th>Email</th>

                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                    <?php

                                    

// Fetch all student information from the database
$query = "SELECT * FROM students_table";
$result = mysqli_query($connection, $query);
// Loop through each row of the result set
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . $row['student_id'] . "</td>";
    echo "<td>" . $row['username'] . "</td>";
    echo "<td>" . $row['first_name'] .' '. $row['last_name'] . "</td>";
    echo "<td>" . $row['email'] . "</td>";

    echo "<td>";
    echo "<button class='btn btn-primary' data-toggle='modal' data-target='#viewModal" . $row['student_id'] . "'>View</button> ";
    echo "<button class='btn btn-warning' data-toggle='modal' data-target='#editModal" . $row['student_id'] . "'>Edit</button> ";
    echo "<button class='btn btn-danger' data-toggle='modal' data-target='#deleteModal" . $row['student_id'] . "'>Delete</button>";
    echo "</td>";
    echo "</tr>";

    // View Modal
    echo "<div class='modal fade' id='viewModal" . $row['student_id'] . "' tabindex='-1' role='dialog' aria-labelledby='viewModalLabel" . $row['student_id'] . "' aria-hidden='true'>";
    echo "<div class='modal-dialog modal-lg' role='document'>"; // Changed to modal-lg for larger width
    echo "<div class='modal-content'>";
    echo "<div class='modal-header'>";
    echo "<h5 class='modal-title' id='viewModalLabel" . $row['student_id'] . "'>Student Details</h5>";
    echo "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
    echo "<span aria-hidden='true'>&times;</span>";
    echo "</button>";
    echo "</div>";
    echo "<div class='modal-body'>";
    echo "<div class='row'>";
    echo "<div class='col-md-6'>";
    echo "<p><strong>Student ID:</strong> " . $row['student_id'] . "</p>";
  
    echo "<p><strong>First Name:</strong> " . $row['first_name'] . "</p>";
    echo "<p><strong>Date of Birth:</strong> " . $row['dob'] . "</p>";
    echo "<p><strong>Gender: </strong> " . $row['gender'] . "</p>";
    echo "<hr>";
    echo "<p><strong>Street: </strong> " . $row['street'] . "</p>";
    echo "<p><strong>Barangay: </strong> " . $row['barangay'] . "</p>";
    echo "<p><strong>Munipality: </strong> " . $row['municipality'] . "</p>";
    echo "<p><strong>Munipality: </strong> " . $row['province'] . "</p>";
    echo "</div>";




    echo "<div class='col-md-6'>";
    echo "<p><strong>Username:</strong> " . $row['username'] . "</p>";
    echo "<p><strong>Last Name:</strong> " . $row['last_name'] . "</p>";
    echo "<p><strong>Phone:</strong> " . $row['phone'] . "</p>";
    echo "<p><strong>Email:</strong> " . $row['email'] . "</p>";
    echo "<hr>";
    echo "<p><strong>Year:</strong> " . $row['year'] . "</p>";
    echo "<p><strong>Section:</strong> " . $row['section'] . "</p>";
    echo "<p><strong>Course:</strong> " . $row['course'] . "</p>";
    echo "<p><strong>Registration Date:</strong> " . $row['registration_date'] . "</p>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
    echo "<div class='modal-footer'>";
    echo "<button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
    echo "</div>";

    // Edit Modal
    echo "<div class='modal fade' id='editModal" . $row['student_id'] . "' tabindex='-1' role='dialog' aria-labelledby='editModalLabel" . $row['student_id'] . "' aria-hidden='true'>";
    echo "<div class='modal-dialog modal-lg' role='document'>"; // Changed to modal-lg for larger width
    echo "<div class='modal-content'>";
    echo "<div class='modal-header'>";
    echo "<h5 class='modal-title' id='editModalLabel" . $row['student_id'] . "'>Edit Student</h5>";
    echo "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
    echo "<span aria-hidden='true'>&times;</span>";
    echo "</button>";
    echo "</div>";
    echo "<div class='modal-body'>";
    echo "<form action='process_code/student_edit_information.php' method='POST'>";
    echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
    echo "<input type='hidden' name='edit_password' value='" . $row['password'] . "'>";
    echo "<div class='row'>";


    echo "<div class='col-md-6'>";
    echo "<div class='form-group'>";
    echo "<label for='username" . $row['student_id'] . "'>Username</label>";
    echo "<input type='text' class='form-control' id='username" . $row['student_id'] . "' name='edit_username' value='" . $row['username'] . "' required>";
    echo "</div>";



    echo "<div class='form-group'>";
    echo "<label for='first_name" . $row['student_id'] . "'>First Name</label>";
    echo "<input type='text' class='form-control' id='first_name" . $row['student_id'] . "' name='edit_first_name' value='" . $row['first_name'] . "' required>";
    echo "</div>";


    echo "<div class='form-group'>";
    echo "<label for='dob" . $row['student_id'] . "'>Date of Birth</label>";
    echo "<input type='date' class='form-control' id='dob" . $row['dob'] . "' name='edit_dob' value='" . $row['dob'] . "' required>";
    echo "</div>";


    echo "<div class='form-group'>";
    echo "<label for='year" . $row['student_id'] . "'>School Year</label>";
    echo "<input type='text' class='form-control' id='year" . $row['student_id'] . "' name='edit_year' value='" . $row['year'] . "' required>";
    echo "</div>";

    echo "</div>";



    echo "<div class='col-md-6'>";
    echo "<div class='form-group'>";
    echo "<label for='last_name" . $row['student_id'] . "'>Student ID</label>";
    echo "<input type='text' class='form-control' id='last_name" . $row['student_id'] . "' name='edit_last_name' value='" . $row['student_id'] . "' required>";
    echo "</div>";



    echo "<div class='form-group'>";
    echo "<label for='edit_last_name" . $row['student_id'] . "'>Last Name</label>";
    echo "<input type='text' class='form-control' id='edit_last_name" . $row['student_id'] . "' name='edit_last_name' value='" . $row['last_name'] . "' required>";
    echo "</div>";


    $gender_options = ['Male', 'Female', 'Other'];

    echo "<div class='form-group'>";
    echo "<label for='gender" . $row['student_id'] . "'>Gender</label>";
    echo "<select class='form-control' id='gender" . $row['student_id'] . "' name='edit_gender' required>";

    // Populate the dropdown options
    foreach ($gender_options as $gender) {
        // Check if this option should be selected
        $selected = ($row['gender'] === $gender) ? 'selected' : '';
        echo "<option value='" . $gender . "' " . $selected . ">" . $gender . "</option>";
    }

    echo "</select>";
    echo "</div>";



    echo "<div class='form-group'>";
    echo "<label for='section" . $row['student_id'] . "'>School Section</label>";
    echo "<input type='text' class='form-control' id='section" . $row['student_id'] . "' name='edit_section' value='" . $row['section'] . "' required>";
    echo "</div>";

    echo "</div>";


    echo "</div>";


    $course_option = ['Computer Science','Information Technology','Engineering','Business Administration','Psychology','Nursing'];
    echo "<div class='form-group'>";
    echo "<label for='course" . $row['student_id'] . "'>Bachelor Course</label>";
    echo "<select class='form-control' id='course" . $row['student_id'] . "' name='edit_course' required>";
        foreach($course_option as $course){
            $selected_course  = ($row['course'] === $course) ? 'selected' : '';
            echo "<option value='" . $course . "' " . $selected_course . ">". $course . "</option>";
        }

        echo "</select>";
    echo "</div>";


    echo "<hr>";

    echo "<div class='col-md-12'>";
    echo "<h5>Contact Information</h6>";


    echo "<div class='form-group'>";
    echo "<label for='email" . $row['student_id'] . "'>Email</label>";
    echo "<input type='email' class='form-control' id='email" . $row['student_id'] . "' name='edit_email' value='" . $row['email'] . "' required>";
    echo "</div>";

    echo "<div class='form-group'>";
    echo "<label for='phone" . $row['student_id'] . "'>Phone No.</label>";
    echo "<input type='text' class='form-control' id='phone" . $row['student_id'] . "' name='edit_phone' value='" . $row['phone'] . "' required>";
    echo "</div>";

    echo "<div class='form-group'>";
    echo "<label for='Street" . $row['student_id'] . "'>Street</label>";
    echo "<input type='text' class='form-control' id='street" . $row['street'] . "' name='edit_street' value='" . $row['street'] . "' required>";
    echo "</div>";

    echo "<div class='form-group'>";
    echo "<label for='Barangay" . $row['student_id'] . "'>Barangay</label>";
    echo "<input type='text' class='form-control' id='barangay" . $row['barangay'] . "' name='edit_barangay' value='" . $row['barangay'] . "' required>";
    echo "</div>";
    echo "<div class='form-group'>";
    echo "<label for='Municipality" . $row['student_id'] . "'>Municipality</label>";
    echo "<input type='text' class='form-control' id='municipality" . $row['municipality'] . "' name='edit_municipality' value='" . $row['municipality'] . "' required>";
    echo "</div>";
    echo "<div class='form-group'>";
    echo "<label for='Province" . $row['student_id'] . "'>Province</label>";
    echo "<input type='text' class='form-control' id='province" . $row['province'] . "' name='edit_province' value='" . $row['province'] . "' required>";
    echo "</div>";



    echo "</div>";

    echo "<button type='submit' class='btn btn-primary'>Save changes</button>";
    echo "</form>";
    echo "</div>";
    echo "<div class='modal-footer'>";
    echo "<button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
    echo "</div>";

    // Delete Modal
    echo "<div class='modal fade' id='deleteModal" . $row['student_id'] . "' tabindex='-1' role='dialog' aria-labelledby='deleteModalLabel" . $row['student_id'] . "' aria-hidden='true'>";
    echo "<div class='modal-dialog modal-lg' role='document'>"; // Changed to modal-lg for larger width
    echo "<div class='modal-content'>";
    echo "<div class='modal-header'>";
    echo "<h5 class='modal-title' id='deleteModalLabel" . $row['student_id'] . "'>Delete Student</h5>";
    echo "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
    echo "<span aria-hidden='true'>&times;</span>";
    echo "</button>";
    echo "</div>";
    echo "<div class='modal-body'>";
    echo "<p>Are you sure you want to delete this student ID" . $row['student_id'] ." ? </p>";
    echo "</div>";
    echo "<div class='modal-footer'>";
    echo "<button type='button' class='btn btn-secondary' data-dismiss='modal'>Cancel</button>";
    echo "<form action='process_code/student_delete_information.php' method='POST'>";
    echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
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
