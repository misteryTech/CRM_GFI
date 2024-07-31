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



<!-- Rest of your HTML content here -->
<!-- Add Student Button -->
<div class="container mt-3 text-right">
    <button class="btn btn-primary" data-toggle="modal" data-target="#studentModal">Add User</button>
</div>
<h4>USERS</h4>

<!-- Student Modal -->
<div class="modal fade" id="studentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>
            <form id="officerForm" method="POST">
                <div class="modal-body">
                    
                <div class="mb-3">
    <label for="fullname" class="form-label">Fullname</label>
    <input type="text" class="form-control" id="fullname" name="fullname" required>
</div>
<div class="mb-3">
    <label for="course" class="form-label">Course</label>
    <input type="text" class="form-control" id="course" name="course" required>
</div>
<div class="mb-3">
    <label for="year_section" class="form-label">Year & Section</label>
    <input type="text" class="form-control" id="year_section" name="year_section">
</div>
<div class="mb-3">
    <label for="position" class="form-label">Position</label>
    <input type="text" class="form-control" id="position" name="position" required>
</div>
                    
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Done</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Begin Page Content -->
<div class="container-fluid">

<?php 
include("../include/connection.php");

// Button for 

// Check if the form is submitted for adding a new officer
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $fullname = $_POST['fullname'];
  $course = $_POST['course'];
  $year_section = $_POST['year_section'];
  $position = $_POST['position'];

  // Perform the database insertion operation
  $query = "INSERT INTO officers (fullname, course, year_section, position) VALUES ('$fullname', '$course', '$year_section', '$position')";
  $result = mysqli_query($connection, $query);

  if ($result) {
    echo "<div class='alert alert-success'>Officer added successfully.</div>";
  } else {
    echo "<div class='alert alert-danger'>Error: Failed to add officer.</div>";
  }
}
?>

<div class="table-responsive">
  <table class="table table-bordered table-hover table-light">
    <thead class="thead-light">
      <tr>
        
        <th>Fullname</th>
        <th>Course</th>
        <th>Year & Section</th>
        <th>Position</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php
      // Fetch officer data from the database
      $query = "SELECT * FROM officers";
      $result = mysqli_query($connection, $query);

      // Check if any officers are found
      if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
          echo "<tr>";
        
          echo "<td>" . $row['fullname'] . "</td>";
          echo "<td>" . $row['course'] . "</td>";
          echo "<td>" . $row['year_section'] . "</td>";
          echo "<td>" . $row['position'] . "</td>";
          echo "<td class='text-center'>";
          echo "<a href='admin_view_officer.php?id=" . $row['id'] . "' class='btn btn-info btn-sm mr-1'><i class='fas fa-eye'></i></a>";
          echo "<a href='admin_edit_officer.php?id=" . $row['id'] . "' class='btn btn-primary btn-sm mr-1'><i class='fas fa-edit'></i></a>";
          echo "<a href='admin_delete_officer.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm'><i class='fas fa-trash-alt'></i></a>";
          echo "</td>";
          echo "</tr>";
        }
      } else {
        echo "<tr><td colspan='6'>No officers found.</td></tr>";
      }
      ?>
    </tbody>
  </table>
</div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <?php 
            include("admin_footer.php");
            ?>