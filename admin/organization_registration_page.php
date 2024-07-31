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
<div class="container mt-5">
    <h2>Organization Registration Form</h2>

    <?php
    // Check for success or error messages in session
    if (isset($_SESSION['success'])) {
        echo "<div class='alert alert-success'>" . $_SESSION['success'] . "</div>";
        unset($_SESSION['success']); // Clear the session variable
    }

    if (isset($_SESSION['error'])) {
        echo "<div class='alert alert-danger'>" . $_SESSION['error'] . "</div>";
        unset($_SESSION['error']); // Clear the session variable
    }
    ?>

    <form action="process_code/process_organization_registration.php" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="organizationName">Organization Name</label>
            <input type="text" class="form-control" id="organizationName" name="organization_name" required>
        </div>
            <div class="form-group">
                <label for="department">Department</label>

                <select class="form-control" id="department" name="department" required>
                <?php
                    include("../include/connection.php");   

                    $mysqli_query_department =  mysqli_query($connection,"SELECT * FROM DEPARTMENT");
  
                          while ($row = mysqli_fetch_assoc($mysqli_query_department)) {
                            echo "<option value='" . $row['department_name'] . "'>" . $row['department_name'] . "</option>";
                                    }
                ?>
        
                </select>
            </div>
        <div class="form-group">
            <label for="advisorName">Advisor Name</label>
            <input type="text" class="form-control" id="advisorName" name="advisor_name" required>
        </div>
        <div class="form-group">
            <label for="contactEmail">Contact Email</label>
            <input type="email" class="form-control" id="contactEmail" name="contact_email" required>
        </div>
        <div class="form-group">
            <label for="organizationLogo">Organization Logo</label>
            <input type="file" class="form-control-file" id="organizationLogo" name="organization_logo" required>
        </div>
        <button type="submit" class="btn btn-primary">Register</button>
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
