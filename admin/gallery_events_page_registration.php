<?php
include("admin_header.php");
session_start();

include("../include/connection.php");

// Fetch events from the database
$sql = "SELECT title, description, date, image_path FROM events";
$result = $connection->query($sql);

$events = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
}

// Fetch organizer names from the organizations table
$orgSql = "SELECT id, organization_name, advisor_name FROM organizations";
$orgResult = $connection->query($orgSql);

$organizers = [];
if ($orgResult->num_rows > 0) {
    while ($orgRow = $orgResult->fetch_assoc()) {
        $organizers[$orgRow['id']] = $orgRow['organization_name'];
    }
}

$connection->close();

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
 <div class="container mt-5">
        <h2 class="mb-4">Register a New Event</h2>
        <?php
        if (isset($_SESSION['message'])) {
            echo "<div class='alert {$_SESSION['message_type']}' role='alert'>{$_SESSION['message']}</div>";
            unset($_SESSION['message']);
            unset($_SESSION['message_type']);
        }
        ?>
        <form action="event_registration_form.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Event Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="description">Event Description</label>
                <textarea class="form-control" id="description" name="description" rows="5" required></textarea>
            </div>
            <div class="form-group">
                <label for="date">Event Date</label>
                <input type="date" class="form-control" id="date" name="date" required>
            </div>
            <div class="form-group">
                <label for="organizer">Organizer</label>
                <select class="form-control" id="organizer" name="organizer" required>
                    <option value="" disabled selected>Select organizer</option>
                    <?php foreach ($organizers as $orgId => $organizerName): ?>
                        <option value="<?php echo $orgId; ?>"><?php echo $organizerName; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="image">Event Image</label>
                <input type="file" class="form-control-file" id="image" name="image" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit Event</button>
        </form>
    </div>

                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

         <?php
         include("admin_footer.php")
         ?>
