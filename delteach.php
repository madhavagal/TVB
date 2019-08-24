<?php
  session_start();
  $connect = mysqli_connect("localhost","root","","tvb");
  $adminid = $_SESSION['id'];
  $tid = $_POST['tid'];
  $query1 = "SELECT name FROM teacher WHERE id = $tid";
  $result1 = mysqli_query($connect, $query1);
  $row1 = mysqli_fetch_array($result1);
  $tname = $row1['name'];
  $query2 = "DELETE FROM performance WHERE teacherid = $tid";
  $query3 = "DELETE FROM review WHERE teacherid = $tid";
  $query4 = "DELETE FROM courseclass WHERE teacherid = $tid";
  $query5 = "DELETE FROM teachercourse WHERE teacherid = $tid";
  $query6 = "DELETE FROM teacher WHERE id = $tid";
  $query7 = "INSERT INTO changelog(adminid,comment) VALUES ($adminid,'Deleted Instructor $tname')";
  if(mysqli_query($connect,$query2))
  {
      if(mysqli_query($connect,$query3))
        {
          if(mysqli_query($connect,$query4))
            {
            if(mysqli_query($connect,$query5))
                {
                if(mysqli_query($connect,$query6))
                  {
                  mysqli_query($connect,$query7);
                  echo "Instructor Removed";
                }
            }
          }
      }
  }
 
?>