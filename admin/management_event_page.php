


<?php
include("admin_header.php");
session_start();
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
    <h2>Event Management</h2>
    <hr>
 <!-- Displaying session messages if any -->
 <?php
    if (isset($_SESSION['message'])) {
        echo "<div class='alert {$_SESSION['message_type']}' role='alert'>{$_SESSION['message']}</div>";
        unset($_SESSION['message']);
        unset($_SESSION['message_type']);
    }
    ?>
    <!-- Add Event Form -->
    <h4>Add New Event</h4>
    <form action="process_code/management_event_registration.php" method="POST">
        <div class="form-group">
            <label for="title">Event Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
        </div>
        <div class="form-group">
            <label for="date">Date</label>
            <input type="date" class="form-control" id="date" name="date" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Event</button>
    </form>


</div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

         <?php
         include("admin_footer.php")
         ?>