<?php
  session_start();
  $connect = mysqli_connect("localhost","root","","tvb");
  $cid = $_POST['cid']; 
  $sdate = $_POST['sdate'];
  $adminid = $_SESSION['id'];
  $query1 = "SELECT MAX(batchid) as maxbatch FROM batches WHERE courseid = $cid";
  $result1 = mysqli_query($connect, $query1);
  $row1 = mysqli_fetch_array($result1);
  $mb = $row1['maxbatch'];
  $query4 = "SELECT name FROM course WHERE id = $cid";
  $result4 = mysqli_query($connect, $query4);
  $row4 = mysqli_fetch_array($result4);
  $cname = $row4['name'];
  $nb = $mb+1;
  $query2 = "INSERT INTO batches(courseid,batchid,sdate,active) VALUES ($cid,$nb,'$sdate',0)";
  $query3 = "INSERT INTO changelog(adminid,comment) VALUES ($adminid,'Added Batch $nb for $cname')";
  if(mysqli_query($connect,$query2))
  {
   mysqli_query($connect,$query3);
   echo '<p style="color:green;" id="addberrors"> Batch added successfully </p>
          <script>
        setTimeout(
          function(){
          document.location.reload();
          },1000);
      </script>';
  }
  else{
    echo '<p style="color:red;" id="addberrors">Error </p>
            <script>
        setTimeout(
          function(){
          document.location.reload();
          },1000);
      </script>';
  }
?>