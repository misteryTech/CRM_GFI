<?php
session_start();
include("include/connection.php");
include("header.php");
?>

<style>

.bg-gfi-school {
  background-color: #FB0601;
  background-image: linear-gradient(180deg, #FC9C8A 10%, #FB0601 100%);
  background-size: cover;
}
.bg-login-image {
  background: url("PICTURE/clinic_picture.png");
  background-position: center;
  background-size: contain;
  background-repeat: no-repeat;
}

/* this is comment */

</style>
<body class="bg-gfi-school">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-7 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-5">
                                <div class="p-4">
                                    <div class="text-center">
                                        <h1 class="h5 text-gray-900 mb-7">GFI CLINIC MANAGEMENT SYSTEM</h1>
                                    </div>
                                    <?php
                                    if (isset($_SESSION['error'])) {
                                        echo "<div class='alert alert-danger'>" . $_SESSION['error'] . "</div>";
                                        unset($_SESSION['error']);
                                    }
                                    ?>
                                    <form action="student_login_process.php" method="post" class="user">
                                        <div class="form-group">
                                            <input type="text" name="username" class="form-control form-control-user" id="exampleInputUsername" placeholder="Username" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password" required>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox big">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Remember Me</label>
                                            </div>
                                        </div>
                                        <input type="submit" name="submit" class="btn btn-danger btn-user btn-block" value="Login">
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="forgot-password.html">Forgot Password?</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
</body>
</html>
