<?php
include("student_header.php");
include("../include/connection.php");



$student_id = $_SESSION['student_id'];
$username = $_SESSION['username'];




// Check if student is logged in
if (!isset($_SESSION['student_id'])) {
    $_SESSION['error'] = "You must be logged in to view this page.";
    header("Location: ../login_student.php");
    exit();
}

// Get student ID from session
$student_id = mysqli_real_escape_string($connection, $_SESSION['student_id']);

// Fetch student details from the database
$studentQuery = "SELECT * FROM students_table WHERE student_id = '$student_id'";
$studentResult = mysqli_query($connection, $studentQuery);

// Check if data was fetched successfully
if (mysqli_num_rows($studentResult) == 1) {
    $student = mysqli_fetch_assoc($studentResult);

    // Check for missing details
    $requiredFields = ['username', 'password', 'first_name', 'last_name', 'dob', 'gender', 'email', 'year', 'section', 'course'];
    $missingDetails = false;

    foreach ($requiredFields as $field) {
        if (empty($student[$field])) {
            $missingDetails = true;
            break;
        }
    }

    // Set a session error if details are missing
    if ($missingDetails) {
        $_SESSION['error'] = "Please complete your account details.";

    }
} else {
    // Student not found in the database
    $_SESSION['error'] = "Student record not found.";
    header("Location: ../login_student.php");
    exit();
}
?>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php
        include("student_sidebar.php");
        ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php
                include("student_topbar.php");
                ?>

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
                                
                                <h2>Account Details</h2>
                                <form action="process_code/account_details_updates.php" method="POST">
    <!-- Student Information -->
    <div class="form-group">
        <div class="form-row">
            <input type="hidden" name="archive" value="<?php echo $student['archive']; ?>">
            <div class="col-md-4">
                <label for="studentId">Student ID <span style="color: red;">*</span></label>
                <input type="text" class="form-control" id="studentId" name="student_id" value="<?php echo $student['student_id']; ?>" required readonly>
            </div>
            <div class="col-md-4">
                <label for="username">Username <span style="color: red;">*</span></label>
                <input type="text" class="form-control" id="username" name="username" value="<?php echo $student['username']; ?>" required>
            </div>
            <div class="col-md-4">
         
                <input type="hidden" class="form-control" id="password" name="password" value="<?php echo $student['password']; ?>" required>
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-4">
                <label for="firstName">First Name <span style="color: red;">*</span></label>
                <input type="text" class="form-control" id="firstName" name="first_name" value="<?php echo $student['first_name']; ?>" required>
            </div>
            <div class="col-md-4">
                <label for="lastName">Last Name <span style="color: red;">*</span></label>
                <input type="text" class="form-control" id="lastName" name="last_name" value="<?php echo $student['last_name']; ?>" required>
            </div>
            <div class="col-md-4">
                <label for="dob">Date of Birth <span style="color: red;">*</span></label>
                <input type="date" class="form-control" id="dob" name="dob" value="<?php echo $student['dob']; ?>" required>
            </div>

            <div class="col-md-4">
            <label for="gender">Gender <span style="color: red;">*</span></label>
            <select class="form-control" id="gender" name="gender" required>
                <option value="Male" <?php echo ($student['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                <option value="Female" <?php echo ($student['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
            </select>
            </div>


        </div>
      
    </div>

    <!-- Contact Details -->
    <div class="form-group">
        <h3>Contact Details</h3>
        <div class="form-row">
            <div class="col-md-6">
                <label for="email">Email <span style="color: red;">*</span></label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $student['email']; ?>" required>
            </div>
            <div class="col-md-6">
                <label for="phone">Phone Number <span style="color: red;">*</span></label>
                <input 
                    type="text" 
                    class="form-control" 
                    id="phone" 
                    name="phone" 
                    maxlength="11" 
                    value="<?php echo $student['phone']; ?>" 
                    pattern="\d{11}" 
                    title="Phone number must be 11 digits" 
                    oninput="this.value = this.value.replace(/[^0-9]/g, '')" 
                    required>
            </div>
        </div>
        <div class="form-group">
            <label for="street">Street <span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="street" name="street" value="<?php echo $student['street']; ?>" required>
        </div>
        <div class="form-group">
            <label for="barangay">Barangay <span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="barangay" name="barangay" value="<?php echo $student['barangay']; ?>" required>
        </div>
        <div class="form-group">
            <label for="municipality">Municipality <span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="municipality" name="municipality" value="<?php echo $student['municipality']; ?>" required>
        </div>
        <div class="form-group">
            <label for="province">Province <span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="province" name="province" value="<?php echo $student['province']; ?>" required>
        </div>
    </div>

    <!-- Course -->
    <div class="form-group">
        <h3>Course</h3>
        <div class="form-row">
            <div class="col-md-4">
                <label for="year">Year <span style="color: red;">*</span></label>
                <select class="form-control" id="year" name="year" required>
                    <option value="Grade 7" <?php echo ($student['year'] == 'Grade 7') ? 'selected' : ''; ?>>Grade 7</option>
                    <option value="Grade 8" <?php echo ($student['year'] == 'Grade 8') ? 'selected' : ''; ?>>Grade 8</option>
                    <option value="Grade 9" <?php echo ($student['year'] == 'Grade 9') ? 'selected' : ''; ?>>Grade 9</option>
                    <option value="Grade 10" <?php echo ($student['year'] == 'Grade 10') ? 'selected' : ''; ?>>Grade 10</option>
                    <option value="Grade 11" <?php echo ($student['year'] == 'Grade 11') ? 'selected' : ''; ?>>Grade 11</option>
                    <option value="Grade 12" <?php echo ($student['year'] == 'Grade 12') ? 'selected' : ''; ?>>Grade 12</option>
                    <option value="First Year" <?php echo ($student['year'] == 'First Year') ? 'selected' : ''; ?>>First Year</option>
                    <option value="Second Year" <?php echo ($student['year'] == 'Second Year') ? 'selected' : ''; ?>>Second Year</option>
                    <option value="Third Year" <?php echo ($student['year'] == 'Third Year') ? 'selected' : ''; ?>>Third Year</option>
                    <option value="Fourth Year" <?php echo ($student['year'] == 'Fourth Year') ? 'selected' : ''; ?>>Fourth Year</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="section">Section <span style="color: red;">*</span></label>
                <input type="text" class="form-control" id="section" name="section" value="<?php echo $student['section']; ?>" required>
            </div>
            <div class="col-md-4">
                <label for="course">Course / High School Department<span style="color: red;">*</span></label>
                <select class="form-control" id="course" name="course" required>
                    <option value="<?php echo $student['course']; ?>" selected><?php echo $student['course']; ?></option>
                    <option value="Junior HS">Junior HS</option>
                    <option value="Senior HS">Senior HS</option>
                    <option value="BS in Accountancy">BS in Accountancy</option>
                    <option value="𝐁𝐒 𝐢𝐧 𝐌𝐚𝐧𝐚𝐠𝐞𝐦𝐞𝐧𝐭 𝐀𝐜𝐜𝐨𝐮𝐧𝐭𝐢𝐧𝐠">𝐁𝐒 𝐢𝐧 𝐌𝐚𝐧𝐚𝐠𝐞𝐦𝐞𝐧𝐭 𝐀𝐜𝐜𝐨𝐮𝐧𝐭𝐢𝐧𝐠</option>
                     <option value="𝐁𝐚𝐜𝐡𝐞𝐥𝐨𝐫 𝐨𝐟 𝐒𝐞𝐜𝐨𝐧𝐝𝐚𝐫𝐲 𝐄𝐝𝐮𝐜𝐚𝐭𝐢𝐨𝐧">𝐁𝐚𝐜𝐡𝐞𝐥𝐨𝐫 𝐨𝐟 𝐒𝐞𝐜𝐨𝐧𝐝𝐚𝐫𝐲 𝐄𝐝𝐮𝐜𝐚𝐭𝐢𝐨𝐧</option>
                     <option value="𝐌𝐚𝐣𝐨𝐫 𝐢𝐧 𝐄𝐧𝐠𝐥𝐢𝐬𝐡 & 𝐌𝐚𝐭𝐡">𝐌𝐚𝐣𝐨𝐫 𝐢𝐧 𝐄𝐧𝐠𝐥𝐢𝐬𝐡 & 𝐌𝐚𝐭𝐡</option>
                     <option value="𝐁𝐚𝐜𝐡𝐞𝐥𝐨𝐫 𝐢𝐧 𝐏𝐡𝐲𝐬𝐢𝐜𝐚𝐥 𝐄𝐝𝐮𝐜𝐚𝐭𝐢𝐨𝐧">𝐁𝐚𝐜𝐡𝐞𝐥𝐨𝐫 𝐢𝐧 𝐏𝐡𝐲𝐬𝐢𝐜𝐚𝐥 𝐄𝐝𝐮𝐜𝐚𝐭𝐢𝐨𝐧</option>
                     <option value="𝐁𝐒 𝐢𝐧 𝐂𝐫𝐢𝐦𝐢𝐧𝐨𝐥𝐨𝐠𝐲">𝐁𝐒 𝐢𝐧 𝐂𝐫𝐢𝐦𝐢𝐧𝐨𝐥𝐨𝐠𝐲</option>
                     <option value="𝐁𝐒 𝐢𝐧 𝐎𝐟𝐟𝐢𝐜𝐞 𝐀𝐝𝐦𝐢𝐧𝐢𝐬𝐭𝐫𝐚𝐭𝐢𝐨𝐧">𝐁𝐒 𝐢𝐧 𝐎𝐟𝐟𝐢𝐜𝐞 𝐀𝐝𝐦𝐢𝐧𝐢𝐬𝐭𝐫𝐚𝐭𝐢𝐨𝐧</option>
                     <option value="𝐁𝐒 𝐢𝐧 𝐓𝐨𝐮𝐫𝐢𝐬𝐦 𝐌𝐚𝐧𝐚𝐠𝐞𝐦𝐞𝐧𝐭">𝐁𝐒 𝐢𝐧 𝐓𝐨𝐮𝐫𝐢𝐬𝐦 𝐌𝐚𝐧𝐚𝐠𝐞𝐦𝐞𝐧𝐭</option>
                     <option value="𝐁𝐒 𝐢𝐧 𝐁𝐮𝐬𝐢𝐧𝐞𝐬𝐬 𝐀𝐝𝐦𝐢𝐧𝐢𝐬𝐭𝐫𝐚𝐭𝐢𝐨𝐧">𝐁𝐒 𝐢𝐧 𝐁𝐮𝐬𝐢𝐧𝐞𝐬𝐬 𝐀𝐝𝐦𝐢𝐧𝐢𝐬𝐭𝐫𝐚𝐭𝐢𝐨𝐧</option>
                     <optgroup label="Major in Business Administration">
                       <option value="𝐅𝐢𝐧𝐚𝐧𝐜𝐢𝐚𝐥 𝐌𝐚𝐧𝐚𝐠𝐞𝐦𝐞𝐧𝐭">Financial Management</option>
                       <option value="𝐌𝐚𝐫𝐤𝐞𝐭𝐢𝐧𝐠 𝐌𝐚𝐧𝐚𝐠𝐞𝐦𝐞𝐧𝐭">Marketing Management</option>
                       <option value="𝐇𝐮𝐦𝐚𝐧 𝐑𝐞𝐬𝐨𝐮𝐫𝐜𝐞 𝐃𝐞𝐯𝐞𝐥𝐨𝐩𝐦𝐞𝐧𝐭 𝐌𝐚𝐧𝐚𝐠𝐞𝐦𝐞𝐧𝐭">Human Resource Development Management</option>
                     </optgroup>
                     <option value="𝐁𝐒 𝐢𝐧 𝐄𝐧𝐭𝐫𝐞𝐩𝐫𝐞𝐧𝐞𝐮𝐫𝐬𝐡𝐢𝐩">𝐁𝐒 𝐢𝐧 𝐄𝐧𝐭𝐫𝐞𝐩𝐫𝐞𝐧𝐞𝐮𝐫𝐬𝐡𝐢𝐩</option>
                     <option value="𝐁𝐚𝐜𝐡𝐞𝐥𝐨𝐫 𝐨𝐟 𝐀𝐫𝐭𝐬 𝐢𝐧 𝐋𝐢𝐭𝐞𝐫𝐚𝐫𝐲 & 𝐂𝐮𝐥𝐭𝐮𝐫𝐚𝐥 𝐒𝐭𝐮𝐝𝐢𝐞𝐬">𝐁𝐚𝐜𝐡𝐞𝐥𝐨𝐫 𝐨𝐟 𝐀𝐫𝐭𝐬 𝐢𝐧 𝐋𝐢𝐭𝐞𝐫𝐚𝐫𝐲 & 𝐂𝐮𝐥𝐭𝐮𝐫𝐚𝐥 𝐒𝐭𝐮𝐝𝐢𝐞𝐬</option>
                     <option value="𝐁𝐒 𝐢𝐧 𝐈𝐧𝐟𝐨𝐫𝐦𝐚𝐭𝐢𝐨𝐧 𝐒𝐲𝐬𝐭𝐞𝐦">𝐁𝐒 𝐢𝐧 𝐈𝐧𝐟𝐨𝐫𝐦𝐚𝐭𝐢𝐨𝐧 𝐒𝐲𝐬𝐭𝐞𝐦</option>
                     <option value="𝐀𝐬𝐬𝐨𝐜𝐢𝐚𝐭𝐞 𝐢𝐧 𝐂𝐨𝐦𝐩𝐮𝐭𝐞𝐫 𝐓𝐞𝐜𝐡𝐧𝐨𝐥𝐨𝐠𝐲">𝐀𝐬𝐬𝐨𝐜𝐢𝐚𝐭𝐞 𝐢𝐧 𝐂𝐨𝐦𝐩𝐮𝐭𝐞𝐫 𝐓𝐞𝐜𝐡𝐧𝐨𝐥𝐨𝐠𝐲</option>
                   </select>


                    <!-- Other course options here -->
                </select>
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-success">Update</button>
</form>

                </div>

                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <?php
    include("student_footer.php");
    ?>
</body>
</html>
<!-- JavaScript to show notification at the bottom if details are incomplete -->
<?php if (isset($_SESSION['error'])): ?>
    <script>
        // Show notification at the bottom
        const errorMessage = "<?php echo $_SESSION['error']; ?>";
        const notification = document.createElement('div');
        notification.classList.add('alert', 'alert-danger', 'fixed-bottom', 'mb-5', 'w-100');
        notification.style.zIndex = '9999';
        notification.innerText = errorMessage;
        document.body.appendChild(notification);

        // Auto-hide the notification after 5 seconds
        setTimeout(function() {
            notification.remove();
        }, 5000);
    </script>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>