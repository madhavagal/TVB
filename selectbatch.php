<?php
  $connect = mysqli_connect("localhost","root","","tvb");
  $cid = $_POST['cid']; 
  $query1 = "SELECT batchid FROM batches WHERE courseid = $cid";
  $result1 = mysqli_query($connect, $query1);
  $batchoptn = '<option value="0">Select a batch</option>';
  while($row1 = mysqli_fetch_array($result1)){
    $bid = $row1['batchid'];
    $batchoptn .= '<option value="'.$bid.'">Batch '.$bid.'</option>';
  }
  echo $batchoptn;
?>