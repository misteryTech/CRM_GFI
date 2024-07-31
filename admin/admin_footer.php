<!-- Footer -->
<footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>made by &copy; SOM <sup>system</sup></span>
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
    <script src="../js/demo/chart-pie-demo.js"></script>


        <!-- End of Page Wrapper -->

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
            <!-- End of Main Content -->
            <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
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
            $('#studentTable').DataTable();
        });


        $(document).ready(function() {
            $('#studentName').select2({
                placeholder: "Select a student",
                allowClear: true
            });
        });




     // Wait for the document to be fully loaded
     document.addEventListener("DOMContentLoaded", function () {
        // Handle click event for "Assign Multiple Students" button
        document.getElementById("assignMultipleStudentsBtn").addEventListener("click", function () {
            // Clear any existing options in the select element
            var selectElement = document.getElementById("studentList");
            selectElement.innerHTML = "";

            // Fetch student names from the server using AJAX or use existing data
            // For demonstration purposes, let's assume we have an array of student names
            var students = [
                { id: 1, name: "John Doe" },
                { id: 2, name: "Jane Smith" },
                { id: 3, name: "Alice Johnson" }
                // Add more student data as needed
            ];

            // Populate the select element with student names
            students.forEach(function (student) {
                var option = document.createElement("option");
                option.value = student.id;
                option.textContent = student.name;
                selectElement.appendChild(option);
            });

            // Show the modal
            $("#assignMultipleStudentsModal").modal("show");
        });

        // Handle click event for "Assign Students" button inside the modal
        document.getElementById("assignStudentsBtn").addEventListener("click", function () {
            // Get selected student IDs and role from the form
            var studentIds = Array.from(document.getElementById("studentList").selectedOptions).map(option => option.value);
            var role = document.getElementById("role").value;

            // Perform any additional processing or validation as needed
            // For example, you can send the selected data to the server using AJAX

            // Close the modal
            $("#assignMultipleStudentsModal").modal("hide");
        });
    });



    

    </script>




</body>

</html>