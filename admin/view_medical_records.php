<?php
include("admin_header.php");
session_start();
include("../include/connection.php");
?>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <?php include("admin_sidebar.php"); ?>
        <?php
        if (isset($_GET['user_id'])) {
            $user_id = $_GET['user_id'];

            // Prepare the SQL statement
            $stmt = $connection->prepare("SELECT * FROM medical_history_table WHERE user_id = ?");

            if ($stmt) {
                // Bind the user_id parameter
                $stmt->bind_param('i', $user_id);

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
        
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <?php include("admin_topbar.php"); ?>

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

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Student Medical Records</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="medicalReleaseRecordTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Existing Condition</th>
                                            <th>Documents</th>
                                            <th>Date Submitted</th>
                                        
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                            // Prepare the SQL query to fetch and display medical records
                                            $stmt = $connection->prepare("SELECT mht.user_id, mht.existing_condition, mht.documents, mht.date_submitted FROM medical_history_table AS mht WHERE mht.user_id = ?");
                                            if ($stmt) {
                                                $stmt->bind_param('i', $user_id);
                                                $stmt->execute();
                                                $result = $stmt->get_result();

                                                while ($record = $result->fetch_assoc()) {
                                                    echo "<tr>";
                                                    echo "<td>" . htmlspecialchars($record['existing_condition']) . "</td>";
                                                    // Update the document link to point to the uploads directory
                                                    $documentPath = 'process_code/uploads/' . htmlspecialchars($record['documents']);
                                                    echo "<td><a href='#' class='document-link' data-doc='" . $documentPath . "'>View Document</a></td>";
                                                    echo "<td>" . htmlspecialchars($record['date_submitted']) . "</td>";
                                                
                                                    echo "</tr>";
                                                }

                                                $stmt->close();
                                            }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Document Modal -->
                <div class="modal fade" id="documentModal" tabindex="-1" aria-labelledby="documentModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="documentModalLabel">Uploaded Document</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">x</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <h1>Documents Ready To View</h1>
                                <iframe id="documentViewer" style="width: 100%; height: 500px;" frameborder="0"></iframe>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->
        </div>
        <!-- End of Content Wrapper -->
    </div>

    <?php include("admin_footer.php"); ?>

    <script>
        // Handle document link click
        document.querySelectorAll('.document-link').forEach(link => {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                const docPath = this.getAttribute('data-doc');

                // Set the iframe source to the document path
                const documentViewer = document.getElementById('documentViewer');
                documentViewer.src = docPath;

                // Show the modal
                const modal = new bootstrap.Modal(document.getElementById('documentModal'));
                modal.show();
            });
        });
    </script>
</body>
