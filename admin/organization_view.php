<?php
include("admin_header.php");
session_start();
include("../include/connection.php");

if (isset($_GET['id'])) {
    $organization_id = mysqli_real_escape_string($connection, $_GET['id']);

    // Fetch organization information
    $orgQuery = "SELECT * FROM organizations WHERE id = '$organization_id'";
    $orgResult = mysqli_query($connection, $orgQuery);
    $organization = mysqli_fetch_assoc($orgResult);

    // Fetch registered students for the organization ordered by role
    $query = "
        SELECT students.*, registrations.role
        FROM students
        INNER JOIN registrations ON students.id = registrations.student_id
        WHERE registrations.organization_name = '$organization_id'
        ORDER BY
            CASE
                WHEN registrations.role = 'President' THEN 1
                WHEN registrations.role = 'Vice President' THEN 2
                WHEN registrations.role = 'Secretary' THEN 3
                WHEN registrations.role = 'Treasurer' THEN 4
                ELSE 5
            END
    ";
    $result = mysqli_query($connection, $query);

    // Fetch events associated with the organization including the image path
    $eventsQuery = "SELECT id, title, description, date, image_path FROM events WHERE organization_id = '$organization_id'";
    $eventsResult = mysqli_query($connection, $eventsQuery);
} else {
    $_SESSION['error'] = "Invalid request.";
    header("Location: admin_page.php");
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

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Organization Details</h6>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                            <?php if (!empty($organization['logo'])): ?>
                        <div class="text-center mb-3">
                            <img src="uploads/<?php echo $organization['logo']; ?>" class="img-fluid rounded" alt="Organization Photo" style="max-width: 250px;">
                        </div>
                    <?php else: ?>
                        <div class="text-center mb-3">
                            <p>No photo available.</p>
                        </div>
                    <?php endif; ?>

                                <tr>
                                    <th>Organization Id</th>
                                    <td><?php echo $organization['id']; ?></td>
                                </tr>
                                <tr>
                                    <th>Organization Name</th>
                                    <td><?php echo $organization['organization_name']; ?></td>
                                </tr>
                                <tr>
                                    <th>Department</th>
                                    <td><?php echo $organization['department']; ?></td>
                                </tr>
                                <tr>
                                    <th>Advisor Name</th>
                                    <td><?php echo $organization['advisor_name']; ?></td>
                                </tr>

                            </table>

                            <hr>

                            <h3>List of Officers</h3>

                            <table class="table table-bordered" id="studentTable" width="100%" cellspacing="0">

                            <thead>
                                        <tr>
                                            <th>Student Id</th>
                                            <th>Username</th>
                                            <th>Firstname</th>
                                            <th>Lastname</th>
                                            <th>Role</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        // Loop through each row of the result set
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo "<tr>";
                                            echo "<td>" . $row['student_id'] . "</td>";
                                            echo "<td>" . $row['username'] . "</td>";
                                            echo "<td>" . $row['first_name'] . "</td>";
                                            echo "<td>" . $row['last_name'] . "</td>";
                                            echo "<td>" . $row['role'] . "</td>";
                                            echo "</tr>";
                                        }
                                        ?>
                                    </tbody>
                                    </table>

                            <br>

                            <hr>

                            <h3>List of Activities</h3>


    <?php
                            if (mysqli_num_rows($eventsResult) > 0) {
                                echo "<div class='row'>";
                                while ($event = mysqli_fetch_assoc($eventsResult)) {
                                    echo "<div class='col-md-4 mb-4'>";
                                    echo "<div class='card'>";
                                    echo "<img class='card-img-top' src='{$event['image_path']}' alt='Event Image'>";
                                    echo "<div class='card-body'>";
                                    echo "<h5 class='card-title'>{$event['title']}</h5>";
                                    echo "<p class='card-text'>{$event['description']}</p>";
                                    echo "<p class='card-text'>{$event['date']}</p>";
                                    echo "</div>";
                                    echo "</div>";
                                    echo "</div>";
                                }
                                echo "</div>";
                            } else {
                                echo "<p>No events found for this organization.</p>";
                            }
                            ?>

                            <a href="view_organization_reg_page.php" class="btn btn-secondary">Back</a>
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
