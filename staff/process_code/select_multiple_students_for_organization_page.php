<!-- select_multiple_students.php -->

<?php
// Include database connection and any necessary functions
include("../../include/connection.php");

// Fetch list of students from the database
$query = "SELECT id, first_name, last_name FROM students";
$result = mysqli_query($connection, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Multiple Students</title>
</head>
<body>

    <h2>Select Multiple Students</h2>

    <form action="process_multiple_students.php" method="POST">
        <table>
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Role in Organization</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Loop through each student and display a row with a checkbox
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['first_name'] . " " . $row['last_name'] . "</td>";
                    echo "<td>";
                    echo "<select name='role[" . $row['id'] . "]'>";
                    echo "<option value='member'>Member</option>"; // Default role
                    echo "<option value='leader'>Leader</option>";
                    // Add more role options as needed
                    echo "</select>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>

        <button type="submit">Assign Roles</button>
    </form>

</body>
</html>
