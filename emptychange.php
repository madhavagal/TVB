<?php
  session_start();
  $connect = mysqli_connect("localhost","root","","tvb");
  $adminid = $_SESSION['id'];
  $query1 = "DELETE FROM changelog";
  $query2 = "INSERT INTO changelog(adminid,comment) VALUES ($adminid,'Emptied the Changelog')";
  if(mysqli_query($connect,$query1))
  { 
    mysqli_query($connect,$query2);  
  }
 
?>