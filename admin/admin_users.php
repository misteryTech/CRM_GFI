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
            <form id="studentForm" method="POST">
                <div class="modal-body">
                    
                    <div class="row align-form-elements">
                        <div class="col">
                            <div class="mb-3">
                                <label for="firstname" class="form-label">Firstname</label>
                                <input type="text" class="form-control" id="firstname" name="firstname" required>
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="lastname" class="form-label">Lastname</label>
                                <input type="text" class="form-control" id="lastname" name="lastname" required>
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="username" class="form-label">User Name</label>
                                <input type="text" class="form-control" id="username" name="username">
                            </div>
                        </div>
                    </div>
                    <div class="row align-form-elements">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                    <label for="srole" class="form-label">Role</label>
                        <select class="form-select" id="role" name="role" required>
                            <option value="">Select Role</option>
                            <option value="Admin">Admin</option>
                            <option value="Officer">Officer</option>
                        </select>
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

// Check if the form is submitted for adding a new officer
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $firstname = $_POST['firstname'];
  $lastname = $_POST['lastname'];
  $username = $_POST['username'];
  $password = $_POST['password'];
  $role = $_POST['role'];


  // Perform the database insertion operation
  $query = "INSERT INTO users (firstname, lastname, username, password, role) 
  VALUES ('$firstname', '$lastname', '$username', '$password, $role')";
  $result = mysqli_query($connection, $query);

  if ($result) {
    echo "<div class='alert alert-success'>User added successfully.</div>";
  } else {
    echo "<div class='alert alert-danger'>Error: Failed to add user.</div>";
  }
}
?>

<div class="table-responsive">
  <table class="table table-bordered table-hover table-light">
    <thead class="thead-light">
      <tr>
        <th>Fullname</th>
        <th>Username</th>
        <th>Password</th>
        <th>Role</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php
      // Fetch officer data from the database
      $query = "SELECT * FROM users";
      $result = mysqli_query($connection, $query);

      // Check if any users are found
      if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {

          $fullname = $row["firstname"]." ".$row["lastname"];
          echo "<tr>";
          echo "<td>". $fullname ."</td>";
          echo "<td>" . $row['username'] . "</td>";
          echo "<td>" . $row['password'] . "</td>";
          echo "<td>" . $row['role'] . "</td>";

         
          echo "<td class='text-center'>";
          echo "<a href='admin_view_user.php?user_id=" . $row['user_id'] . "' class='btn btn-info btn-sm mr-1'><i class='fas fa-eye'></i></a>";
          echo "<a href='admin_edit_process.php?user_id=" . $row['user_id'] . "' class='btn btn-primary btn-sm mr-1'><i class='fas fa-edit'></i></a>";
          echo "<a href='admin_delete_user.php?user_id=" . $row['user_id'] . "' class='btn btn-danger btn-sm'><i class='fas fa-trash-alt'></i></a>";
          echo "</td>";
          echo "</tr>";
        }
      } else {
        echo "<tr><td colspan='6'>No Users found.</td></tr>";
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
           