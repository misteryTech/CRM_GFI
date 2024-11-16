<?php
include("student_header.php");

include("../include/connection.php");

// Check if the student is logged in
if (!isset($_SESSION['student_id'])) {


    $_SESSION['error'] = "You must be logged in to view this page.";
    header("Location: ../login_student.php");
    exit();
}


$student_id = $_SESSION['student_id'];
$username = $_SESSION['username'];


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


<style>
 #bannerCarousel {
        max-width: 100%; /* Ensure carousel takes full width of container */
        max-height: 400px; /* Set your fixed height */
        overflow: hidden; /* Hide overflow */
    }
    #bannerCarousel img {
        object-fit: cover; /* Maintain aspect ratio and cover the entire area */
        width: 100%; /* Ensure the image takes full width of the carousel */
        height: 100%; /* Ensure the image takes full height of the carousel */
    }


</style>
<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php include("student_sidebar.php"); ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php include("student_topbar.php"); ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Insert Image Banner -->
                    <div class="row mb-4">
    <div class="col-lg-12">
        <div id="bannerCarousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="../PICTURE/clinic_picture.png" class="d-block w-100" alt="Banner Image 1">
                </div>
                <div class="carousel-item">
                    <img src="../PICTURE/clinic_picture.png" class="d-block w-100" alt="Banner Image 2">
                </div>
                <div class="carousel-item">
                    <img src="../PICTURE/clinic_picture.png" class="d-block w-100" alt="Banner Image 3">
                </div>
            </div>
            <a class="carousel-control-prev" href="#bannerCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#bannerCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
</div>


                    <div class="row">
                        <!-- Area Chart -->
                        <div class="col-xl-8 col-lg-7">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Clinic Record Log</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="medicalRecordTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Student ID</th>
                                                    <th>Illness</th>
                                                    <th>Symptoms</th>
                                                    <th>Date Released</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                // Placeholder for fetching and displaying medical records
                                                $query = "SELECT * FROM student_clinic_record_table WHERE student_id = '$student_id' ";
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
                        <div class="col-xl-4 col-lg-5">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Clinic Instructions</h6>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                   <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
            </div>
        </div>
        <div class="card-body">
            <ul class="list-group">
                <li class="list-group-item">Please arrive 15 minutes before your appointment.</li>
                <li class="list-group-item">Bring your student ID and any necessary documents.</li>
                <li class="list-group-item">Follow all instructions given by the medical staff.</li>
                <li class="list-group-item">Maintain a respectful and quiet environment while in the clinic.</li>
            </ul>
        </div>
    </div>
</div>

                    </div>

                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->

            <?php include("student_footer.php"); ?>

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

        </div>
    </div>
</body>
