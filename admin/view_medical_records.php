<?php
include("admin_header.php");
session_start();
include("../include/connection.php");
?>

<body id="page-top">
    <div id="wrapper">
        <?php include("admin_sidebar.php"); ?>
        <?php
        if (isset($_GET['user_id'])) {
            $student_id = $_GET['user_id'];

            // Fetch data from medical_history_table
            $stmt_medical = $connection->prepare("SELECT * FROM medical_history_table WHERE user_id = ?");
            $stmt_medical->bind_param('i', $student_id);
            $stmt_medical->execute();
            $result_medical = $stmt_medical->get_result();

            // Fetch data from student_illness table
            $stmt_illness = $connection->prepare("SELECT * FROM student_illness WHERE student_id = ?");
            $stmt_illness->bind_param('i', $student_id);
            $stmt_illness->execute();
            $result_illness = $stmt_illness->get_result();
        }
        ?>
        
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include("admin_topbar.php"); ?>

                <div class="container mt-5 mb-5">
                    <h2>Student Medical Record</h2>

                    <!-- Medical History Table -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Student Medical Records</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Existing Condition</th>
                                            <th>Documents</th>
                                            <th>Date Submitted</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (isset($result_medical) && $result_medical->num_rows > 0): ?>
                                            <?php while ($record = $result_medical->fetch_assoc()): ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($record['existing_condition']); ?></td>
                                                    <td><a href="process_code/uploads/<?php echo htmlspecialchars($record['documents']); ?>" target="_blank">View Document</a></td>
                                                    <td><?php echo htmlspecialchars($record['date_submitted']); ?></td>
                                                </tr>
                                            <?php endwhile; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="3">No medical records found.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Existing Illness Table -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Existing Illness</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Chief Complain</th>
                                            <th>Documents</th>
                                            <th>Date Diagnosed</th>
                                         
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (isset($result_illness) && $result_illness->num_rows > 0): ?>
                                            <?php while ($illness = $result_illness->fetch_assoc()): ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($illness['chief_complain']); ?></td>
                                             
                                                    <td><a href="../student/process_code/uploads/<?php echo htmlspecialchars($record['documents']); ?>" target="_blank">View Document</a></td>
                                            
                                                    <td><?php echo htmlspecialchars($illness['date_registered']); ?></td>
                                                </tr>
                                            <?php endwhile; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="3">No illness records found.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include("admin_footer.php"); ?>
</body>
