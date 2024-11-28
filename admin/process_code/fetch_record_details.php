<?php
include("connection.php");

// fetch_record_details.php
if (isset($_GET['id'])) {
    $student_id = $_GET['id']; // Get record_id from the request

    // Fetch record details from the student_clinic_record_table
    $query = "
        SELECT scrt.*, s.*, pm.*
        FROM student_clinic_record_table AS scrt
        INNER JOIN students_table AS s ON scrt.student_id = s.student_id
        LEFT JOIN prescribed_medicine_table AS pm ON scrt.record_id = pm.record_id
        WHERE scrt.student_id = '$student_id'
    ";
    
    $result = mysqli_query($connection, $query);
    $record = mysqli_fetch_assoc($result);

    $record_id = $record['record_id'];
    
    // Check if record exists
    if ($record) {
        // Output the detailed record information in a table for student information
        echo "<h3>Student Information</h3>";
        echo "<table class='table table-bordered'>";
        echo "<tr><th>Student ID</th><td>" . htmlspecialchars($record['student_id']) . "</td></tr>";
        echo "<tr><th>Student Name</th><td>" . htmlspecialchars($record['first_name']) . ' ' . htmlspecialchars($record['last_name']) . "</td></tr>";
        echo "<tr><th>Illness</th><td>" . htmlspecialchars($record['illness']) . "</td></tr>";
        echo "<tr><th>Symptoms</th><td>" . htmlspecialchars($record['symptoms']) . "</td></tr>";
        echo "<tr><th>Recommendation</th><td>" . htmlspecialchars($record['recommendation']) . "</td></tr>";
        echo "<tr><th>Date Diagnosed</th><td>" . htmlspecialchars($record['date_diagnosed']) . "</td></tr>";
        echo "<tr><th>Note</th><td>" . htmlspecialchars($record['note']) . "</td></tr>";
        echo "</table>";

        // Check if any prescribed medicines exist for the record
        if ($record['medicine_id']) {
            echo "<h3>Prescribed Medicines</h3>";
            
            // Inner Join to fetch the medicine name from the medicine_table
            $medicine_query = "
                SELECT m.medicine_name, pm.quantity
                FROM prescribed_medicine_table AS pm
                INNER JOIN medicines AS m ON pm.medicine_id = m.id
                WHERE pm.record_id = '$record_id'
            ";
            $medicine_result = mysqli_query($connection, $medicine_query);
        
            if (mysqli_num_rows($medicine_result) > 0) {
                echo "<table class='table table-bordered'>";
                echo "<thead><tr><th>Medicine Name</th><th>Quantity</th></tr></thead>";
                echo "<tbody>";
                while ($medicine = mysqli_fetch_assoc($medicine_result)) {
                    echo "<tr><td>" . htmlspecialchars($medicine['medicine_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($medicine['quantity']) . "</td></tr>";
                }
                echo "</tbody></table>";
            } else {
                echo "No prescribed medicines found.<br>";
            }
        }

    } else {
        echo "No details found for this record.";
    }
}
?>
