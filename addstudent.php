<?php
session_start();
$con = mysqli_connect("localhost","root","","tvb");
$adminid = $_SESSION['id'];
$name = $_POST['sname'];
$email = $_POST['semail'];
$phone = $_POST['sphno'];
$query1 = "SELECT id FROM student WHERE email = '$email'";
$result1 = mysqli_query($con,$query1);
if(mysqli_num_rows($result1) != 0){
  echo '<p style="color:red;" id="addserrors"> Account already exists </p>';
}
else{
  $pass = md5($email);
  $query2 = "INSERT INTO student(name,email,phno,password) VALUES ('$name','$email',$phone,'$pass')";
  $query3 = "INSERT INTO changelog(adminid,comment) VALUES ($adminid,'Added student $name')";
if(mysqli_query($con,$query2))
{
 mysqli_query($con,$query3);
 echo '<p style="color:green;" id="addserrors"> Student added successfully </p>
        <script>
        setTimeout(
          function(){
          document.location.reload();
          },1000);
      </script>';
}
else{
  echo '<p style="color:red;" id="addserrors">Error </p>
        <script>
        setTimeout(
          function(){
          document.location.reload();
          },1000);
      </script>';
}
}
?>
