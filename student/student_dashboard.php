


<?php
include("student_header.php");
session_start();

include("../include/connection.php");



// Get student ID from session
$student_id = $_SESSION['student_id'];
?>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php
        include("student_sidebar.php");
        ?>

          <!-- Content Wrapper -->
          <div id="content-wrapper" class="d-flex flex-column">

<!-- Main Content -->
<div id="content">

    <?php
    include("student_topbar.php");
    ?>

    <div class="container mt-5">

    <h1>Calendar Activities <?php echo $student_id; ?></h1>


        <div id="calendar"></div>
    </div>

    <!-- FullCalendar CSS -->



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: {
                    url: '../admin/process_code/calendar_events_fetch_data.php',
                    method: 'GET',
                    failure: function() {
                        alert('There was an error while fetching events!');
                    }
                },
                eventClick: function(info) {
                    alert('Event: ' + info.event.title + '\nDescription: ' + info.event.extendedProps.description);
                }
            });
            calendar.render();
        });
    </script>

    <!-- /.container-fluid -->
</div>
<!-- End of Main Content -->

<?php
include("student_footer.php");
?>

        </div>
        <!-- End of Content Wrapper -->
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

         <?php
         include("student_footer.php")
         ?>