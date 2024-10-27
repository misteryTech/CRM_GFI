<?php
session_start();
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize student registration inputs
    $student_id = mysqli_real_escape_string($connection, $_POST['student_id']);
    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $password = password_hash(mysqli_real_escape_string($connection, $_POST['password']), PASSWORD_DEFAULT); // Hash the password
    $first_name = mysqli_real_escape_string($connection, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($connection, $_POST['last_name']);
    $dob = mysqli_real_escape_string($connection, $_POST['dob']);
    $gender = mysqli_real_escape_string($connection, $_POST['gender']);
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $phone = mysqli_real_escape_string($connection, $_POST['phone']);
    $street = mysqli_real_escape_string($connection, $_POST['street']);
    $barangay = mysqli_real_escape_string($connection, $_POST['barangay']);
    $municipality = mysqli_real_escape_string($connection, $_POST['municipality']);
    $province = mysqli_real_escape_string($connection, $_POST['province']);
    $year = mysqli_real_escape_string($connection, $_POST['year']);
    $section = mysqli_real_escape_string($connection, $_POST['section']);
    $course = mysqli_real_escape_string($connection, $_POST['course']);

    // Sanitize medical history inputs
    $pre_condition = mysqli_real_escape_string($connection, $_POST['pre_condition']);

    // File upload handling (documents)
    $target_dir = "uploads/"; // Directory to store uploaded files
    $file_name = $_FILES["documents"]["name"] ? $_FILES["documents"]["name"] : ""; // Leave blank if no file
    $target_file = $target_dir . basename($file_name);
    $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));  // Get file extension
    $file_mime_type = $file_name ? mime_content_type($_FILES['documents']['tmp_name']) : ""; // Get MIME type only if file exists
    $allowed_extensions = ['pdf', 'doc', 'docx'];
    $allowed_mime_types = [
        'application/pdf', 
        'application/msword', 
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
    ];
    $upload_ok = 1;

    if ($file_name) {
        // Check file size (optional, here max file size is 2MB)
        if ($_FILES["documents"]["size"] > 2000000) {
            $_SESSION['error'] = "File size is too large. Maximum allowed size is 2MB.";
            $upload_ok = 0;
        }

        // Allow only PDF or Word files (check both extension and MIME type)
        if (!in_array($file_type, $allowed_extensions) || !in_array($file_mime_type, $allowed_mime_types)) {
            $_SESSION['error'] = "Only PDF, DOC, or DOCX files are allowed.";
            $upload_ok = 0;
        }

        // Proceed with upload if the file passes checks
        if ($upload_ok == 1) {
            if (!move_uploaded_file($_FILES["documents"]["tmp_name"], $target_file)) {
                $_SESSION['error'] = "Error uploading document.";
                header("Location: ../student_registration_page.php");
                exit();
            }
        } else {
            header("Location: ../student_registration_page.php");
            exit();
        }
    }

    // Insert data into students_table using prepared statements
    $query_student = "INSERT INTO students_table (
        student_id, username, password, first_name, last_name, dob, gender, email, phone, street, barangay, municipality, province, year, section, course
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt_student = mysqli_prepare($connection, $query_student);
    mysqli_stmt_bind_param($stmt_student, 'ssssssssssssssss', $student_id, $username, $password, $first_name, $last_name, $dob, $gender, $email, $phone, $street, $barangay, $municipality, $province, $year, $section, $course);

    if (mysqli_stmt_execute($stmt_student)) {
        // Insert medical history into medical_history_table using prepared statements
        $query_medical = "INSERT INTO medical_history_table (user_id, existing_condition, documents, role, date_submitted) 
                          VALUES (?, ?, ?, 'Student', NOW())";

        $stmt_medical = mysqli_prepare($connection, $query_medical);
        mysqli_stmt_bind_param($stmt_medical, 'iss', $student_id, $pre_condition, $file_name);

        if (mysqli_stmt_execute($stmt_medical)) {
            $_SESSION['success'] = "Student registered successfully!";
        } else {
            $_SESSION['error'] = "Error inserting medical history: " . mysqli_error($connection);
        }

        header("Location: ../student_registration_page.php");
        exit();
    } else {
        $_SESSION['error'] = "Error: " . $query_student . "<br>" . mysqli_error($connection);
        header("Location: ../student_registration_page.php");
        exit();
    }
}

mysqli_close($connection);
?>
