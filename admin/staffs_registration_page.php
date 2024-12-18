<?php
include("admin_header.php");
session_start();
include("../include/connection.php");
?>

<body id="page-top" >

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php include("admin_sidebar.php"); ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php include("admin_topbar.php"); ?>

                <div class="container mt-5 mb-5">
                    <?php if (isset($_SESSION['success'])): ?>
                        <div class="alert alert-success">
                            <?php
                            echo $_SESSION['success'];
                            unset($_SESSION['success']);
                            ?>
                        </div>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger">
                            <?php
                            echo $_SESSION['error'];
                            unset($_SESSION['error']);
                            ?>
                        </div>
                    <?php endif; ?>

                    <h2>Staff Registration Form</h2>
                    <form action="process_code/staffs_registration.php" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <div class="form-row">
                                <!-- Staff ID -->
                                <div class="col-md-6">
                                    <label for="staffId">Staff ID</label>
                                    <input type="number" class="form-control" id="staffId" name="staff_id" required>
                                    <span id="staffIdError" style="color:red; display:none;">Staff ID already exists!</span>
                                    <span id="staffIdAvail" style="color:green; display:none;">Staff ID Available!</span>
                                </div>
                                <!-- Username -->
                                <div class="col-md-6">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control" id="username" name="username" required>
                                    <span id="usernameError" style="color:red; display:none;">Username already exists!</span>
                                    <span id="usernameAvail" style="color:green; display:none;">Username Available!</span>
                                </div>
                            </div>
                            <br>
                            <div class="form-row">
                                <!-- Email -->
                                <div class="col-md-6">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required>

                                    <span id="emailError" style="color:red; display:none;">Email already exists!</span>
                                    <span id="emailAvail" style="color:green; display:none;">Email Available!</span>
                                </div>
                            </div>
                        </div>
                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-success">Register</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include("admin_footer.php"); ?>

    <script>
        $(document).ready(function () {
            let isStaffIdValid = false;
            let isUsernameValid = false;
            let isEmailValid = false;

            let staffIdInput = $("#staffId");
            staffIdInput.val("1101"); // Initialize with a default staff ID prefix

            staffIdInput.on("input", function () {
                let currentVal = $(this).val().trim();
                if (currentVal.length < 1) {
                    currentVal = currentVal.padEnd(11, '0');
                } else if (currentVal.length > 11) {
                    currentVal = currentVal.substring(0, 11);
                }
                $(this).val(currentVal);
            });

            // Validate Staff ID
            $("#staffId").blur(function () {
                const staffId = $(this).val().trim();
                if (!staffId) {
                    resetStaffIdValidation();
                    return;
                }

                $.ajax({
                    url: "validation/check_staff_id.php",
                    method: "POST",
                    data: { staff_id: staffId },
                    success: function (response) {
                        if (response.trim() === "exists") {
                            showValidationMessage("#staffIdError", "#staffIdAvail", true);
                            isStaffIdValid = false;
                        } else if (response.trim() === "available") {
                            showValidationMessage("#staffIdAvail", "#staffIdError", false);
                            isStaffIdValid = true;
                        } else {
                            alert("Unexpected response. Please try again.");
                            resetStaffIdValidation();
                        }
                        toggleSubmitButton();
                    },
                    error: function () {
                        alert("Error checking Staff ID. Please try again.");
                        resetStaffIdValidation();
                    },
                });
            });


 // Validate Username on Blur (5 to 11 characters)
$("#username").blur(function () {
    const username = $(this).val().trim();

    // Check if the username is between 5 and 11 characters
    if (username.length < 5 || username.length > 11) {
        showValidationMessage("#usernameError", "#usernameAvail", true);
        $("#usernameError").html("Username must be between 5 and 11 characters.");
        isUsernameValid = false;
    } else {
        // AJAX Call to Validate Username
        $.ajax({
            url: "validation/check_staff_username.php", // Path to the PHP validation script
            method: "POST",
            data: { username: username },
            success: function (response) {
                if (response.trim() === "exists") {
                    showValidationMessage("#usernameError", "#usernameAvail", true);
                    $("#usernameError").html("Username already exists. Please choose another.");
                    isUsernameValid = false;
                } else if (response.trim() === "available") {
                    showValidationMessage("#usernameAvail", "#usernameError", false);
                    $("#usernameAvail").html("Username is available.");
                    isUsernameValid = true;
                } else if (response.trim() === "error") {
                    alert("An error occurred while checking the username. Please try again.");
                    resetUsernameValidation();
                } else {
                    alert("Unexpected response. Please contact support.");
                    resetUsernameValidation();
                }
                toggleSubmitButton();
            },
            error: function () {
                alert("Error connecting to the server. Please try again.");
                resetUsernameValidation();
            },
        });
    }
});


    // Validate Email on Blur
    $("#email").blur(function () {
        const email = $(this).val().trim();
        if (!email) {
            resetEmailValidation();
            return;
        }

        // AJAX Call to Validate Email
        $.ajax({
            url: "validation/check_staff_email.php", // Update with your actual PHP path
            method: "POST",
            data: { email: email },
            success: function (response) {
                if (response.trim() === "exists") {
                    showValidationMessage("#emailError", "#emailAvail", true);
                    isEmailValid = false;
                } else if (response.trim() === "available") {
                    showValidationMessage("#emailAvail", "#emailError", false);
                    isEmailValid = true;
                } else {
                    alert("Unexpected response. Please try again.");
                    resetEmailValidation();
                }
                toggleSubmitButton();
            },
            error: function () {
                alert("Error checking email. Please try again.");
                resetEmailValidation();
            },
        });
    });

    


            // The rest remains the same as the student code
            function resetStaffIdValidation() {
                $("#staffIdError").hide();
                $("#staffIdAvail").hide();
                $("#staffId").css("border-color", "");
                isStaffIdValid = false;
                toggleSubmitButton();
            }

            function showValidationMessage(showId, hideId, isError) {
                $(hideId).hide();
                $(showId).show();
                $(showId).css("border-color", isError ? "red" : "green");
            }

            function toggleSubmitButton() {
                if (isStaffIdValid && isUsernameValid && isEmailValid) {
                    $("button[type='submit']").prop("disabled", false);
                } else {
                    $("button[type='submit']").prop("disabled", true);
                }
            }
        });
    </script>
</body>
