<?php   
include('../include/connection.php');

if($_SERVER["REQUEST_METHOD"] == "POST") {

   $edit_user_id = $_POST["edit_user_id"];
    $edit_firstname = $_POST["firstname"];
    $edit_lastname = $_POST["lastname"];
    $edit_username = $_POST["username"];
    $edit_password = $_POST["password"];


    $sql_update_user = "UPDATE users SET firstname= '$edit_firstname', lastname='$edit_lastname',
    username='$edit_username' WHERE user_id='$edit_user_id'";

    if($connection->query($sql_update_user) === TRUE){
       echo "record successfully updated";
    }else{
       echo "Error updating record: " . $connection->error;
    }
}$connection->close();
?>