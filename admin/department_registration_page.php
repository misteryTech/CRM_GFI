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
    <h2>Department Registration Form</h2>

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

    <form action="process_code/process_department_registration.php" method="POST">
        <div class="form-group">
            <label for="organizationName">Deparment Name</label>
            <input type="text" class="form-control" id="deparmentName" name="department_name" required>
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
