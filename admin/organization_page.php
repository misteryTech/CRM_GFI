<?php
include("admin_header.php");
session_start();
include("../include/connection.php");
// Fetch all student names from the database
$query = "SELECT id, first_name, last_name FROM students";
$result = mysqli_query($connection, $query);

// Fetch organization names that haven't been registered yet
$orgQuery = "SELECT DISTINCT organization_name,id FROM organizations";
$orgResult = mysqli_query($connection, $orgQuery);


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
                <div class="container mt-5">
                    <h2 class="mb-4">Register for a School Organization</h2>
                    <?php
                    if (isset($_SESSION['message'])) {
                        echo "<div class='alert {$_SESSION['message_type']}' role='alert'>{$_SESSION['message']}</div>";
                        unset($_SESSION['message']);
                        unset($_SESSION['message_type']);
                    }
                    ?>

                    <form action="process_code/organization_registration.php" method="POST">
                        <div class="form-group">
                            <label for="studentName">Student Name</label>
                            <select class="form-control" id="studentName" name="studentName" required>
                                <option value="" disabled selected>Select a student</option>
                                <?php
                                // Populate the dropdown with student names
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<option value='" . $row['id'] . "'>" . $row['first_name'] . " " . $row['last_name'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="studentEmail">Email</label>
                            <input type="email" class="form-control" id="studentEmail" name="studentEmail" required>
                        </div>
                        <div class="form-group">
                            <label for="studentPhone">Phone Number</label>
                            <input type="text" class="form-control" id="studentPhone" name="studentPhone" required>
                        </div>
                        <div class="form-group">
                            <label for="studentGrade">Grade</label>
                            <select class="form-control" id="studentGrade" name="studentGrade" required>
                                <option value="9">9th Grade</option>
                                <option value="10">10th Grade</option>
                                <option value="11">11th Grade</option>
                                <option value="12">12th Grade</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="orgName">Organization Name</label>
                            <select class="form-control" id="orgName" name="orgName" required>
                                <option value="" disabled selected>Select an organization</option>
                                <?php
                                // Populate the dropdown with organization names
                                while ($row = mysqli_fetch_assoc($orgResult)) {
                                    echo "<option value='" . $row['id'] . "'>" . $row['organization_name'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="orgType">Organization Type</label>
                            <select class="form-control" id="orgType" name="orgType" required>
                                <option value="" disabled selected>Select an organization type</option>
                                <option value="Academic">Academic</option>
                                <option value="Sports">Sports</option>
                                <option value="Arts">Arts</option>
                                <option value="Community Service">Community Service</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="role">Role in Organization</label>
                            <select class="form-control" id="role" name="role" required>
                                <option value="" disabled selected>Select a role</option>
                                <option value="President">President</option>
                                <option value="Vice President">Vice President</option>
                                <option value="Secretary">Secretary</option>
                                <option value="Treasurer">Treasurer</option>
                                <option value="Member">Member</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="personalStatement">Personal Statement</label>
                            <textarea class="form-control" id="personalStatement" name="personalStatement" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit Registration</button>

                    </form>
                </div>

            </div>
            <!-- End of Main Content -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->



    <?php
    include("admin_footer.php");
    ?>
