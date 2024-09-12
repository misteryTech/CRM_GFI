


<?php
include("admin_header.php");

session_start();
include("../include/connection.php");

// Check if student is logged in
if (!isset($_SESSION['staff_id'])) {
    $_SESSION['error'] = "You must be logged in to view this page.";
    header("Location: ../login.php");
    exit();
}




// Prepare the SQL statement
$stmt = $connection->prepare("SELECT
                          SUM(CASE WHEN gender = ? THEN 1 ELSE 0 END) as gender_count
                        FROM students_table");

// Bind parameters and execute the statement for male count
$gender = 'Male';
$stmt->bind_param("s", $gender);
$stmt->execute();
$stmt->bind_result($male_count);
$stmt->fetch();

// Bind parameters and execute the statement for female count
$gender = 'Female';
$stmt->bind_param("s", $gender);
$stmt->execute();
$stmt->bind_result($female_count);
$stmt->fetch();




// Close the statement
$stmt->close();
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
                                                        $query= mysqli_query($connection,"SELECT * FROM students_table");

                                                        $count_row_student = mysqli_num_rows($query);

                                                        echo $count_row_student;
                                                    ?>


                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">Total Students</div>
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
                                                        $query= mysqli_query($connection,"SELECT * FROM staff_table");

                                                        $count_row_organization = mysqli_num_rows($query);

                                                        echo $count_row_organization    ;
                                                    ?>


                                                </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            Total Teacher
                                            </div>
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
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                            <?php
                                                        $query= mysqli_query($connection,"SELECT * FROM medicines");

                                                        $count_row_registrations = mysqli_num_rows($query);

                                                        echo $count_row_registrations    ;
                                                    ?>



                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">Total Medicine</div>
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
                            <div class="card border-left-danger shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                     <?php
                                                        $query= mysqli_query($connection,"SELECT * FROM medicines WHERE stock <= 5 " );

                                                        $count_row_events = mysqli_num_rows($query);

                                                        echo $count_row_events ;
                                                    ?>
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">Request Stock</div>
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

                <!-- /.container-fluid -->
     <!-- Content Row -->
     <div class="row">


            <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-4 col-md-6 mb-4">
                 <div class="card border-left-primary shadow h-100 py-2">
                       <div class="card-body">
                             <div class="row no-gutters align-items-center">
                                   <div class="col mr-2">

                        <div class="h5 mb-0 font-weight-bold text-gray-800">Request Students</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                </div>

                <a href="student_release_form.php" class="btn btn-primary btn-icon-split">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-info-circle"></i>
                                        </span>
                                        <span class="text">Release Form</span>
                </a>


            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">

                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            Request Teacher
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                </div>

                <a href="#" class="btn btn-primary btn-icon-split">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-info-circle"></i>
                                        </span>
                                        <span class="text">Release Form</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">

                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">Request Staff</div>
                            </div>
                            <div class="col">
                                <div class="progress progress-sm mr-2">

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                </div>

                <a href="#" class="btn btn-primary btn-icon-split">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-info-circle"></i>
                                        </span>
                                        <span class="text">Release Form</span>
                </a>
            </div>
        </div>
    </div>


    </div>


    <div class="row">

<!-- Area Chart -->
<div class="col-xl-8 col-lg-7">
<div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Clinic Record Log </h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="medicalRecordTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Record Id</th>
                                            <th>Student ID</th>
                                            <th>Illness</th>
                                            <th>symptoms</th>
                                            <th>Date Released</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    // Placeholder for fetching and displaying medical records
                                    $query = "SELECT * FROM student_clinic_record_table";
                                    $result = mysqli_query($connection, $query);
                                        while ($record = mysqli_fetch_assoc($result)) {

                                            $month_name = date("F-m-y", strtotime($record['date_diagnosed']));


                                            echo "<tr>";
                                            echo "<td>" . htmlspecialchars($record['record_id']) . "</td>";
                                            echo "<td>" . htmlspecialchars($record['student_id']) . "</td>";
                                            echo "<td>" . htmlspecialchars($record['illness']) . "</td>";
                                            echo "<td>" . htmlspecialchars($record['symptoms']) . "</td>";
                                            echo "<td>" . htmlspecialchars($month_name) . "</td>";
                                            echo "</tr>";


                                        }


                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
</div>

<!-- Pie Chart -->
<div class="col-xl-4 col-lg-5">
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div
            class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Registered Student Gender</h6>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>

            </div>
        </div>
        <!-- Card Body -->
        <div class="card-body">
    <div class="chart-pie pt-4 pb-2">
        <canvas id="myPieChart"></canvas>
    </div>
    <div class="mt-4 text-center small">
        <span class="mr-2">
            <i class="fas fa-circle text-primary"></i> Male
        </span>
        <span class="mr-2">
            <i class="fas fa-circle text-success"></i> Female
        </span>
    </div>
</div>


    </div>
</div>
</div>






                   </div>
                </div>
            </div>
         </div>
            <!-- End of Main Content -->

         <?php
         include("admin_footer.php");
         ?>



<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>

var maleCount = <?php echo $male_count; ?>;
var femaleCount = <?php echo $female_count; ?>;
// Create the pie chart
var ctx = document.getElementById('myPieChart').getContext('2d');
var myPieChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: ['Male', 'Female'],
        datasets: [{
            data: [maleCount, femaleCount],
            backgroundColor: ['#4e73df', '#1cc88a'],
            hoverBackgroundColor: ['#2e59d9', '#17a673'],
            hoverBorderColor: 'rgba(234, 236, 244, 1)',
        }],
    },
    options: {
        maintainAspectRatio: false,
        tooltips: {
            backgroundColor: 'rgb(255,255,255)',
            bodyFontColor: '#858796',
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            caretPadding: 10,
        },
        legend: {
            display: false
        },
        cutoutPercentage: 80,
    },
});
</script>