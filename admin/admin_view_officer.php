<?php
include("admin_header.php");
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

                <?php 
                include("../include/connection.php");

                // Check if the officer ID is provided in the query parameter
                if (isset($_GET['id'])) {
                    $officer_id = $_GET['id'];

                    // Fetch officer data from the database based on the ID
                    $query = "SELECT * FROM officers WHERE id = '$officer_id'";
                    $result = mysqli_query($connection, $query);

                    if (mysqli_num_rows($result) > 0) {
                        $officer = mysqli_fetch_assoc($result);
                        // Display the officer details
                        echo "<h3>Officer Details</h3>";
                        echo "<p><strong>ID:</strong> " . $officer['id'] . "</p>";
                        echo "<p><strong>Fullname:</strong> " . $officer['fullname'] . "</p>";
                        echo "<p><strong>Course:</strong> " . $officer['course'] . "</p>";
                        echo "<p><strong>Year Section:</strong> " . $officer['year_section'] . "</p>";
                        echo "<p><strong>Position:</strong> " . $officer['position'] . "</p>";
                    } else {
                        echo "<p>No officer found with the provided ID.</p>";
                    }
                } else {
                    echo "<p>No officer ID provided.</p>";
                }
                ?>

            </div>
            <!-- End of Main Content -->

            