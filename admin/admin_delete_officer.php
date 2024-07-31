<?php
include("../include/connection.php");

if (isset($_GET['id'])) {
  $id = $_GET['id'];

  // Perform the database deletion operation
  $query = "DELETE FROM officers WHERE id='$id'";
  $result = mysqli_query($connection, $query);

  if ($result) {
    echo "<div class='alert alert-success'>Officer deleted successfully.</div>";
  } else {
    echo "<div class='alert alert-danger'>Error: Failed to delete officer.</div>";
  }
}

// Redirect back to the officer list page
header("Location: admin_officers.php");
exit();
?>