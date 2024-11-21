<?php
include("admin_header.php");
session_start();
include("../include/connection.php");
?>

<body id="page-top" onload="generatePassword()">

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

                    <h2>Student Registration Form</h2>
                    <form action="process_code/student_registration.php" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <div class="form-row">
                                <!-- Student ID -->
                                <div class="col-md-6">
                                    <label for="studentId">Student ID</label>
                                    <input type="number" class="form-control" id="studentId" name="student_id" required>
                                    <span id="studentIdError" style="color:red; display:none;">Student ID already exists!</span>
                                    <span id="studentIdAvail" style="color:green; display:none;">Student ID Available!</span>
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

    <script>$(document).ready(function () {
    let isStudentIdValid = false;
    let isUsernameValid = false;
    let isEmailValid = false;

    // Initialize studentId to 2101 and ensure it's 7 digits long
    let studentIdInput = $("#studentId");
    studentIdInput.val("2101"); // Initialize with 2101

    // Automatically adjust the studentId to 7 digits when the user types
    studentIdInput.on("input", function () {
        let currentVal = $(this).val().trim();
        if (currentVal.length < 1) {
            currentVal = currentVal.padEnd(11, '0'); // Add trailing zeros if less than 7 digits
        } else if (currentVal.length > 11) {
            currentVal = currentVal.substring(0, 11); // Trim if more than 7 digits
        }
        $(this).val(currentVal); // Update the input value
    });

    // Validate Student ID on Blur
    $("#studentId").blur(function () {
        const studentId = $(this).val().trim();
        if (!studentId) {
            resetStudentIdValidation();
            return;
        }

        // AJAX Call to Validate Student ID
        $.ajax({
            url: "validation/check_student_id.php",
            method: "POST",
            data: { student_id: studentId },
            success: function (response) {
                if (response.trim() === "exists") {
                    showValidationMessage("#studentIdError", "#studentIdAvail", true);
                    isStudentIdValid = false;
                } else if (response.trim() === "available") {
                    showValidationMessage("#studentIdAvail", "#studentIdError", false);
                    isStudentIdValid = true;
                } else {
                    alert("Unexpected response. Please try again.");
                    resetStudentIdValidation();
                }
                toggleSubmitButton();
            },
            error: function () {
                alert("Error checking student ID. Please try again.");
                resetStudentIdValidation();
            },
        });
    });

    // Validate Username on Blur (11 characters and more than 4 characters)
    $("#username").blur(function () {
        const username = $(this).val().trim();
        
        // Check if username is at least 5 characters and exactly 11 characters
        if (username.length < 5 || username.length > 11) {
            showValidationMessage("#usernameError", "#usernameAvail", true);
            $("#usernameError").html("Username must be between 5 and 11 characters.");
            isUsernameValid = false;
        } else {
            // AJAX Call to Validate Username
            $.ajax({
                url: "validation/check_username.php", // Update with your actual PHP path
                method: "POST",
                data: { username: username },
                success: function (response) {
                    if (response.trim() === "exists") {
                        showValidationMessage("#usernameError", "#usernameAvail", true);
                        $("#usernameError").html("Username already exists.");
                        isUsernameValid = false;
                    } else if (response.trim() === "available") {
                        showValidationMessage("#usernameAvail", "#usernameError", false);
                        isUsernameValid = true;
                    } else {
                        alert("Unexpected response. Please try again.");
                        resetUsernameValidation();
                    }
                    toggleSubmitButton();
                },
                error: function () {
                    alert("Error checking username. Please try again.");
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
            url: "validation/check_email.php", // Update with your actual PHP path
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

    // Show Validation Message
    function showValidationMessage(showId, hideId, isError) {
        $(hideId).hide();
        $(showId).show();
        $(showId).css("border-color", isError ? "red" : "green");
    }

    // Reset Validation States
    function resetStudentIdValidation() {
        $("#studentIdError").hide();
        $("#studentIdAvail").hide();
        $("#studentId").css("border-color", "");
        isStudentIdValid = false;
        toggleSubmitButton();
    }

    function resetUsernameValidation() {
        $("#usernameError").hide();
        $("#usernameAvail").hide();
        $("#username").css("border-color", "");
        isUsernameValid = false;
        toggleSubmitButton();
    }

    function resetEmailValidation() {
        $("#emailError").hide();
        $("#emailAvail").hide();
        $("#email").css("border-color", "");
        isEmailValid = false;
        toggleSubmitButton();
    }

    // Toggle Submit Button Enable/Disable based on validation states
    function toggleSubmitButton() {
        if (isStudentIdValid && isUsernameValid && isEmailValid) {
            $("button[type='submit']").prop("disabled", false); // Enable submit button
        } else {
            $("button[type='submit']").prop("disabled", true); // Disable submit button
        }
    }
});


    </script>
</body>
