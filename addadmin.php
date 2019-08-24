<?php
$con = mysqli_connect("localhost","root","","tvb");
$errors = array(); 
$name = $_POST['aname'];
$email = $_POST['aemail'];
$phone = $_POST['aphno'];
$query1 = "SELECT id FROM admin WHERE email = '$email'";
$result1 = mysqli_query($con,$query1);
if(mysqli_num_rows($result1) != 0){
  echo '<p style="color:red;" id="addaerrors"> Account already exists </p>';
}
else{
  $pass = md5($email);
  $query2 = "INSERT INTO admin(name,email,phno,password) VALUES ('$name','$email',$phone,'$pass')";
if(mysqli_query($con,$query2))
{
 echo '<p style="color:green;" id="addaerrors"> Admin added successfully </p>
        <script>
        setTimeout(
          function(){
          document.location.reload();
          },1000);
      </script>';
}
else{
  echo '<p style="color:red;" id="addaerrors">Error </p>
        <script>
        setTimeout(
          function(){
          document.location.reload();
          },1000);
      </script>';
}
}
?>
