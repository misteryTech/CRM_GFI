


<?php
include("admin_header.php");

session_start();
include("../include/connection.php");

// Check if student is logged in
if (!isset($_SESSION['student_id'])) {
    $_SESSION['error'] = "You must be logged in to view this page.";
    header("Location: ../login.php");
    exit();
}


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



                    <!-- Page Heading -->
                    <!--<div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                    </div>-->

                    <!-- Content Row -->
                    <div class="row">


                    <!-- Earnings (Monthly) Card Example -->
                    <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                    <?php
                                                        $query= mysqli_query($connection,"SELECT * FROM STUDENTS");

                                                        $count_row_student = mysqli_num_rows($query);

                                                        echo $count_row_student;
                                                    ?>


                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">Students</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-user fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            <?php
                                                        $query= mysqli_query($connection,"SELECT * FROM organizations");

                                                        $count_row_organization = mysqli_num_rows($query);

                                                        echo $count_row_organization    ;
                                                    ?>


                                                </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                Organization
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-building fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                            <?php
                                                        $query= mysqli_query($connection,"SELECT * FROM registrations");

                                                        $count_row_registrations = mysqli_num_rows($query);

                                                        echo $count_row_registrations    ;
                                                    ?>



                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">Events</div>
                                                </div>
                                                <div class="col">
                                                    <div class="progress progress-sm mr-2">
                                                        <!--<div class="progress-bar bg-info" role="progressbar"
                                                            style="width: 50%" aria-valuenow="50" aria-valuemin="0"
                                                            aria-valuemax="100"></div>-->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pending Requests Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                     <?php
                                                        $query= mysqli_query($connection,"SELECT * FROM events");

                                                        $count_row_events = mysqli_num_rows($query);

                                                        echo $count_row_events    ;
                                                    ?>
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">Registratered Organization</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Content Column -->
                        <div class="col-lg-6 mb-4">



                    </div>
                <!-- /.container-fluid -->

                </div>
            </div>
         </div>
            <!-- End of Main Content -->

         <?php
         include("admin_footer.php");
         ?>