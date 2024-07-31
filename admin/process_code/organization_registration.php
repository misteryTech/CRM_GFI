<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $studentId = $_POST['studentName'];
    $studentEmail = $_POST['studentEmail'];
    $studentPhone = $_POST['studentPhone'];
    $studentGrade = $_POST['studentGrade'];
    $orgName = $_POST['orgName'];
    $orgType = $_POST['orgType'];
    $role = $_POST['role'];
    $personalStatement = $_POST['personalStatement'];
 // Database connection parameters
 $servername = "localhost";
 $username = "root";
 $password = "";
 $dbname = "soms_db";

 // Create connection
 $connection = new mysqli($servername, $username, $password, $dbname);

 // Check connection
 if ($connection->connect_error) {
     die("Connection failed: " . $connection->connect_error);
 }


 // Sanitize data (optional but recommended)
 $studentId = mysqli_real_escape_string($connection, $studentId);
 $studentEmail = mysqli_real_escape_string($connection, $studentEmail);
 $studentPhone = mysqli_real_escape_string($connection, $studentPhone);
 $studentGrade = mysqli_real_escape_string($connection, $studentGrade);
 $orgName = mysqli_real_escape_string($connection, $orgName);
 $orgType = mysqli_real_escape_string($connection, $orgType);
 $role = mysqli_real_escape_string($connection, $role);
 $personalStatement = mysqli_real_escape_string($connection, $personalStatement);


    // Perform insert query
    $insertQuery = "INSERT INTO registrations (student_id, student_email, student_phone, student_grade, organization_name, organization_type, role, personal_statement)
                    VALUES ('$studentId', '$studentEmail', '$studentPhone', '$studentGrade', '$orgName', '$orgType', '$role', '$personalStatement')";

    if (mysqli_query($connection, $insertQuery)) {
        $_SESSION['message'] = "Registration submitted successfully";
        $_SESSION['message_type'] = "alert-success";
    } else {
        $_SESSION['message'] = "Error: " . mysqli_error($connection);
        $_SESSION['message_type'] = "alert-danger";
    }



    $connection->close();

    header("Location: ../organization_page.php");
    exit();
}
?>
