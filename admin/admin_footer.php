<!-- Footer -->
<footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>DEVELOPED BY:&copy;GFI Student</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="../vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../js/demo/chart-area-demo.js"></script>



        <!-- End of Page Wrapper -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
            <!-- End of Main Content -->
            <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
            <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
            <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>




            <script>


   document.addEventListener('DOMContentLoaded', function() {
        $('.view-btn').on('click', function() {
            var orgId = $(this).data('id');
            var name = $(this).data('name');
            var department = $(this).data('department');
            var advisor = $(this).data('advisor');
            var email = $(this).data('email');
            var logo = $(this).data('logo');

            $('#organizationModalLabel').text(name);
            $('#organizationName').text(name);
            $('#organizationDepartment').text(department);
            $('#organizationAdvisor').text(advisor);
            $('#organizationEmail').text(email);
            $('#organizationLogo').attr('src', 'uploads/' + logo);

            // Fetch registered students for the organization
            $.ajax({
                url: 'process_code/fetch_students_by_organization.php',
                type: 'POST',
                data: {organization_id: orgId},
                success: function(response) {
                    $('#studentList').html(response);
                }
            });
        });
    });

                    $(document).ready(function() {
                        $('.view-btn').on('click', function() {
                            var title = $(this).data('title');
                            var description = $(this).data('description');
                            var date = $(this).data('date');
                            var image = $(this).data('image');

                            $('#eventModalLabel').text(title);
                            $('#eventTitle').text(title);
                            $('#eventDescription').text(description);
                            $('#eventDate').text(date);
                            $('#eventImage').attr('src', image);
                        });
                    });


        function generatePassword() {
            const length = 12;
            const charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+";
            let password = "";
            for (let i = 0; i < length; i++) {
                const randomIndex = Math.floor(Math.random() * charset.length);
                password += charset[randomIndex];
            }
            document.getElementById('password').value = password;
        }

        $(document).ready(function() {
    $('#studentTable').DataTable({
        order: [[0, 'asc']] // Column 0 (first column), descending order
    });
});


    
        $(document).ready(function() {
            $('#stocktable').DataTable(
                {
                dom: 'Bfrtip',
                buttons: [
                    'print'
                ]
            });


        });

         
        $(document).ready(function() {
            $('#reorder').DataTable(
                {
                dom: 'Bfrtip',
                buttons: [
                    'print'
                ]
            });


        });




        
        $(document).ready(function() {
            $('#staffMedicalRecords').DataTable();
        });


        
        $(document).ready(function() {
            $('#staffmedicalRecordTable').DataTable();
        });


        $(document).ready(function() {
            $('#medicineTable').DataTable();
        });


        $(document).ready(function() {
            $('#medicalrecordTable').DataTable();
        });

        $(document).ready(function() {
            $('#medicalRecordTable').DataTable();
        });


        $(document).ready(function() {
            $('#medicalReleaseRecordTable').DataTable();
        });





        $(document).ready(function() {
            $('#studentName').select2({
                placeholder: "Select a student",
                allowClear: true
            });
        });




    
    </script>




</body>

</html>