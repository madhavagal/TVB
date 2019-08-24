<?php
  session_start();
  $connect = mysqli_connect("localhost","root","","tvb");
  $adminid = $_SESSION['id'];
  $sid = $_POST['sid'];
  $query1 = "SELECT name FROM student WHERE id = $sid";
  $result1 = mysqli_query($connect, $query1);
  $row1 = mysqli_fetch_array($result1);
  $sname = $row1['name'];
  $query2 = "DELETE FROM performance WHERE studentid = $sid";
  $query3 = "DELETE FROM review WHERE studentid = $sid";
  $query5 = "DELETE FROM studentcourse WHERE studentid = $sid";
  $query6 = "DELETE FROM student WHERE id = $sid";
  $query7 = "INSERT INTO changelog(adminid,comment) VALUES ($adminid,'Deleted Student $sname')";
  if(mysqli_query($connect,$query2))
  {
      if(mysqli_query($connect,$query3))
        {
            if(mysqli_query($connect,$query5))
                {
                if(mysqli_query($connect,$query6))
                  {
                  mysqli_query($connect,$query7);
                  echo "Student Removed";
                }
            } 
      }
  }
 
?>