<?php
  session_start();
  $connect = mysqli_connect("localhost","root","","tvb");
  $cid = $_POST['cid']; 
  $bid = $_POST['bid'];
  $act = $_POST['act'];
  $adminid = $_SESSION['id'];
  $query4 = "SELECT name FROM course WHERE id = $cid";
  $result4 = mysqli_query($connect, $query4);
  $row4 = mysqli_fetch_array($result4);
  $cname = $row4['name'];
  if($act == 1){
    $query2 = "UPDATE batches SET active = 1 WHERE courseid = $cid AND batchid = $bid";
    $query3 = "INSERT INTO changelog(adminid,comment) VALUES ($adminid,'Activated Batch $bid for $cname')";
    if(mysqli_query($connect,$query2))
    {
     mysqli_query($connect,$query3);
     echo 'Batch activated';
    }
    else{
      echo 'ERror';
    }
  }
  else{
    $query2 = "UPDATE batches SET active = 0 WHERE courseid = $cid AND batchid = $bid";
    $query3 = "INSERT INTO changelog(adminid,comment) VALUES ($adminid,'Deactivated Batch $bid for $cname')";
    if(mysqli_query($connect,$query2))
    {
     mysqli_query($connect,$query3);
     echo 'Batch deactivated';
    }
    else{
      echo 'ERror';
    }
    
  }

  
?>