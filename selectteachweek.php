<?php
  $connect = mysqli_connect("localhost","root","","tvb");
  $cid = $_POST['cid']; 
  $tid = $_POST['tid']; 
  $bid = $_POST['bid'];
  $query1 = "SELECT classno FROM courseclass WHERE courseid = $cid AND batchid = $bid AND teacherid = $tid AND classdate < CURRENT_DATE ORDER BY classno DESC";
  $result1 = mysqli_query($connect, $query1);
  $weekoptn = '<option value="0">Select a class</option>';
  while($row1 = mysqli_fetch_array($result1)){
    $week = $row1['classno'];
    $weekoptn .= '<option value="'.$week.'">Class '.$week.'</option>';
  }
  echo $weekoptn;
?>
