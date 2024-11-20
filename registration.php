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


.validation{
    color: red;
    font-size: 25px;
}

.card {
  margin-top: 50px;
}

.form-row .form-group {
  padding-right: 15px;
  padding-left: 15px;
}
</style>

<body class="bg-gfi-school">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg">
                    <div class="card-body p-4">
                        <div class="text-center">
                            <h1 class="h5 text-gray-900 mb-4">Registration</h1>
                        </div>
                        <?php
                        if (isset($_SESSION['error'])) {
                            echo "<div class='alert alert-danger'>" . $_SESSION['error'] . "</div>";
                            unset($_SESSION['error']);
                        }
                        if (isset($_SESSION['success'])) {
                            echo "<div class='alert alert-success'>" . $_SESSION['success'] . "</div>";
                            unset($_SESSION['success']);
                        }
                        ?>
                        
                        <!-- Registration Type Selector -->
                        <div class="form-group text-center">
                            <label for="registrationType">Select Registration Type:</label>
                            <select id="registrationType" class="form-control" style="width: 200px; margin: 0 auto;">
                                <option value="student">Student</option>
                                <option value="staff">Staff</option>
                            </select>
                        </div>

                        <!-- Student Registration Form -->
                            <form id="studentForm" action="student_registration.php" method="POST" enctype="multipart/form-data" style="display: block;">
                                <h3>Student Registration</h3>
                                <!-- Student Information -->
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-md-6">
                                        <label for="studentId">Student Id  <span class="validation">*</span></label>
                                        <input type="text" class="form-control" id="studentId" name="student_id" onblur="checkStudentId()" required>

                                    <span id="studentIdError" style="color:green; display:none;">Complete Registration!</span>
                                    <span id="studentIdAvail" style="color:red; display:none;">You are not Registered in clinic!</span>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="username">Username <span class="validation">*</span></label>
                                            <input type="text" class="form-control" id="username" name="username" disabled required>

                                        </div>
                                        <div class="col-md-6">
    <label for="password">Password <span class="validation">*</span></label>
    <div class="input-group">
    <input type="password" class="form-control" id="password" name="password" oninput="passwordValidation()" required>
    <span class="input-group-addon" style="cursor: pointer;" onclick="togglePasswordVisibility('password', 'passwordToggle')">
        <i class="fas fa-eye-slash" id="passwordToggle"></i> <!-- Toggle Icon -->
    </span>
    <div id="passwordError" class="text-danger" style="display: none;">Password must be at least 5 characters long.</div>
</div>

</div>




<!-- Validation Error Messages -->



                                    </div>
                             
                                </div>

                    
                                <button type="submit" class="btn btn-success" >Register</button>
                            </form>

                        <!-- Staff Registration Form -->
                    
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
// Function to toggle the visibility of the password input field
function togglePasswordVisibility(inputId, iconId) {
    var inputField = document.getElementById(inputId);
    var icon = document.getElementById(iconId);
    var type = inputField.type === "password" ? "text" : "password"; // Toggle between text and password
    inputField.type = type;

    // Toggle the eye icon based on the visibility type
    if (type === "text") {
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    } else {
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
    }
}

// Function to validate the password length
function passwordValidation() {
    var password = document.getElementById("password").value;
    var passwordError = document.getElementById("passwordError");

    // Check if the password length is less than 5 characters
    if (password.length < 5) {
        passwordError.style.display = "block"; // Show error message
        document.getElementById("password").style.borderColor = "red"; // Red border for password
    } else {
        passwordError.style.display = "none"; // Hide error message
        document.getElementById("password").style.borderColor = "green"; // Green border for password
    }
}



// Additional password validation (optional) for minimum length or other criteria
function checkPassword() {
    var password = document.getElementById("password").value;
    var passwordError = document.getElementById("passwordError");

    // Example: Check if the password is at least 8 characters long
    if (password.length < 8) {
        passwordError.style.display = "block"; // Show error message
        document.getElementById("password").style.borderColor = "red"; // Red border for password
    } else {
        passwordError.style.display = "none"; // Hide error message
        document.getElementById("password").style.borderColor = "green"; // Green border for password
    }
}


function checkStudentId() {
    var studentId = document.getElementById('studentId').value.trim(); // Get input value and trim whitespace

    if (!studentId) {
        // Reset validation if input is empty
        resetStudentIdValidation();
        return;
    }

    // AJAX call to validate Student ID
    $.ajax({
        url: "validation/check_student_id.php", // Update with your correct path
        method: "POST",
        data: { student_id: studentId },
        success: function (response) {
            var data = JSON.parse(response);  // Assuming the response is in JSON format
            if (data.status === "exists") {
                // If the student ID exists, proceed to registration
                $("#studentIdError").hide();
                $("#studentIdAvail").show().html('Student ID found! Proceeding with registration.');
                $("button[type='submit']").prop('disabled', false); // Enable button

                // Apply green border and text color to the input field
                $("#studentId").css({
                    'border-color': 'green', // Green border for valid ID
                    'color': 'green'         // Green text color for input field
                });

                $("#studentIdAvail").css('color', 'green');

                // Set the username field with the returned username from the server
                $("#username").val(data.username); // Auto-fill the username field

            } else if (data.status === "available") {
                // If the student ID is not found, prompt to walk-in registration
                $("#studentIdError").show().html('Student ID not found! Please proceed to walk-in clinic registration.');
                $("#studentIdAvail").hide();
                $("button[type='submit']").prop('disabled', true); // Disable button
                $("#studentId").css('border-color', 'red'); // Red border for unavailable ID
                
                // Optionally, offer a prompt to redirect to walk-in registration
                if (confirm("Student ID not found. Do you want to proceed to walk-in clinic registration?")) {
                    window.location.href = "clinic-schedule.php"; // Replace with the correct URL
                }
            } else {
                // Handle unexpected response
                alert("Unexpected response from server: " + response);
                resetStudentIdValidation();
            }
        },
        error: function () {
            // Handle AJAX error
            alert("Error occurred while validating the Student ID.");
            resetStudentIdValidation();
        }
    });
}

// Reset Validation Function
function resetStudentIdValidation() {
    $("#studentIdError").hide();
    $("#studentIdAvail").hide();
    $("button[type='submit']").prop('disabled', true); // Disable button by default
    $("#studentId").css('border-color', '');
    $("#username").val(''); // Clear the username field
}

// Handle registration type selection
document.getElementById('registrationType').addEventListener('change', function() {
    const studentForm = document.getElementById('studentForm');
    const staffForm = document.getElementById('staffForm');
    if (this.value === 'student') {
        studentForm.style.display = 'block';
        staffForm.style.display = 'none';
    } else {
        studentForm.style.display = 'none';
        staffForm.style.display = 'block';
    }
});

    </script>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
</body>
</html>
