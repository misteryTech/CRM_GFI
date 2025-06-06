<?php
include("admin_header.php");
session_start();
include("../include/connection.php");

if (isset($_GET['student_id'])) {
    $student_id = $_GET['student_id'];

      // Prepare the SQL statement
      $stmt = $connection->prepare("SELECT * FROM students_table WHERE student_id = ?");

      if ($stmt) {
          // Bind the student_id parameter
          $stmt->bind_param('i', $student_id);

          // Execute the query
          $stmt->execute();

          // Get the result
          $result = $stmt->get_result();

          // Fetch the row
          $student_data = $result->fetch_assoc();

          // Close the statement
          $stmt->close();
      } else {
          // Handle SQL error
          $_SESSION['error'] = "Failed to prepare the SQL statement.";
      }


}


?>



<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php
        include("admin_sidebar.php");
        ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d -flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php
                include("admin_topbar.php");
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

                    <h2>Student Medical Record</h2>
                    <form action="process_code/student_medical_records.php" method="POST">
                        <!-- Student Information -->
                        <div class="form-group">
                         
                        <div class="form-row studentinfo" >
                            <div class="col-md-4">
                                <label for="studentId">Student ID</label>
                                <h1><?php echo htmlspecialchars($student_data['student_id'] ?? 'N/A'); ?></h1>
                            </div>

                            <div class="col-md-4">
                                <label for="studentName">Student Name</label>
                                <h4><?php echo htmlspecialchars($student_data['first_name'] . ' ' . $student_data['last_name']); ?></h4>
                            </div>

                            <div class="col-md-4">
                                <label for="course">Course</label>
                                <h4><?php echo htmlspecialchars($student_data['course'] ); ?></h4>
                            </div>
                        </div>

                        <input type="hidden" class="form-control" id="student_id" name="student_id"  value="<?php echo htmlspecialchars($student_data['student_id']); ?>" >
                        
                        </div>

                        <!-- Illness Details -->
                        <div class="form-group">
                         
                            <div class="form-group">
                                <label for="illness">Chief Complaint</label>
                                <input type="text" class="form-control" id="illness" name="illness" required>
                            </div>
                        
                            <div class="form-group">
                                <label for="date_diagnosed">Date Diagnosed</label>
                                <input type="date" class="form-control" id="date_diagnosed" name="date_diagnosed" required>
                            </div>
                        </div>

                        <!-- Prescribed Medicine -->
                        <div class="form-group">
                            <h3>Prescribed Medicine</h3>
                            <div id="medicine-fields">
                                <div class="form-row">
                                    <div class="col-md-5">
                                        <label for="medicine_name">Generic Name</label>
                                    <select name="medicine_id[]" class="form-control">
                                        <option value="N/A" selected>N/A</option> <!-- Default option N/A -->
                                        <?php
                                        $sql_medicine = "SELECT * FROM medicines";
                                        $result_medicine = $connection->query($sql_medicine);
                                        $medicine = [];
                                        while ($row_medicine = $result_medicine->fetch_assoc()) {
                                            $medicine[] = $row_medicine;
                                        }

                                        
                                        
                                        
                                        foreach ($medicine as $medicine_data) : ?>
                                            <option value="<?php echo $medicine_data['id']; ?>">
                                                <?php echo ($medicine_data['medicine_name']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                        
                                    </div>
                                    <div class="col-md-5">
                                        <label for="quantity">Quantity</label>
                                        <input type="number" class="form-control" name="quantity[]" required>
                                    </div>
                                    <div class="col-md-2 align-self-end">
                                        <button type="button" class="btn btn-danger remove-medicine">Remove</button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row mt-3">
                                <div class="col-md-12 text-right">
                                    <button type="button" id="add-medicine" class="btn btn-primary">Add Medicine</button>
                                </div>
                            </div>

                            <div class="form-group mt-4">
                                <label for="recommendation">Recommendation</label>
                                <textarea class="form-control" id="recommendation" name="recommendation" rows="3" required></textarea>
                            </div>

                        </div>

                        <div class="form-group mt-4 text-right">
                            <button type="submit" class="btn btn-success">Submit Record</button>
                        </div>
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
    include("admin_footer.php");
    ?>

    <script>
        document.getElementById('add-medicine').addEventListener('click', function() {
            var medicineFields = document.getElementById('medicine-fields');
            var newField = document.createElement('div');
            newField.className = 'form-row mt-3';
            newField.innerHTML = `
                <div class="col-md-5">
                    <label for="medicine_name">Generic Name</label>
                    <select name="medicine_id[]" class="form-control">
                        <?php foreach ($medicine as $medicine_data) :?>
                            <option value="<?php echo $medicine_data['id']; ?>">
                                <?php echo ($medicine_data['medicine_name']); ?>
                            </option>
                        <?php endforeach?>
                    </select>
                </div>
                <div class="col-md-5">
                    <label for="quantity">Quantity</label>
                    <input type="number" class="form-control" name="quantity[]" required>
                </div>
                <div class="col-md-2 align-self-end">
                    <button type="button" class="btn btn-danger remove-medicine">Remove</button>
                </div>`;
            medicineFields.appendChild(newField);s

            // Attach the remove event listener to the new remove button
            newField.querySelector('.remove-medicine').addEventListener('click', function() {
                newField.remove();
            });
        });

        // Attach the remove event listener to the initial remove button
        document.querySelectorAll('.remove-medicine').forEach(function(button) {
            button.addEventListener('click', function() {
                button.closest('.form-row').remove();
            });
        });
    </script>
</body>
