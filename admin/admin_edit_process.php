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


                <?php 
  $localhost= "localhost";
  $username= "root";
  $password= "";
  $dbname= "soms_db";

  $connection = mysqli_connect($localhost,$username,$password,$dbname);

  if($_SERVER["REQUEST_METHOD"]== "POST"){
        if(isset($_POST["edit_btn"])){

                $user_id = $_POST["user_id"];
        
                
                        $sql_select = "SELECT * FROM users_info WHERE user_id = $user_id ";
                        
                        $sql_result = $connection->query($sql_select);
                
                        if($sql_result->num_rows > 0){
                                $row = $sql_result->fetch_assoc();
                                $firstname = $row['firstname'];
                                $lastname = $row['lastname'];
                                $username = $row['username'];
                                $password = $row['password'];
                                $role = $row['role'];
                        }else{
                                echo "<script> Alert('User Not Found!'</script> ";
                        }
              }
  }
             
?>

        
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
                    <div class="mb-3">
                        <label for="studentId" class="form-label">Student ID</label>
                        <input type="text" class="form-control" id="studentId" name="studentId" required>
                    </div>
                    <div class="row align-form-elements">
                        <div class="col">
                            <div class="mb-3">
                                <label for="studentSurname" class="form-label">Firstname</label>
                                <input type="text" class="form-control" id="studentSurname" name="studentSurname" required>
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="studentFirstName" class="form-label">Lastname</label>
                                <input type="text" class="form-control" id="studentFirstName" name="studentFirstName" required>
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="studentMiddleName" class="form-label">User Name</label>
                                <input type="text" class="form-control" id="studentMiddleName" name="studentMiddleName">
                            </div>
                        </div>
                    </div>
                    <div class="row align-form-elements">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="studentAge" class="form-label">Password</label>
                                <input type="number" class="form-control" id="studentAge" name="studentAge" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                    <label for="studentSex" class="form-label">Role</label>
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




                    <!-- Content Row -->
                    <div class="row">

                        <!-- Content Column -->
                        <div class="col-lg-6 mb-4">

                 

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

         