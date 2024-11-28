<?php
session_start();
include("include/connection.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $password = $_POST['password']; // No need to sanitize, as it's not directly used in the query

    // Query to find the user with the provided username
    $query = "SELECT * FROM students_table WHERE username = ?";
    $stmt = mysqli_prepare($connection, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);

            // Check if the student is archived
            if ($row['archive'] == '1') {
                // If archived, show alert and redirect
                echo "<script>
                        alert('Your account is archived and cannot log in.');
                        window.location.href = 'index.php';
                      </script>";
                exit();
            }

            $stored_password = $row['password'];

            // Verify the password
            if (password_verify($password, $stored_password)) {
                // Password is correct, set the session variables
                $_SESSION['username'] = $row['username'];
                $_SESSION['student_id'] = $row['student_id'];
                $_SESSION['first_name'] = $row['first_name'];

                header("Location: student/student_dashboard.php");
                exit();
            } else {
                // Incorrect password
                echo "<script>
                        alert('Invalid username or password!');
                        window.location.href = 'index.php';
                      </script>";
                exit();
            }
        } else {
            // Username not found
            echo "<script>
                    alert('Invalid username or password!');
                    window.location.href = 'index.php';
                  </script>";
            exit();
        }

        mysqli_stmt_close($stmt);
    } else {
        // Query preparation failed
        echo "<script>
                alert('Error preparing query: " . mysqli_error($connection) . "');
                window.location.href = 'index.php';
              </script>";
        exit();
    }
}

// Close the database connection
mysqli_close($connection);
?>
