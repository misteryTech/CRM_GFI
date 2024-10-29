<?php
$localhost = "localhost";
$username = "root";
$password = "";
$dbname = "crm_gfi";

$connection = mysqli_connect($localhost, $username, $password, $dbname);

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    echo "Connected successfully";
}
?>
