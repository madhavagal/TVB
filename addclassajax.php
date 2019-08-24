<?php
  session_start();
  $connect = mysqli_connect("localhost","root","","tvb");
  $adminid = $_SESSION['id'];
  $cid = $_POST['cid'];
  $bid = $_POST['bid'];
  $cdate = $_POST['addcdate'];
  $ctid = $_POST['addct'];
  $ctopic = $_POST['addctopic'];
  $query1 = "SELECT MAX(classno) as maxc FROM courseclass WHERE courseid = $cid AND batchid = $bid";
  $result1 = mysqli_query($connect, $query1);
  $row1 = mysqli_fetch_array($result1);
  $mc = $row1['maxc'];
  $nc = $mc + 1;
  $query4 = "SELECT name FROM course WHERE id = $cid";
  $result4 = mysqli_query($connect, $query4);
  $row4 = mysqli_fetch_array($result4);
  $cname = $row4['name'];
  $query5 = "SELECT name FROM teacher WHERE id = $ctid";
  $result5 = mysqli_query($connect, $query5);
  $row5 = mysqli_fetch_array($result5);
  $tname = $row5['name'];
  $query2 = "INSERT INTO courseclass(classno,courseid,batchid,teacherid,classdate,topic) VALUES ($nc,$cid,$bid,$ctid,'$cdate','$ctopic')";
  $query3 = "INSERT INTO changelog(adminid,comment) VALUES ($adminid,'Added Class $nc By $tname for $cname - Batch $bid')";
  if(mysqli_query($connect,$query2))
  {
   mysqli_query($connect,$query3);
   echo '<p style="color:green;" id="addcerrors">Class added successfully </p>
        <script>
        setTimeout(
          function(){
          document.location.reload();
          },1000);
      </script>';
  }
  else{
    echo '<p style="color:red;" id="addcerrors">Error </p>
        <script>
        setTimeout(
          function(){
          document.location.reload();
          },1000);
      </script>';
  }
?>