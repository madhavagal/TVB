<?php
session_start();
$con = mysqli_connect("localhost","root","","tvb");
$errors = array(); 
$adminid = $_SESSION['id'];
$name = $_POST['tname'];
$email = $_POST['temail'];
$phone = $_POST['tphno'];
$query1 = "SELECT id FROM teacher WHERE email = '$email'";
$result1 = mysqli_query($con,$query1);
if(mysqli_num_rows($result1) != 0){
  echo '<p style="color:red;" id="addterrors"> Instructor already exists </p>';
}
else{
  $pass = md5($email);
  $query2 = "INSERT INTO teacher(name,email,phno,password) VALUES ('$name','$email',$phone,'$pass')";
  $query3 = "INSERT INTO changelog(adminid,comment) VALUES ($adminid,'Added Instructor $name')";
if(mysqli_query($con,$query2))
{
 mysqli_query($con,$query3);
 echo '<p style="color:green;" id="addterrors"> Instructor added successfully </p>
      <script>
        setTimeout(
          function(){
          document.location.reload();
          },1000);
      </script>';
}
else{
  echo '<p style="color:red;" id="addterrors">Error </p>
        <script>
        setTimeout(
          function(){
          document.location.reload();
          },1000);
      </script>';
}
}
?>
