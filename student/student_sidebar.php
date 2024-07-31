<?php

include("student_header.php");
include("../include/connection.php");

// Check if student is logged in
if (!isset($_SESSION['student_id'])) {
    $_SESSION['error'] = "You must be logged in to view this page.";
    header("Location: ../login.php");
    exit();
}

// Get student ID from session
$id = $_SESSION['id'];
$student_username = $_SESSION['username'];

// Query to fetch organization name based on student ID from registrations table
$query = "
    SELECT r.organization_name
    FROM registrations r
    WHERE r.student_id = '$id'
";
$result = mysqli_query($connection, $query);

// Fetch the organization name if available
$organization_name = '';
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $organization_name = $row['organization_name'];
}

?>

<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="student_dashboard.php">
        <div class="sidebar-brand-icon">
            <i class="fas fa-user"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Student Org<sup><br>Manage System</sup>   <?php echo $student_username; ?>   </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="student_dashboard.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Nav Item - Account Details -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#accountData"
           aria-expanded="true" aria-controls="accountData">
            <i class="fa fa-file-image-o" aria-hidden="true"></i>
            <span>Account Details</span>
        </a>
        <div id="accountData" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Account:</h6>
                <a class="collapse-item" href="student_information_details.php">Account Settings</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Nav Item - Events Gallery -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
           aria-expanded="true" aria-controls="collapseTwo">
            <i class="fa fa-file-image-o" aria-hidden="true"></i>
            <span>Events Gallery</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Events:</h6>
                <a class="collapse-item" href="student_gallery_events_page.php">View Gallery</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Organization Details -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
           aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Organization Details</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Organization Details:</h6>
                <a class="collapse-item" href="student_organization_view.php?id=<?php echo $organization_name; ?>">
                    View Organization
            </div>
        </div>
    </li>

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
