<?php
session_start();
$con = mysqli_connect("localhost","root","","tvb");
$adminid = $_SESSION['id'];
$cid = $_POST['cid'];
$bid = $_POST['bid'];
$ins = $_POST['teachers'];
$query4 = "SELECT name FROM course WHERE id = $cid";
$result4 = mysqli_query($con, $query4);
$row4 = mysqli_fetch_array($result4);
$cname = $row4['name'];
$l = count($ins);
for($i=0;$i<$l;$i++){
  $tid = $ins[$i];
  $query1="INSERT INTO teachercourse(teacherid,courseid,batchid) VALUES ($tid,$cid,$bid)"; 
  $query2 = "INSERT INTO changelog(adminid,comment) VALUES ($adminid,'Added instructor-id $tid to $cname - Batch $bid ')";
  if(mysqli_query($con,$query1))
  {
  mysqli_query($con,$query2);
  }
  else{
  echo '<p style="color:red;" id="addierrors">Error </p>
        <script>
        setTimeout(
          function(){
          document.location.reload();
          },1000);
      </script>';
  exit;
  }
  
}
echo '<p style="color:green;" id="addierrors"> Instructors added successfully </p>
      <script>
        setTimeout(
          function(){
          document.location.reload();
          },1000);
      </script>';



?>