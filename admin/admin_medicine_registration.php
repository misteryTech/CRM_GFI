<?php
include("admin_header.php");
include("../include/connection.php");
session_start(); // Ensure session is started to use session variables
?>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php include("admin_sidebar.php"); ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php include("admin_topbar.php"); ?>

                <div class="container mt-5 mb-5">
                    <!-- Display Success or Error Messages -->
                    <?php if (isset($_SESSION['success'])): ?>
                        <div class="alert alert-success">
                            <?php
                            echo $_SESSION['success'];
                            unset($_SESSION['success']); // Clear success message after displaying
                            ?>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger">
                            <?php
                            echo $_SESSION['error'];
                            unset($_SESSION['error']); // Clear error message after displaying
                            ?>
                        </div>
                    <?php endif; ?>

                    <!-- Medicine Registration Form -->
                    <h2>Medicine Registration Form</h2>
                    <form action="process_code/medicine_registration.php" method="POST">
                        <!-- Medicine Information -->
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-md-6">
                                    <label for="medicineName">Medicine Name</label>
                                    <input type="text" class="form-control" id="medicineName" name="medicine_name" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="brandName">Brand Name</label>
                                    <input type="text" class="form-control" id="brandName" name="brand_name" required>
                                </div>
                            </div>
                            <div class="form-row mt-3">
                                <div class="col-md-6">
                                    <label for="medicineType">Medicine Type</label>
                                    <select class="form-control" id="medicineType" name="medicine_type" required>
                                        <option value="Tablet">Tablet</option>
                                        <option value="Capsule">Capsule</option>
                                        <option value="Liquid">Liquid</option>
                                        <option value="Injection">Injection</option>
                                        <option value="Ointment">Ointment</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="expiryDate">Expiry Date</label>
                                    <input type="date" class="form-control" id="expiryDate" name="expiry_date" required>
                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <label for="manufacturer">Manufacturer</label>
                                <input type="text" class="form-control" id="manufacturer" name="manufacturer" required>
                            </div>
                            <div class="form-row mt-3">
                                <div class="col-md-6">
                                    <label for="stock">Stock</label>
                                    <input type="number" class="form-control" id="stock" name="stock" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="reorder">Reorder Point</label>
                                    <input type="number" class="form-control" id="reorder" name="reorder" required>
                                </div>
                            </div>
                        </div>

                        <!-- Dosage Information -->
                        <div class="form-group mt-4">
                            <h3>Dosage Information</h3>
                            <div class="form-row">
                                <div class="col-md-4">
                                    <label for="dosage">Dosage (mg/ml)</label>
                                    <input type="text" class="form-control" id="dosage" name="dosage" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="frequency">Frequency</label>
                                    <input type="text" class="form-control" id="frequency" name="frequency" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="duration">Duration (days)</label>
                                    <input type="text" class="form-control" id="duration" name="duration" required>
                                </div>
                            </div>
                        </div>


                        <button type="submit" class="btn btn-success">Register Medicine</button>
                    </form>
                </div>
            </div>
            <!-- End of Main Content -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <?php include("admin_footer.php"); ?>
</body>
