<?php

echo "anyad";
include("connection.php");
$db = new dbObj(); $connection =  $db->getConnstring();
global $connection;
    
    $query="SELECT * FROM User";
    //echo $query="INSERT INTO 'User' VALUES ('dd', 'ff', 'gg')";
    if(mysqli_query($connection, $query))   {
         $response=array(
               'status' => 1,
               'status_message' =>'User Added Successfully.'
                );
      }
      else     {
         $response=array(
               'status' => 0,
               'status_message' =>'User Addition Failed.'
               );
      }   
      
      echo json_encode($response); 

?>