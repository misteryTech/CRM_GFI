
<?php
include("admin_header.php");
session_start();
include("../include/connection.php");

// Fetch all teacher information from the database
$query = "SELECT * FROM teachers_table";
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
                            <h6 class="m-0 font-weight-bold text-primary">Teacher Information Data</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="teacherTable" width="100%" cellspacing="0">
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
                                            <th>teacher Id</th>
                                            <th>Username</th>
                                            <th>teacher Name</th>



                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                    <?php
// Loop through each row of the result set
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . $row['teacher_id'] . "</td>";
    echo "<td>" . $row['username'] . "</td>";
    echo "<td>" . $row['first_name'] .' '. $row['last_name'] . "</td>";
    echo "<td>";
    echo "<button class='btn btn-primary' data-toggle='modal' data-target='#viewModal" . $row['teacher_id'] . "'>View</button> ";
    echo "<button class='btn btn-warning' data-toggle='modal' data-target='#editModal" . $row['teacher_id'] . "'>Edit</button> ";
    echo "<button class='btn btn-danger' data-toggle='modal' data-target='#deleteModal" . $row['teacher_id'] . "'>Delete</button>";
    echo "</td>";
    echo "</tr>";

    // View Modal
    echo "<div class='modal fade' id='viewModal" . $row['teacher_id'] . "' tabindex='-1' role='dialog' aria-labelledby='viewModalLabel" . $row['teacher_id'] . "' aria-hidden='true'>";
    echo "<div class='modal-dialog modal-lg' role='document'>"; // Changed to modal-lg for larger width
    echo "<div class='modal-content'>";
    echo "<div class='modal-header'>";
    echo "<h5 class='modal-title' id='viewModalLabel" . $row['teacher_id'] . "'>teacher Details</h5>";
    echo "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
    echo "<span aria-hidden='true'>&times;</span>";
    echo "</button>";
    echo "</div>";
    echo "<div class='modal-body'>";
    echo "<div class='row'>";
    echo "<div class='col-md-6'>";
    echo "<p><strong>teacher ID:</strong> " . $row['teacher_id'] . "</p>";
    echo "<p><strong>Username:</strong> " . $row['username'] . "</p>";
    echo "<p><strong>First Name:</strong> " . $row['first_name'] . "</p>";
    echo "</div>";
    echo "<div class='col-md-6'>";
    echo "<p><strong>Last Name:</strong> " . $row['last_name'] . "</p>";
    echo "<p><strong>Email:</strong> " . $row['email'] . "</p>";
    echo "<p><strong>Year:</strong> " . $row['year'] . "</p>";
    echo "<p><strong>position:</strong> " . $row['position'] . "</p>";
    echo "<p><strong>department:</strong> " . $row['department'] . "</p>";
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
    echo "<div class='modal fade' id='editModal" . $row['teacher_id'] . "' tabindex='-1' role='dialog' aria-labelledby='editModalLabel" . $row['teacher_id'] . "' aria-hidden='true'>";
    echo "<div class='modal-dialog modal-lg' role='document'>"; // Changed to modal-lg for larger width
    echo "<div class='modal-content'>";
    echo "<div class='modal-header'>";
    echo "<h5 class='modal-title' id='editModalLabel" . $row['teacher_id'] . "'>Edit teacher</h5>";
    echo "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
    echo "<span aria-hidden='true'>&times;</span>";
    echo "</button>";
    echo "</div>";
    echo "<div class='modal-body'>";
    echo "<form action='process_code/teacher_edit_information.php' method='POST'>";
    echo "<input type='hidden' name='teacher_id' value='" . $row['teacher_id'] . "'>";
    echo "<input type='hidden' name='edit_password' value='" . $row['password'] . "'>";
    echo "<div class='row'>";


    echo "<div class='col-md-6'>";
    echo "<div class='form-group'>";
    echo "<label for='username" . $row['teacher_id'] . "'>Username</label>";
    echo "<input type='text' class='form-control' id='username" . $row['teacher_id'] . "' name='edit_username' value='" . $row['username'] . "' required>";
    echo "</div>";



    echo "<div class='form-group'>";
    echo "<label for='first_name" . $row['teacher_id'] . "'>First Name</label>";
    echo "<input type='text' class='form-control' id='first_name" . $row['teacher_id'] . "' name='edit_first_name' value='" . $row['first_name'] . "' required>";
    echo "</div>";


    echo "<div class='form-group'>";
    echo "<label for='dob" . $row['teacher_id'] . "'>Date of Birth</label>";
    echo "<input type='date' class='form-control' id='dob" . $row['dob'] . "' name='edit_dob' value='" . $row['dob'] . "' required>";
    echo "</div>";



    echo "<div class='form-group'>";
    echo "<label for='dob" . $row['teacher_id'] . "'>Date Hired</label>";
    echo "<input type='date' class='form-control' id='dob" . $row['dob'] . "' name='edit_date_hired' value='" . $row['date_hired'] . "' required>";
    echo "</div>";

    echo "</div>";



    echo "<div class='col-md-6'>";
    echo "<div class='form-group'>";
    echo "<label for='last_name" . $row['teacher_id'] . "'>teacher ID</label>";
    echo "<input type='text' class='form-control' id='last_name" . $row['teacher_id'] . "' name='edit_last_name' value='" . $row['teacher_id'] . "' required>";
    echo "</div>";



    echo "<div class='form-group'>";
    echo "<label for='edit_last_name" . $row['teacher_id'] . "'>Last Name</label>";
    echo "<input type='text' class='form-control' id='edit_last_name" . $row['teacher_id'] . "' name='edit_last_name' value='" . $row['last_name'] . "' required>";
    echo "</div>";


    $gender_options = ['Male', 'Female', 'Other'];

    echo "<div class='form-group'>";
    echo "<label for='gender" . $row['teacher_id'] . "'>Gender</label>";
    echo "<select class='form-control' id='gender" . $row['teacher_id'] . "' name='edit_gender' required>";

    // Populate the dropdown options
    foreach ($gender_options as $gender) {
        // Check if this option should be selected
        $selected = ($row['gender'] === $gender) ? 'selected' : '';
        echo "<option value='" . $gender . "' " . $selected . ">" . $gender . "</option>";
    }

    echo "</select>";
    echo "</div>";


   $position_options = ['Administrator', 'teacher'];
    echo "<div class='form-group'>";
    echo "<label for='position" . $row['teacher_id'] . "'>Position</label>";
    echo "<select class='form-control' id='position" . $row['teacher_id'] . "' name='edit_position' required>";

    // Populate the dropdown options
    foreach ($position_options as $position) {
        // Check if this option should be selected
        $selected = ($row['position'] === $position) ? 'selected' : '';
        echo "<option value='" . $position . "' " . $selected . ">" . $position . "</option>";
    }

    echo "</select>";
    echo "</div>";

    echo "</div>";


    echo "</div>";


    $department_option = ['Science','Mathematics','English','Social Studies','Physical Education','Arts'];
    echo "<div class='form-group'>";
    echo "<label for='department" . $row['teacher_id'] . "'>Department</label>";
    echo "<select class='form-control' id='department" . $row['teacher_id'] . "' name='edit_department' required>";
        foreach($department_option as $department){
            $selected_department  = ($row['department'] === $department) ? 'selected' : '';
            echo "<option value='" . $department . "' " . $selected_department . ">". $department . "</option>";
        }

        echo "</select>";
    echo "</div>";


    echo "<hr>";

    echo "<div class='col-md-12'>";
    echo "<h5>Contact Information</h6>";


    echo "<div class='form-group'>";
    echo "<label for='email" . $row['teacher_id'] . "'>Email</label>";
    echo "<input type='email' class='form-control' id='email" . $row['teacher_id'] . "' name='edit_email' value='" . $row['email'] . "' required>";
    echo "</div>";

    echo "<div class='form-group'>";
    echo "<label for='phone" . $row['teacher_id'] . "'>Phone No.</label>";
    echo "<input type='text' class='form-control' id='phone" . $row['teacher_id'] . "' name='edit_phone' value='" . $row['phone'] . "' required>";
    echo "</div>";

    echo "<div class='form-group'>";
    echo "<label for='Street" . $row['teacher_id'] . "'>Street</label>";
    echo "<input type='text' class='form-control' id='street" . $row['street'] . "' name='edit_street' value='" . $row['street'] . "' required>";
    echo "</div>";

    echo "<div class='form-group'>";
    echo "<label for='Barangay" . $row['teacher_id'] . "'>Barangay</label>";
    echo "<input type='text' class='form-control' id='barangay" . $row['barangay'] . "' name='edit_barangay' value='" . $row['barangay'] . "' required>";
    echo "</div>";
    echo "<div class='form-group'>";
    echo "<label for='Municipality" . $row['teacher_id'] . "'>Municipality</label>";
    echo "<input type='text' class='form-control' id='municipality" . $row['municipality'] . "' name='edit_municipality' value='" . $row['municipality'] . "' required>";
    echo "</div>";
    echo "<div class='form-group'>";
    echo "<label for='Province" . $row['teacher_id'] . "'>Province</label>";
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
    echo "<div class='modal fade' id='deleteModal" . $row['teacher_id'] . "' tabindex='-1' role='dialog' aria-labelledby='deleteModalLabel" . $row['teacher_id'] . "' aria-hidden='true'>";
    echo "<div class='modal-dialog modal-lg' role='document'>"; // Changed to modal-lg for larger width
    echo "<div class='modal-content'>";
    echo "<div class='modal-header'>";
    echo "<h5 class='modal-title' id='deleteModalLabel" . $row['teacher_id'] . "'>Delete teacher</h5>";
    echo "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
    echo "<span aria-hidden='true'>&times;</span>";
    echo "</button>";
    echo "</div>";
    echo "<div class='modal-body'>";
    echo "<p>Are you sure you want to delete this teacher ID" . $row['teacher_id'] ." ? </p>";
    echo "</div>";
    echo "<div class='modal-footer'>";
    echo "<button type='button' class='btn btn-secondary' data-dismiss='modal'>Cancel</button>";
    echo "<form action='process_code/teacher_delete_information.php' method='POST'>";
    echo "<input type='hidden' name='id' value='" . $row['teacher_id'] . "'>";
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
