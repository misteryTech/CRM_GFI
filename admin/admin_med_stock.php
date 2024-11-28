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
                        <?php
                        // Query to count medicines that need reordering
                        $reorder_count_query = "SELECT COUNT(*) AS reorder_count FROM medicines WHERE stock < reorder_point";
                        $result = mysqli_query($connection, $reorder_count_query);

                        // Fetch the count from the result
                        $row = mysqli_fetch_assoc($result);

                        // If there's a result, set the count; otherwise, default to 0
                        $reorder_count = $row['reorder_count'] ?? 0;
                        ?>
                        <a class="nav-link" id="pills-reorder-tab" data-toggle="pill" href="#pills-reorder" role="tab" aria-controls="pills-reorder" aria-selected="false">
                            Reorder 
                            <?php if ($reorder_count > 0): ?>
                                <span class="badge badge-pill badge-danger"><?php echo $reorder_count; ?></span>
                            <?php endif; ?>
                        </a>

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
            <th><input type="checkbox" id="select-all"></th>
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
                <td><input type="checkbox"></td>
                <td><?= htmlspecialchars($row['id']); ?></td>
                <td><?= htmlspecialchars($row['medicine_name']); ?></td>
                <td><?= htmlspecialchars($row['stock']); ?></td>
                <td><?= htmlspecialchars($row['reorder_point']); ?></td>
                <td>
                    <!-- Edit Button that triggers the modal -->
                    <button class="btn btn-success" data-toggle="modal" data-target="#editModal<?= $row['id']; ?>">Edit</button>
                </td>
            </tr>

            <!-- Modal for Editing Medicine -->
            <div class="modal fade" id="editModal<?= $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel<?= $row['id']; ?>" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel<?= $row['id']; ?>">Edit Medicine</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="process_code/update_medicine.php" method="POST">
                                <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="medicine_name_<?= $row['id']; ?>">Medicine Name</label>
                                        <input type="text" class="form-control" id="medicine_name_<?= $row['id']; ?>" name="medicine_name" value="<?= htmlspecialchars($row['medicine_name']); ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="stock_<?= $row['id']; ?>">Stock On Hand</label>
                                        <input type="number" class="form-control" id="stock_<?= $row['id']; ?>" name="stock" value="<?= htmlspecialchars($row['stock']); ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="reorder_point_<?= $row['id']; ?>">Reorder Point</label>
                                        <input type="number" class="form-control" id="reorder_point_<?= $row['id']; ?>" name="reorder_point" value="<?= htmlspecialchars($row['reorder_point']); ?>" required>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary mt-3">Save Changes</button>
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
                    <th><input type="checkbox" id="select-all"></th> <!-- Select All Checkbox -->
                    <th>#</th> <!-- Row Number -->
                    <th>Medicine Name</th>
                    <th>Stock On Hand</th>
                    <th>Reorder Point</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><input type="checkbox"></td> <!-- Checkbox for selection -->
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
    dom: 'Bfrtip', // Enables buttons and other options
    buttons: [
        {
            extend: 'print',
            text: 'Print Selected', // Label for the button
            action: function (e, dt, button, config) {
                // Get the table rows that have the checkbox checked
                let selectedRows = dt.rows(function (idx, data, node) {
                    return $(node).find('input[type="checkbox"]:checked').length > 0;
                });

                // Clone the DataTable for printing only the selected rows
                let clonedTable = $('<table></table>')
                    .addClass('display table table-bordered')
                    .append('<thead>' + $('#stocktable thead').html() + '</thead>') // Include <thead>
                    .append('<tbody></tbody>'); // Append an empty tbody

                // Remove the checkbox and row number columns from the <thead>
                clonedTable.find('thead th:eq(0), thead th:eq(1), thead th:eq(5)').remove(); // Remove checkbox and row number columns from <thead>

                // Append the selected rows to the cloned table
                selectedRows.nodes().each(function (row) {
                    let clonedRow = $(row).clone();

                    // Remove the checkbox column (td:eq(0)) and row number column (td:eq(1))
                    clonedRow.find('td:eq(0), td:eq(1), td:eq(5)').remove();

                    // Append the cloned row (with the selected columns removed) to the tbody
                    clonedTable.find('tbody').append(clonedRow);
                });

                // Create a print view with <thead>
                let win = window.open('', '_blank');
                win.document.write('<html><head><title>Print Selected Rows</title>');
                win.document.write('<style>table {width: 100%; border-collapse: collapse;} th, td {border: 1px solid #ddd; padding: 8px; text-align: left;}</style>');
                win.document.write('</head><body>');
                win.document.write('<h3 style="text-align: center;">Selected Stock Report</h3>');
                win.document.write('<h5 style="text-align: center;">Printed on: ' + new Date().toLocaleString() + '</h5>');
                win.document.write(clonedTable.prop('outerHTML')); // Append the cloned table (with <thead>)
                win.document.write('</body></html>');
                win.document.close();
                win.print();
            }
        }
    ]
});


$('#reorder').DataTable({
    dom: 'Bfrtip', // Enables buttons and other options
    buttons: [
        {
            extend: 'print',
            text: 'Print Selected', // Label for the button
            action: function (e, dt, button, config) {
                // Get the table rows that have the checkbox checked
                let selectedRows = dt.rows(function (idx, data, node) {
                    return $(node).find('input[type="checkbox"]:checked').length > 0;
                });

                // Clone the DataTable for printing only the selected rows
                let clonedTable = $('<table></table>')
                    .addClass('display table table-bordered')
                    .append('<thead>' + $('#reorder thead').html() + '</thead>') // Use reorder table's thead
                    .append('<tbody></tbody>');

                // Remove the checkbox and row number columns from the <thead>
                clonedTable.find('thead th:eq(0), thead th:eq(1), thead th:eq(5)').remove(); // Remove checkbox and row number columns from <thead>
                // Append the selected rows to the cloned table
                selectedRows.nodes().each(function (row) {
                    let clonedRow = $(row).clone();

                    // Remove the checkbox column (td:eq(0)) and row number column (td:eq(1))
                    clonedRow.find('td:eq(0), td:eq(1), td:eq(5)').remove();

                    // Append the cloned row (with the selected columns removed) to the tbody
                    clonedTable.find('tbody').append(clonedRow);
                });

                // Create a print view with <thead>
                let win = window.open('', '_blank');
                win.document.write('<html><head><title>Print Selected Rows</title>');
                win.document.write('<style>table {width: 100%; border-collapse: collapse;} th, td {border: 1px solid #ddd; padding: 8px; text-align: left;}</style>');
                win.document.write('</head><body>');
                win.document.write('<h3 style="text-align: center;">Selected Reorder Report</h3>');
                win.document.write('<h5 style="text-align: center;">Printed on: ' + new Date().toLocaleString() + '</h5>');
                win.document.write(clonedTable.prop('outerHTML')); // Append the cloned table (with <thead>)
                win.document.write('</body></html>');
                win.document.close();
                win.print();
            }
        }
    ]
});

});

</script>
