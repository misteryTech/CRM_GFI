<?php
include("admin_header.php");
session_start();
include("../include/connection.php");


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
                            <h6 class="m-0 font-weight-bold text-primary">Staff Information Data</h6>
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
                                            <th>Position</th>
                                            <th>Department</th>

                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                    <?php
// Loop through each row of the result set

// Fetch all student information from the database
$query = "SELECT * FROM staff_table";
$result = mysqli_query($connection, $query);


while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . $row['staff_id'] . "</td>";
    echo "<td>" . $row['username'] . "</td>";
    echo "<td>" . $row['first_name'] .' '. $row['last_name'] . "</td>";
    echo "<td>" . $row['email'] . "</td>";
    echo "<td>" . $row['position'] . "</td>";
    echo "<td>" . $row['department'] . "</td>";

    echo "<td>";
    echo "<a class='btn btn-primary' href='staff_release_form_page.php?staff_id=" . $row['staff_id'] . "'>Release Medicine</a> ";
    echo "</td>";
    echo "</tr>";


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
