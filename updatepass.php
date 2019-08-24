<?php
session_start();
$connect = mysqli_connect("localhost","root","","tvb");
$id = $_SESSION['id'];
$cat = $_SESSION['cat'];
$oldpass = md5($_POST['oldpass']);
$newpass = md5($_POST['newpass']);
$query2 = "SELECT password FROM $cat WHERE id = $id";
$result2 = mysqli_query($connect, $query2);
$row2 = mysqli_fetch_array($result2);
$curpass = $row2['password'];
if($oldpass == $newpass and $oldpass == $curpass ){
  echo "<p style='color:red;' id='updatepasserrors'>New password can not be same as old password</p>";
} 
elseif($oldpass != $curpass){
  echo "<p style='color:red;' id='updatepasserrors'>Enter the correct password</p>";
}
else{
  $query3 = "UPDATE $cat SET `password` = '$newpass' WHERE id = $id";
  if(mysqli_query($connect, $query3) == TRUE){
  echo "<p style='color:green;' id='updatepasserrors'>Password updated successfully</p>
        <script>
        setTimeout(
          function(){
          document.location.reload();
          },1000);
      </script>";
  }
  else{
  echo "<p style='color:red;' id='updatepasserrors'>Please try again</p>";
  }
}