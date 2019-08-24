<?php
  $connect = mysqli_connect("localhost","root","","tvb");
  $cid = $_POST['cid'];  
  $bid = $_POST['bid'];
  $query1 = "SELECT teacherid FROM teachercourse WHERE courseid = $cid AND batchid = $bid";
  $result1 = mysqli_query($connect, $query1);
  $toptn = '';
  while($row1 = mysqli_fetch_array($result1)){
    $tid = $row1['teacherid'];
    $query2 = "SELECT name FROM teacher WHERE id = $tid";
    $result2 = mysqli_query($connect, $query2);
    $row2 = mysqli_fetch_array($result2);
    $tname = $row2['name'];
    $toptn .= '<option value="'.$tid.'">'.$tname.'</option>';
  }
  echo $toptn;
?>
