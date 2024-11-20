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


        <?php

// Query to count requests in `message_request_tbl`
$request_count_query = "SELECT COUNT(*) AS request_count FROM message_request_tbl WHERE status = 'Request'";
$result = mysqli_query($connection, $request_count_query);
$row = mysqli_fetch_assoc($result);

// If there's a result, set the count; otherwise, default to 0
$request_count = $row['request_count'] ?? 0;


        ?>
        <a class="nav-link" href="message_request_table.php">
        <i class="fas fa-fw fa-envelope"></i>
        <span>Notification</span>    <?php if ($request_count > 0): ?>
        <span class="badge badge-pill badge-danger"><?php echo $request_count; ?></span>
    <?php endif; ?>
</a>



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
            <h6 class="collapse-header">Patient:</h6>
            <a class="collapse-item" href="student_registration_page.php">Student Registration</a>
            <a class="collapse-item" href="student_information_page_data.php">Student Data</a>
            <a class="collapse-item" href="student_medical_records.php">Student Medical Records</a>
            <a class="collapse-item" href="archived_students_data.php">Archive Student</a>
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
            <a class="collapse-item" href="staff_information_page_data.php">Staff Data</a>
            <a class="collapse-item" href="staff_medical_records.php">Medical Records</a>

        </div>
    </div>
</li>





<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#itemData"
        aria-expanded="true" aria-controls="itemData">
        <i class="fa fa-file-image-o" aria-hidden="true"></i>
        <span>Medicine  Management</span>
    </a>
    <div id="itemData" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Inventory Management</span>
            </a>:</h6>
            <a class="collapse-item" href="admin_medicine_registration.php">Medicine and Supplies</a>
            <a class="collapse-item" href="admin_med_stock.php">Stock Levels</a>
            <a class="collapse-item" href="admin_reorder_list.php">Medicine Logs</a>

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
            <a class="collapse-item" href="student_report_page.php">Student Report</a>
            <a class="collapse-item" href="clinic_report_page.php">Clinic Management Report</a>
            <a class="collapse-item" href="medicine_report_page.php">Medicine Data Report</a>

        </div>
    </div>
</li>





    <!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>

</ul>