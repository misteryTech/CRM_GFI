<?php
include("staff_header.php");
include("../include/connection.php");


// Check if the staff is logged in
if (!isset($_SESSION['staff_id'])) {


    $_SESSION['error'] = "You must be logged in to view this page.";
    header("Location: ../login_staff.php");
    exit();
    
}


$staff_id = $_SESSION['staff_id'];
$username = $_SESSION['username'];


?>

<body id="page-top">
    <div id="wrapper">
        <?php include("staff_sidebar.php"); ?>
        <?php
        if (isset($_GET['user_id'])) {
            $staff_id = $_GET['user_id'];
            $role = 'Staff';

            // Fetch data from medical_history_table
            $stmt_medical = $connection->prepare("SELECT * FROM medical_history_table WHERE user_id = ? AND role = ? ");
            $stmt_medical->bind_param('is', $staff_id, $role);
            $stmt_medical->execute();
            $result_medical = $stmt_medical->get_result();

            // Fetch data from staff_illness table
            $stmt_illness = $connection->prepare("
                SELECT 
                    staff_id,
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
                FROM staff_illness
                WHERE staff_id = ?
                ORDER BY created_at DESC
            ");
            $stmt_illness->bind_param('i', $staff_id);
            $stmt_illness->execute();
            $result_illness = $stmt_illness->get_result();
        }
        ?>
        
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include("staff_topbar.php"); ?>

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

    <?php include("staff_footer.php"); ?>
</body>
