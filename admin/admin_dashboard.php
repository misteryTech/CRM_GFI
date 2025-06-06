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


// Query for monthly visits data
$monthlyVisitsQuery = "
    SELECT DATE_FORMAT(date_diagnosed, '%Y-%m') AS month, COUNT(*) AS visit_count
    FROM student_clinic_record_table
    GROUP BY month
    ORDER BY month ASC";
$monthlyVisitsResult = mysqli_query($connection, $monthlyVisitsQuery);

// Initialize an array with all months set to 0
$allMonths = array_fill_keys(array_map(function ($n) {
    return date("Y-m", strtotime("first day of -$n month"));
}, range(11, 0)), 0);

// Populate with actual visit counts
while ($row = mysqli_fetch_assoc($monthlyVisitsResult)) {
    $allMonths[$row['month']] = (int)$row['visit_count'];
}

$monthlyLabels = array_keys($allMonths);
$monthlyVisitsData = array_values($allMonths);





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
        <div class="col-xl-6 col-md-6 mb-4">
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
    <div class="col-xl-6 col-md-6 mb-4">
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

                <a href="staff_release_form.php" class="btn btn-primary btn-icon-split">
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
<div class="col-xl-12 col-lg-6">
<div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Student Record Log </h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="medicalRecordTables" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                         
                                            <th>Student Name</th>
                                            <th>Chief Complaint</th>
                                    
                                            <th>Recommendation</th>
                                            <th>Date Released</th>
                                         
                                            <th>Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    // Placeholder for fetching and displaying medical records
                                    $query = "SELECT scrt.* , s.*
                                    
                                    
                                    FROM student_clinic_record_table AS scrt
                                     INNER JOIN students_table AS s ON scrt.student_id = s.student_id
                                    ORDER BY scrt.record_id DESC
                                    ";
                                    $result = mysqli_query($connection, $query);
                                        while ($record = mysqli_fetch_assoc($result)) {

                                            $month_name = date("F-m-y", strtotime($record['date_diagnosed']));


                                            echo "<tr>";
                                 
                                            echo "<td>" . htmlspecialchars($record['first_name']).' ' . htmlspecialchars($record['last_name']) . "</td>";
                                            echo "<td>" . htmlspecialchars($record['illness']) . "</td>";
                                         
                                            echo "<td>" . htmlspecialchars($record['recommendation']) . "</td>";
                                            
                                            echo "<td>" . htmlspecialchars($month_name) . "</td>";
                                        
                                            echo "<td><button class='btn btn-success view-btn' data-id='" . $record['student_id'] . "'>View</button></td>";
                                            echo "</tr>";


                                        }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
</div>




<!-- Optional: Modal for displaying more details on click -->
<div class="modal fade" id="viewRecordModal" tabindex="-1" role="dialog" aria-labelledby="viewRecordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewRecordModalLabel">Medical Record Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Dynamic content will be loaded here using JavaScript or Ajax -->
                <p id="recordDetails"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>





<div class="col-xl-12 col-lg-6">
<div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Staff Record Log </h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="staffmedicalRecordTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                         
                                            <th>Staff Name</th>
                                            <th>Chief Complaint</th>
                                         
                                            <th>Reccomendation</th>
                                            <th>Department</th>
                                            <th>Date Released</th>
                                   
                                            <th>Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    // Placeholder for fetching and displaying medical records
                                    $query = "SELECT scrts.* , tb.*
                                    
                                    
                                    FROM staff_clinic_record_table AS scrts
                                     INNER JOIN staff_table AS  tb  ON scrts.staff_id = tb.staff_id
                                    ORDER BY scrts.record_id DESC
                                    ";
                                    $result = mysqli_query($connection, $query);
                                        while ($record = mysqli_fetch_assoc($result)) {

                                            $month_name = date("F-m-y", strtotime($record['date_diagnosed']));


                                            echo "<tr>";
                                 
                                            echo "<td>" . htmlspecialchars($record['first_name']).' ' . htmlspecialchars($record['last_name']) . "</td>";
                                            echo "<td>" . htmlspecialchars($record['illness']) . "</td>";
                            
                                            echo "<td>" . htmlspecialchars($record['recommendation']) . "</td>";
                                            echo "<td>" . htmlspecialchars($record['department']) . "</td>";
                                            echo "<td>" . htmlspecialchars($month_name) . "</td>";
                                        
                                            echo "<td><button class='btn btn-success view-btn' data-id='" . $record['staff_id'] . "'>View</button></td>";
                                            echo "</tr>";


                                        }


                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
</div>








    </div>

    
</div>
</div>



<div class="row">
                        <div class="col-xl-8 col-lg-7">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Monthly Clinic Visits</h6>
                                </div>
                                <div class="card-body">
                                    <canvas id="monthlyVisitChart"></canvas>
                                </div>
                            </div>
                        </div>

                        <!-- Pie Chart -->
<div class="col-xl-4 col-lg-5">
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div
            class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Registered Students Gender</h6>
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
            <!-- End of Main Content -->

         <?php
         include("admin_footer.php");
         ?>



<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  
// Data for Monthly Visits Chart
var monthlyLabels = <?php echo json_encode($monthlyLabels); ?>;
var monthlyVisitsData = <?php echo json_encode($monthlyVisitsData); ?>;


$('.view-btn').on('click', function() {
        var recordId = $(this).data('id'); // Get the record ID
        
        // Optional: Use Ajax to fetch and display the details for the selected record
        $.ajax({
            url: 'process_code/fetch_record_details.php',  // Create a PHP file to fetch details by record ID
            type: 'GET',
            data: { id: recordId },
            success: function(response) {
                // Populate modal with fetched data
                $('#recordDetails').html(response);
                $('#viewRecordModal').modal('show');  // Show the modal
            }
        });
    });

    
// Convert numeric month labels to month names
var monthNames = ["January", "February", "March", "April", "May", "June", 
                  "July", "August", "September", "October", "November", "December"];

monthlyLabels = monthlyLabels.map(function(month) {
    var parts = month.split("-");
    var year = parts[0];
    var monthIndex = parseInt(parts[1], 10) - 1;
    return monthNames[monthIndex] + " " + year;
});

// Monthly Visits Line Chart
var ctxLine = document.getElementById('monthlyVisitChart').getContext('2d');
var monthlyVisitChart = new Chart(ctxLine, {
    type: 'line',
    data: {
        labels: monthlyLabels,
        datasets: [{
            label: 'Student Inquired',
            data: monthlyVisitsData,
            backgroundColor: 'rgba(78, 115, 223, 0.05)',
            borderColor: 'rgba(78, 115, 223, 1)',
            pointBackgroundColor: 'rgba(78, 115, 223, 1)',
            pointBorderColor: 'rgba(78, 115, 223, 1)',
            pointHoverBackgroundColor: 'rgba(78, 115, 223, 1)',
            pointHoverBorderColor: 'rgba(78, 115, 223, 1)',
        }],
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            x: { 
                title: { display: true, text: 'Month' },
            },
            y: { 
                title: { display: true, text: 'Number of Visits' }, 
                beginAtZero: true,
                ticks: {
                    stepSize: 1, // Forces y-axis to increment by whole numbers
                    callback: function(value) { return Number.isInteger(value) ? value : null; }
                }
            }
        }
    }
});


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