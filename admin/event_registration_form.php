<?php
session_start();
   // Database connection parameters
   $servername = "localhost";
   $username = "root";
   $password = "";
   $dbname = "soms_db";

   // Create connection
   $conn = new mysqli($servername, $username, $password, $dbname);



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    $organization_id = mysqli_real_escape_string($conn, $_POST['organizer']); // Assuming this field exists in your form

    // Handling file upload
    $target_dir = "uploads/"; // Absolute path to the target directory
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        $_SESSION['message'] = "File is not an image.";
        $_SESSION['message_type'] = "alert-danger";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        $_SESSION['message'] = "Sorry, file already exists.";
        $_SESSION['message_type'] = "alert-danger";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["image"]["size"] > 500000) { // 500KB max size
        $_SESSION['message'] = "Sorry, your file is too large.";
        $_SESSION['message_type'] = "alert-danger";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
        $_SESSION['message'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $_SESSION['message_type'] = "alert-danger";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $_SESSION['message'] = "Sorry, your file was not uploaded.";
        $_SESSION['message_type'] = "alert-danger";
    // If everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "INSERT INTO events (title, description, date, image_path, organization_id) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);

            if ($stmt) {
                $stmt->bind_param("ssssi", $title, $description, $date, $target_file, $organization_id);

                if ($stmt->execute()) {
                    $_SESSION['message'] = "Event registered successfully";
                    $_SESSION['message_type'] = "alert-success";
                } else {
                    $_SESSION['message'] = "Error: " . $stmt->error;
                    $_SESSION['message_type'] = "alert-danger";
                }

                $stmt->close();
            } else {
                $_SESSION['message'] = "Error preparing statement: " . $conn->error;
                $_SESSION['message_type'] = "alert-danger";
            }

            $conn->close();
        } else {
            $_SESSION['message'] = "Sorry, there was an error uploading your file.";
            $_SESSION['message_type'] = "alert-danger";
        }
    }

    header("Location: gallery_events_page_registration.php");
    exit();
}
?>
