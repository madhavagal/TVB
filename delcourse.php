<?php
  session_start();
  $connect = mysqli_connect("localhost","root","","tvb");
  $adminid = $_SESSION['id'];
  $cid = $_POST['cid'];
  $query1 = "SELECT name FROM course WHERE id = $cid";
  $result1 = mysqli_query($connect, $query1);
  $row1 = mysqli_fetch_array($result1);
  $cname = $row1['name'];
  $query2 = "DELETE FROM performance WHERE courseid = $cid";
  $query3 = "DELETE FROM review WHERE courseid = $cid";
  $query4 = "DELETE FROM courseclass WHERE courseid = $cid";
  $query5 = "DELETE FROM teachercourse WHERE courseid = $cid";
  $query6 = "DELETE FROM studentcourse WHERE courseid = $cid";
  $query7 = "DELETE FROM batches WHERE courseid = $cid";
  $query8 = "DELETE FROM course WHERE id = $cid";
  $query9 = "INSERT INTO changelog(adminid,comment) VALUES ($adminid,'Deleted Course $cname')";
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
                        if(mysqli_query($connect,$query7))
                         {
                            if(mysqli_query($connect,$query8))
                             {
                                mysqli_query($connect,$query9);
                                echo "Course Deleted";
                             }
                         } 
                     }
                  }
                }
        }
  }

 
?>