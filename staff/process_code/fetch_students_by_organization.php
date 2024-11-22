<?php
include("../../include/connection.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $organization_id = mysqli_real_escape_string($connection, $_POST['organization_id']);

    $sql = "SELECT students.first_name, registrations.role 
            FROM students   
      
            JOIN registrations ON students.id = registrations.student_id 
            WHERE registrations.organization_name = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $organization_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<li>{$row['first_name']} - {$row['role']}</li>";
        }
    } else {
        echo "<li>No registered students found.</li>";
    }

    $stmt->close();
    $connection->close();
}
?>
