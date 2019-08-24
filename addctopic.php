<?php
$con = mysqli_connect("localhost","root","","tvb");
$cno = $_POST['classno'];
$tid = $_POST['teacherid'];
$cid = $_POST['courseid'];
$bid = $_POST['batchid'];
$topic = $_POST['topic'];
$query = "UPDATE courseclass SET topic = '$topic' WHERE classno = $cno AND courseid = $cid AND batchid = $bid AND teacherid = $tid";
if(mysqli_query($con,$query))
{
  echo "success";
}
else{
  echo "fail";
}
?>  