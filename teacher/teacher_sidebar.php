<ul class="navbar-nav bg-gfi-school sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="student_dashboard.php">
    <div class="sidebar-brand-icon ">
        <i class="fas fa-user"></i>
    </div>
    <div class="sidebar-brand-text mx-3">Clinic Management<sup><br></sup></div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item">
    <a class="nav-link" href="student_dashboard.php">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>

        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#accountData"
        aria-expanded="true" aria-controls="accountData">
        <i class="fa fa-file-image-o" aria-hidden="true"></i>
        <span>Account Details</span>
    </a>
            <div id="accountData" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Account:</h6>
                    <a class="collapse-item" href="account_details_page.php">Account Settings</a>
                </div>
            </div>



</li>
<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#studentData"
        aria-expanded="true" aria-controls="studentData">
        <i class="fa fa-file-image-o" aria-hidden="true"></i>
        <span>Student Management</span>
    </a>
    <div id="studentData" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Students:</h6>
        <a class="collapse-item" href="student_information_page_data.php">Students Data</a>
        <a class="collapse-item" href="student_medical_records.php">Medical Records</a>

        </div>
    </div>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

    <!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>

</ul>