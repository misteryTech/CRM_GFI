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
                    <button class="btn btn-primary" onclick="openAddUserModal()">Add New User</button>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <?php 
            include("admin_footer.php");
            ?> 

            <!-- Add User Modal -->
            <div id="addUserModal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeAddUserModal()">&times;</span>
                    <h5>Add New User</h5>
                    <form action="admin_process_user.php" method="post" class="user">
                        <div class="form-group">
                            <input type="text" name="firstname" class="form-control" placeholder="First Name" required>
                        </div>
                        <div class="form-group">
                            <input type="text" name="lastname" class="form-control" placeholder="Last Name" required>
                        </div>
                        <div class="form-group">
                            <input type="text" name="username" class="form-control" placeholder="Username" required>
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                        </div>
                        <div class="form-group">
                            <input type="text" name="role" class="form-control" placeholder="Role" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" onclick="closeAddUserModal()">Cancel</button>
                            <button type="submit" class="btn btn-primary" name="submit">Save</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- End of Add User Modal -->

            <script>
                function openAddUserModal() {
                    document.getElementById("addUserModal").style.display = "block";
                }

                function closeAddUserModal() {
                    document.getElementById("addUserModal").style.display = "none";
                }
            </script>
        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

</body>
</html>