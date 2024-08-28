<ul class="navbar-nav bg-gfi-school sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="admin_dashboard.php">
    <div class="sidebar-brand-icon ">
        <i class="fas fa-user"></i>
    </div>
    <div class="sidebar-brand-text mx-3">Clinic Management<sup><br></sup></div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item">
    <a class="nav-link" href="admin_dashboard.php">
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

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
    Interface
</div>
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
            <a class="collapse-item" href="student_registration_page.php">Student Registration</a>
            <a class="collapse-item" href="student_information_page_data.php">Students Data</a>
            <a class="collapse-item" href="student_information_page_data.php">Appointment Scheduling</a>
            <a class="collapse-item" href="student_information_page_data.php">Medical Records</a>

        </div>
    </div>
</li>


<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#staffData"
        aria-expanded="true" aria-controls="staffData">
        <i class="fa fa-file-image-o" aria-hidden="true"></i>
        <span>Staff Management</span>
    </a>
    <div id="staffData" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Staff Management</span>
            </a>:</h6>
            <a class="collapse-item" href="staff_registration_page.php">Staff Registration</a>
            <a class="collapse-item" href="#">Staff Data</a>
            <a class="collapse-item" href="#">Medical Records</a>

        </div>
    </div>
</li>


<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#teacherData"
        aria-expanded="true" aria-controls="teacherData">
        <i class="fa fa-file-image-o" aria-hidden="true"></i>
        <span>Teacher Management</span>
    </a>
    <div id="teacherData" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Teacher Management</span>
            </a>:</h6>
            <a class="collapse-item" href="teacher_registration_page.php">Teacher Registration</a>
            <a class="collapse-item" href="#">Teacher Data</a>
            <a class="collapse-item" href="#">Medical Records</a>

        </div>
    </div>
</li>





<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#itemData"
        aria-expanded="true" aria-controls="itemData">
        <i class="fa fa-file-image-o" aria-hidden="true"></i>
        <span>Inventory  Management</span>
    </a>
    <div id="itemData" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Inventory Management</span>
            </a>:</h6>
            <a class="collapse-item" href="admin_medicine_registration.php">Medicine and Supplies</a>
            <a class="collapse-item" href="admin_med_stock.php">Stock Levels</a>
            <a class="collapse-item" href="admin_reorder_stock.php">Reordering</a>

        </div>
    </div>
</li>


<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#reportData"
        aria-expanded="true" aria-controls="reportData">
        <i class="fa fa-file-image-o" aria-hidden="true"></i>
        <span>Reports</span>
    </a>
    <div id="reportData" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Report Management</span>
            </a>:</h6>
            <a class="collapse-item" href="student_registration_page.php">Student Report</a>
            <a class="collapse-item" href="student_information_page_data.php">Inventory Report</a>

        </div>
    </div>
</li>





    <!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>

</ul>