<?php 
include("../include/connection.php");

if($_SERVER["REQUEST_METHOD"]== "POST"){
    $firstname= $_POST["firstname"];
    $lastname= $_POST["lastname"];
    $username= $_POST["username"];
    $password= $_POST["password"];
    $role= $_POST["role"];


   $insert_sql= "INSERT INTO users(firstname, lastname, username, password, role) VALUES
    ('$firstname','$lastname','$username','$password','$role' )";

$result = $connection->query($insert_sql);

header("Location: admin_view_user.php");
                exit();
}

?>