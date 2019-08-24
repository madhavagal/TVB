<?php
$connect = mysqli_connect("localhost","root","","tvb");
$cno = $_POST['classno'];
$sid = $_POST['studentid'];
$tid = $_POST['teacherid'];
$cid = $_POST['courseid'];
$bid = $_POST['batchid'];
//$starn = $cid.'_'.$bid.'_'.$cno.'_star';
//$rating = $_POST[$starn];
$rating = 4;
$feedback = $_POST['feedback'];
$sugg = $_POST['suggestions'];
$query10 = "INSERT INTO review(classno,studentid,teacherid,courseid,batchid,rating,feedback,suggestions) VALUES('$cno','$sid','$tid','$cid','$bid','$rating','$feedback','$sugg')";
if(mysqli_query($connect, $query10))  
    {  
        echo '<br><p style="color:green;">Review submitted successfully</p>';  
    }  
else
    {
        echo '<br><p style="color:red;">Error</p>'; 
    }
?>  