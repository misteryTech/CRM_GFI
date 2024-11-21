<?php
include("student_header.php");
include("../include/connection.php");



$student_id = $_SESSION['student_id'];
$username = $_SESSION['username'];



?>

<body id="page-top">
    <div id="wrapper">
        <?php include("student_sidebar.php"); ?>
        <?php
        if (isset($_GET['user_id'])) {
            $student_id = $_GET['user_id'];

            // Fetch data from medical_history_table
            $stmt_medical = $connection->prepare("SELECT * FROM medical_history_table WHERE user_id = ?");
            $stmt_medical->bind_param('i', $student_id);
            $stmt_medical->execute();
            $result_medical = $stmt_medical->get_result();

            // Fetch data from student_illness table
            $stmt_illness = $connection->prepare("
                SELECT 
                    student_id,
                    documents,
                    chief_complain,
                    illness,
                    allergic_reaction,
                    medication,
                    dose,
                    times_per_day,
                    start_date,
                    end_date,
                    created_at
                FROM student_illness
                WHERE student_id = ?
                ORDER BY created_at DESC
            ");
            $stmt_illness->bind_param('i', $student_id);
            $stmt_illness->execute();
            $result_illness = $stmt_illness->get_result();
        }
        ?>
        
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include("student_topbar.php"); ?>

                <div class="container mt-5 mb-5">
                    <h2>Medical Records</h2>

       

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
                                            <th>Document</th>
                                            <th>Chief Complaint</th>
                                            <th>Illness</th>
                                            <th>Allergic Reaction</th>
                                            <th>Medication</th>
                                            <th>Dose</th>
                                            <th>Times Per Day</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Record Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (isset($result_illness) && $result_illness->num_rows > 0): ?>
                                            <?php while ($row = $result_illness->fetch_assoc()): ?>
                                                <tr>
                                                    <td><a href="uploads/<?php echo htmlspecialchars($row['documents']); ?>" download>Download</a></td>
                                                    <td><?php echo htmlspecialchars($row['chief_complain']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['illness']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['allergic_reaction']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['medication']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['dose']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['times_per_day']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['start_date']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['end_date']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                                                </tr>
                                            <?php endwhile; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="10">No illness records found.</td>
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

    <?php include("student_footer.php"); ?>
</body>
