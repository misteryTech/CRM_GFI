<?php 
  $localhost= "localhost";
  $username= "root";
  $password= "";
  $dbname= "soms_db";

  $connection = mysqli_connect($localhost,$username,$password,$dbname);

  if($_SERVER["REQUEST_METHOD"]== "POST"){
        
      if(isset($_POST["delete_btn"])){


        //delete id from user_id input_field
                $user_id = $_POST["user_id"];
        
        //delete query from users_info
                $delete_query = "DELETE FROM users WHERE user_id = $user_id ";
                
        //process the delete_query
                $result_delete = $connection->query($delete_query);
        
                header("Location: admin_view_user.php");
                exit();
          }
        
  }
?>
