<?php 
session_start();
$email="";
$errors= array();
//connect to the database
$db=mysqli_connect('localhost','root','','tvb');

  if (isset($_POST['signin'])) {

	$email=$_POST['email'];
	$pass=$_POST['password'];
  $password = md5($pass);
  $cat=$_POST['cat'];
	if(empty($email)){
		array_push($errors, "E-mail is required");

	} 
	if(empty($password)){
		array_push($errors, "Password is required");

	}
	if (count($errors)==0) {
	 	
	 	$query="SELECT id FROM $cat WHERE email='$email' AND password='$password' ";
	 	$result=mysqli_query($db,$query);
	 	if(mysqli_num_rows($result)==1) {
      $row = mysqli_fetch_array($result);
      $id = $row['id'];
	   $_SESSION['email'] = $email;
      $_SESSION['id'] = $id;
      $_SESSION['cat'] = $cat;
     if($cat == "student"){
       header("location: studentdashboard.php");
     }
      elseif($cat == "teacher"){
       header("location: teacherdashboard.php");
     }
      elseif($cat == "admin"){
       header("location: admindashboard.php");
     }

	 	}
	 	else{
	 		array_push($errors,"Invalid username/password");
	 	}
	 } 

}
?>