<?php
include("student_header.php");
session_start();
include("../include/connection.php");

// Fetch events from the database with organizer names
$sql = "SELECT e.id, e.title, e.description, e.date, e.image_path, o.organization_name 
        FROM events e 
        INNER JOIN organizations o ON e.organization_id = o.id"; 
$result = $connection->query($sql);

$events = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
}

$connection->close();
?>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <?php include("student_sidebar.php"); ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <?php include("student_topbar.php"); ?>

                <div class="container mt-5">
                    <h2 class="mb-4">Events Gallery</h2>
                    <div class="row">
                        <?php foreach ($events as $event): ?>
                            <div class="col-md-4 mb-4">
                                <div class="card">
                                    <img src="../admin/<?php echo $event['image_path']; ?>" class="card-img-top" alt="<?php echo $event['title']; ?>">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo $event['title']; ?></h5>
                                    </div>
                                    <button class="btn btn-success view-btn" data-toggle="modal" data-target="#eventModal" 
                                            data-id="<?php echo $event['id']; ?>" data-title="<?php echo $event['title']; ?>" 
                                            data-description="<?php echo $event['description']; ?>" 
                                            data-date="<?php echo $event['date']; ?>" 
                                            data-image="<?php echo $event['image_path']; ?>"
                                            data-organizer="<?php echo $event['organization_name']; ?>">View</button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="eventModalLabel">Event Details</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <img src="" id="eventImage" class="img-fluid mb-3" alt="">

                                <label for="">Event Title:</label>
                                <h5 id="eventTitle"></h5>
                                <br>
                                <label for="">Event Description:</label>
                                <p id="eventDescription"></p>
                                <br>
                                <label for="">Event Date:</label>
                                <p id="eventDate"></p>
                                <br>
                                <label for="">Organizer:</label>
                                <p id="eventOrganizer"></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- End of Main Content -->

            <?php include("student_footer.php"); ?>
        </div>
    </div>
    <!-- End of Page Wrapper -->

    <script>
        // JavaScript to handle the event view modal
        document.addEventListener('DOMContentLoaded', function() {
            const viewButtons = document.querySelectorAll('.view-btn');
            viewButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const eventId = button.getAttribute('data-id');
                    const eventTitle = button.getAttribute('data-title');
                    const eventDescription = button.getAttribute('data-description');
                    const eventDate = button.getAttribute('data-date');
                    const eventImage = button.getAttribute('data-image');
                    const eventOrganizer = button.getAttribute('data-organizer');

                    document.getElementById('eventTitle').textContent = eventTitle;
                    document.getElementById('eventDescription').textContent = eventDescription;
                    document.getElementById('eventDate').textContent = eventDate;
                    document.getElementById('eventImage').setAttribute('src', eventImage);
                    document.getElementById('eventOrganizer').textContent = eventOrganizer;
                });
            });
        });
    </script>
