<?php
include("../include/connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = $_POST['id'];
  $fullname = $_POST['fullname'];
  $course = $_POST['course'];
  $year_section = $_POST['year_section'];
  $position = $_POST['position'];

  // Perform the database update operation
  $query = "UPDATE officers SET fullname='$fullname', course='$course', year_section='$year_section', position='$position' WHERE id='$id'";
  $result = mysqli_query($connection, $query);

  if ($result) {
    echo "<div class='alert alert-success'>Officer updated successfully.</div>";
  } else {
    echo "<div class='alert alert-danger'>Error: Failed to update officer.</div>";
  }
}

// Retrieve the officer's details based on the ID
if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $query = "SELECT * FROM officers WHERE id='$id'";
  $result = mysqli_query($connection, $query);
  $officer = mysqli_fetch_assoc($result);
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Officer</title>
</head>
<body>
  <?php include("admin_header.php"); ?>

  <body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

      <?php include("admin_sidebar.php"); ?>

      <!-- Content Wrapper -->
      <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

          <?php include("admin_topbar.php"); ?>

          <!-- Begin Page Content -->
          <div class="container-fluid">

            <h3>Edit Officer</h3>

            <form action="admin_edit_officer.php" method="post">
              <input type="hidden" name="id" value="<?php echo $officer['id']; ?>">

              <label for="fullname">Fullname</label>
              <input type="text" name="fullname" id="fullname" value="<?php echo $officer['fullname']; ?>" required><br>

              <label for="course">Course</label>
              <input type="text" name="course" id="course" value="<?php echo $officer['course']; ?>" required><br>

              <label for="year_section">Year Section</label>
              <input type="text" name="year_section" id="year_section" value="<?php echo $officer['year_section']; ?>" required><br>

              <label for="position">Position</label>
              <input type="text" name="position" id="position" 
              value="<?php echo $officer['position']; ?>" required><br><br>

              <button type="submit" class="btn btn-primary">Update Officer</button>
            </form>

          </div>
          <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

      </div>
      <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->
  </body>
</html>