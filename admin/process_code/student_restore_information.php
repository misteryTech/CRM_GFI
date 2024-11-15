<?php
include("../../include/connection.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id'])) {
        $student_id = $_POST['id'];

        // Delete student from the database
        $query = "UPDATE students_table SET
        archive='0'
        WHERE id='$student_id'";

if (mysqli_query($connection, $query)) {
    $_SESSION['success'] = "Student Archived successfully!";
} else {
    $_SESSION['error'] = "Error: " . $query . "<br>" . mysqli_error($connection);
}

header("Location: ../student_information_page_data.php"); // Change this to the appropriate page
exit();
}

mysqli_close($connection);
}
?>
