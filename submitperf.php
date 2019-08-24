<?php
$con = mysqli_connect("localhost","root","","tvb");
$cno = $_POST['classno'];
$sid = $_POST['studentid'];
$tid = $_POST['teacherid'];
$cid = $_POST['courseid'];
$bid = $_POST['batchid'];
$pro = $_POST['perf'];
$query;
if(isset($_POST['project'])) 
{
  $grade = $_POST["radioc$cid"."b$bid"."s$sid"];
  $query = "INSERT INTO performance(classno,studentid,teacherid,courseid,batchid,progress,project) VALUES ('$cno','$sid','$tid','$cid','$bid','$pro','$grade')";  
}
else{
  $query = "INSERT INTO performance(classno,studentid,teacherid,courseid,batchid,progress) VALUES ('$cno','$sid','$tid','$cid','$bid','$pro')";
}
if(mysqli_query($con,$query))
  {
    echo "success";
  }
else{
  echo "fail";
}
?>  