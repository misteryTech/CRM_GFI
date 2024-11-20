<?php
include("admin_header.php");

include("../include/connection.php");

$reorder = '100';
?>

<body id="page-top">
    <div id="wrapper">
        <?php include("admin_sidebar.php"); ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include("admin_topbar.php"); ?>

                <div class="container-fluid">
                    <?php if (isset($_SESSION['success'])): ?>
                        <div class="alert alert-success">
                            <?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger">
                            <?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
                        </div>
                    <?php endif; ?>

                    <!-- Tab Pills -->
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="pills-instock-tab" data-toggle="pill" href="#pills-instock" role="tab" aria-controls="pills-instock" aria-selected="true">In Stock</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="pills-reorder-tab" data-toggle="pill" href="#pills-reorder" role="tab" aria-controls="pills-reorder" aria-selected="false">Reorder</a>
                        </li>
                    </ul>

                    <div class="tab-content" id="pills-tabContent">
                        <!-- In Stock Tab -->
                        <div class="tab-pane fade show active" id="pills-instock" role="tabpanel" aria-labelledby="pills-instock-tab">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">In Stock</h6>
                                </div>
                                <div class="card-body">
                                    <?php
                                    // Query to get medicines where stock is greater than or equal to reorder point
                                    $query = "SELECT * FROM medicines WHERE stock >= reorder_point";
                                    $result = mysqli_query($connection, $query);

                                    if (mysqli_num_rows($result) > 0): ?>
                                        <table class="table table-bordered" id="stocktable">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Medicine Name</th>
                                                    <th>Stock On Hand</th>
                                                    <th>Reorder Point</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                                    <tr>
                                                        <td><?= htmlspecialchars($row['id']); ?></td>
                                                        <td><?= htmlspecialchars($row['medicine_name']); ?></td>
                                                        <td><?= htmlspecialchars($row['stock']); ?></td>
                                                        <td><?= htmlspecialchars($row['reorder_point']); ?></td>
                                                    </tr>
                                                <?php endwhile; ?>
                                            </tbody>
                                        </table>
                                    <?php else: ?>
                                        <p>All medicines have sufficient stock levels.</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Reorder Tab -->
                        <div class="tab-pane fade" id="pills-reorder" role="tabpanel" aria-labelledby="pills-reorder-tab">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Reorder</h6>
                                </div>
                                <div class="card-body">
                                    <?php
                                    // Query to get medicines where stock is less than reorder point
                                    $query = "SELECT * FROM medicines WHERE stock < reorder_point ";
                                    $result = mysqli_query($connection, $query);

                                    if (mysqli_num_rows($result) > 0): ?>
                                        <table class="table table-bordered" id="reorder">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Medicine Name</th>
                                                    <th>Stock On Hand</th>
                                                    <th>Reorder Point</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                                    <tr>
                                                        <td><?= htmlspecialchars($row['id']); ?></td>
                                                        <td><?= htmlspecialchars($row['medicine_name']); ?></td>
                                                        <td><?= htmlspecialchars($row['stock']); ?></td>
                                                        <td><?= htmlspecialchars($row['reorder_point']); ?></td>
                                                        <td>
                                                            <button class="btn btn-danger" data-toggle="modal" data-target="#viewModal<?= $row['id']; ?>">Restock</button>
                                                        </td>
                                                    </tr>

                                                    <!-- Modal for Restocking -->
                                                    <div class="modal fade" id="viewModal<?= $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel<?= $row['id']; ?>" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Restock Medicine</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form action="process_code/reorder_medicine_process.php" method="POST">
                                                                        <input type="hidden" name="medicine_id" value="<?= $row['id']; ?>">
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <label>Medicine Name</label>
                                                                                <input type="text" class="form-control" value="<?= htmlspecialchars($row['medicine_name']); ?>" readonly>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <label>Stock</label>
                                                                                <input type="number" class="form-control" value="<?= htmlspecialchars($row['stock']); ?>" name="current_stock">
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <label>Manufacturer</label>
                                                                                <input type="text" class="form-control" value="<?= htmlspecialchars($row['manufacturer']); ?>" readonly>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <label>Restock Quantity</label>
                                                                                <input type="number" class="form-control" name="reorder_quantity" required>
                                                                            </div>
                                                                        </div>
                                                                        <button type="submit" class="btn btn-primary mt-3">Restock</button>
                                                                    </form>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endwhile; ?>
                                            </tbody>
                                        </table>
                                    <?php else: ?>
                                        <p>No medicines need reordering.</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <?php include("admin_footer.php"); ?>
</body>

<script>
$(document).ready(function() {
    // Initialize DataTables with the print button
    $('#stocktable').DataTable({
        dom: 'Bfrtip',
        buttons: ['print']
    });

    $('#reorder').DataTable({
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'print',
                text: 'Print', // Optional: Custom text for the print button
                exportOptions: {
                    columns: [1, 2] // Specify the column indexes you want to include in the print
                },
                customize: function (win) {
                    // Get the current date
                    const currentDate = new Date().toLocaleDateString('en-US', {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    });

                    // Add the current date to the print header
                    $(win.document.body)
                        .prepend('<h4 style="text-align:center; margin-bottom:20px;">Printed on: ' + currentDate + '</h4>');

                    // Optional: Remove buttons or modify the print layout
                    $(win.document.body).find('button').remove(); // Remove buttons from the printed document
                    $(win.document.body).find('.dataTables_wrapper').css('margin', '0 auto'); // Adjust table alignment
                }
            }
        ]
    });
});

</script>
