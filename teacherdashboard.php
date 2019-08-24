<?php
  if (!isset($_SESSION)) session_start();
  $connect = mysqli_connect("localhost", "root", "", "tvb");
  $id=$_SESSION['id'];
  $query2 = "SELECT name,email from teacher WHERE id=$id";
  $result2 = mysqli_query($connect, $query2);
  $row2 = mysqli_fetch_array($result2);
  $name = $row2['name'];
  $email = $row2['email'];
  if(!isset($_SESSION['email'])){
    header('location:index.php');
  }
  if($email != $_SESSION['email']){
     echo '<script>alert("Acess denied. Log in again!")</script>';
     echo "<script> location.href='index.php'; </script>";
         exit;
  }
?>
<?php
  if(isset($_POST['signout'])){
    session_destroy();
	 unset($_SESSION['email']); 
    header('location:index.php');
  }
?>
<?php 
  if(isset($_POST["updatepropic"]))  
 {  
      $file = addslashes(file_get_contents($_FILES["profilepic"]["tmp_name"]));  
//      $query = "INSERT INTO tbl_images(name) VALUES ('$file')";
      $query18 = "UPDATE teacher SET `photo` = '$file' WHERE id = $id";
      if(mysqli_query($connect, $query18))  
      {  
           echo '<script>alert("Profile Picture Updated")</script>'; 
           header("Refresh:0");
      }  
 }  
?>
<?php  
    $connect = mysqli_connect("localhost", "root", "", "tvb");
    $id=$_SESSION['id'];
    $query1 = "SELECT name,email,photo,phno from teacher WHERE id=$id";
    $result1 = mysqli_query($connect, $query1);
    $row1 = mysqli_fetch_array($result1);
    $name = $row1['name'];
    $email = $row1['email'];
    $photo = $row1['photo'];
    $phone = $row1['phno'];
    $profilepic = '';
    $upclass = '<ul>';                               
    if(empty($photo))
    { 
        $profilepic = '<img src="assets1/default.png" class="avatar border-gray" alt="Your profile pic here" />';
    }
    else
    {
        $profilepic = '<img src="data:image/jpeg;base64,'.base64_encode($photo ).'" class="avatar border-gray" alt="Your profile pic here" />';
    }
                                    
    $query2 = "SELECT courseid, batchid FROM teachercourse WHERE teacherid = $id AND (courseid,batchid) IN (SELECT courseid,batchid FROM batches WHERE active = 1)";
    $result2 = mysqli_query($connect, $query2);
    $dyncourses = '';
     while($row2 = mysqli_fetch_array($result2))  
     {
       $cid = $row2['courseid'];
       $bid = $row2['batchid'];
                                    //   echo "Course id - $cid Batch id- $bid";
       $query3 = "SELECT name FROM course WHERE id = $cid";
       $result3 = mysqli_query($connect, $query3);
       $row3 = mysqli_fetch_array($result3);
       $cname = $row3['name'];
       $coursehead = '<div class="container-fluid course"><h4 class="nomargin" style="margin-bottom:10px;font-weight:bold;">'.$cname.' - Batch '.$bid.' :</h4><ul>';
       $query5 = "SELECT classno,classdate,topic FROM courseclass WHERE courseid = $cid AND batchid = $bid AND teacherid = $id AND classdate > CURRENT_DATE ORDER BY classdate ASC";
       $result5 = mysqli_query($connect, $query5);
       if(mysqli_num_rows($result5) == 0){
            $msg = '<h5>No upcoming classes</h5>';
            $coursehead .= $msg;
            $coursehead .= '</ul><br></div>';
            $dyncourses .= $coursehead;
        }
        else{
         while($row5 = mysqli_fetch_array($result5)){
           $update = date("d-m-Y",strtotime($row5['classdate']));
           if(empty($row5['topic']))
           {
             $topic = 'Not added yet';
           }
           else{
               $topic = $row5['topic'];
           }
           $cno = $row5['classno'];
           $upclass = "<li>
                          <div class='row'>
                            <div class='col-md-4'>
                              <h5 style='font-size:20px;'>Class $cno <br><small>Date - $update</small><br><small>Topic - $topic</small></h5>
                            </div>
                            <div class='col-md-8'>
                              <form class='topicform'>
                                <input type='hidden' name='courseid' value='$cid'>
                                <input type='hidden' name='batchid' value='$bid'>
                                <input type='hidden' name='classno' value='$cno'>
                                <input type='hidden' name='teacherid' value='$id'>
                                <div class='row'>
                                  <div class='col-md-8'>
                                    <input type='text' class='form-control' name='topic' placeholder='Update topic for the class' required>
                                  </div>
                                  <div class='col-md-4'>
                                     <button type='submit' class='btn btn-primary' style='cursor:pointer;'>Update</button>
                                  </div>
                                </div>
                              </form>
                            </div>
                          </div>
                          </li>";
           $coursehead .= $upclass;
          }
          $coursehead .= '</ul><hr style="height: 0.04rem; border: none; color:#333; background-color:#333;"></ul></div>';
          $dyncourses .= $coursehead;
        }
  
      } 
   
     ?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="assets1/logo.png">
  <title>TVB - teacher Dashboard</title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
  <!-- CSS Files -->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="assets/css/light-bootstrap-dashboard.css?v=2.0.0 " rel="stylesheet" />
  <link href="teachdash.css?ver=<?=time();?>" rel="stylesheet" />
  <script src="jquery-3.4.1.min.js"></script>
</head>

<body onload="showNotification('top','right')">
  <div class="wrapper">
    <div class="sidebar" data-image="assets1/1-01.jpeg" data-color="red">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | blue | green | orange | red"

        Tip 2: you can also add an image using data-image tag
    -->
      <div class="sidebar-wrapper">
        <div class="logo">
          <a href="https://www.thevalleybootcamp.com" class="simple-text">
            <img src="assets1/logo.png">
          </a>
        </div>
        <ul class="nav">
          <li class="nav-item active">
            <a class="nav-link" href="teacherdashboard.php">
              <i class="fa fa-user"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li>
            <a class="nav-link" href="teachreviews.php">
              <i class="nc-icon nc-icon nc-paper-2"></i>
              <p>Reviews</p>
            </a>
          </li>
        </ul>
      </div>
    </div>
    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg " color-on-scroll="500">
        <div class="container-fluid">
          <p class="navbar-brand">Welcome <?php echo $name; ?></p>
          <button href="" class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar burger-lines"></span>
            <span class="navbar-toggler-bar burger-lines"></span>
            <span class="navbar-toggler-bar burger-lines"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end" id="navigation">
            <ul class="navbar-nav ml-auto">
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <span class="no-icon">Account</span>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                  <button type="button" class="dropdown-item" data-toggle="modal" data-target="#updatepassmodal">Update Password</button>
                  <button type="button" class="dropdown-item" data-toggle="modal" data-target="#updatepropicmodal">Update Profile Picture</button>
                </div>
              </li>
              <li class="nav-item">
                <form action="teacherdashboard.php" method="post">
                  <button class="btn nav-link" name="signout" style="border-width: 0px;border-color: white;font-size:16px;cursor:pointer;" id="logout" href="#">
                    <span class="no-icon">Log out</span>
                  </button>
                </form>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <!-- End NavBar -->

      <div class="content">
        <div class="container-fluid">

          <div class="row">
            <div class="col-md-8">
              <div class="card">
                <div class="header">
                  <center>
                    <h3 class="title nomargin" style="margin-top:22px;">Your active batches and upcoming classes : </h3>
                    <br>
                  </center>
                </div>
                <div class="content">
                  <?php echo $dyncourses; ?>
                </div>
              </div>
            </div>  
            <div class="col-md-4">
              <div class="card card-user">
                <div class="image">
                  <img src="assets1/books.jpg" style="width:100%" alt="..." />
                </div>
                <div class="content">
                  <div class="author">
<!--                    <a href="#">-->
                      <?php echo $profilepic; ?>
                      <h3 class="title nomargin"><?php echo $name?><br><br>
                        <small><i class="fa fa-envelope"></i> <?php echo $email ?></small><br>
                        <small><i class="fa fa-phone"></i> <?php echo $phone ?></small>
                      </h3>
<!--                    </a>-->
                    <br>
                  </div>
                </div>
              </div>
            </div>
          </div>
         
        </div>
      </div>


    </div>
  </div>


  <!-- Modals   -->

  <div class="modal fade" id="updatepassmodal" tabindex="-1" role="dialog" aria-labelledby="updatepassmodal" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Update Password</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p id="updatepasserrors"></p>
          <form id="updatepassform">
            <div class="form-group">
              <label>Current Password</label>
              <input type="password" class="form-control" name="oldpass" placeholder="Enter current password" required>
            </div>
            <div class="form-group">
              <label>Enter New Password</label>
              <input type="password" class="form-control" name="newpass" placeholder="Enter new Password" required>
            </div>
            <button type="submit" class="btn btn-primary" name="updatepass">Update</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="updatepropicmodal" tabindex="-1" role="dialog" aria-labelledby="updatepromodal" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Update Profile Picture</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="post" action="teacherdashboard.php" enctype="multipart/form-data">
            <div class="form-group">
              <label for="exampleFormControlFile1">Upload your passport-size picture (&lt; 1MB)</label>
              <input type="file" class="form-control-file" name="profilepic" id="profilepic">
            </div>
            <button type="submit" class="btn btn-primary" name="updatepropic" id="updatepropic" value="insert">Update</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script>
    $(document).ready(function() {
      $("#updatepassform").submit(function(e) {
//        alert("form submitted");
        e.preventDefault();
        var form2 = $(this);
        var url2 = "updatepass.php";
        //        alert(form.serialize());
        $.ajax({
          type: "POST",
          url: url2,
          data: form2.serialize(),
          success: function(data) {
            var result2 = $.trim(data);
            $("#updatepasserrors").replaceWith(data);
          }
        });

      });

    });

  </script>
  <script>
    $(document).ready(function() {
      $("form.topicform").submit(function(e) {
        //        alert("form submitted");
        e.preventDefault();
        var form2 = $(this);
        var url2 = "addctopic.php";
        $.ajax({
          type: "POST",
          url: url2,
          data: form2.serialize(),
          success: function(data) {
            var result = $.trim(data);
            if (result == "success") {
              form2.replaceWith("<center><h6 style='color: green;'>Topic updated successfully</h6></center>");
              setTimeout(
                function() {
                  document.location.reload();
                }, 1000);

            } else {
              form2.replaceWith("<center><h6 style='color: red;'>Error</h6></center>");
              setTimeout(
                function() {
                  document.location.reload();
                }, 1000);

            }
          }

        });

      });

    });

  </script>
  <script>
    function showNotification(from, align) {
      color = Math.floor((Math.random() * 4) + 1);

      $.notify({
        icon: "nc-icon nc-app",
        message: "Welcome to <b>The Valley Bootcamp Review Portal</b>"

      }, {
        type: type[color],
        timer: 4000,
        placement: {
          from: from,
          align: align
        }
      });
    }

  </script>

</body>

<script src="assets/js/core/jquery.3.2.1.min.js" type="text/javascript"></script>
<script src="assets/js/core/popper.min.js" type="text/javascript"></script>
<script src="assets/js/core/bootstrap.min.js" type="text/javascript"></script>
<!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
<script src="assets/js/plugins/bootstrap-switch.js"></script>
<!--  Chartist Plugin  -->
<script src="assets/js/plugins/chartist.min.js"></script>
<!--  Notifications Plugin    -->
<script src="assets/js/plugins/bootstrap-notify.js"></script>
<!-- Control Center for Light Bootstrap Dashboard: scripts for the example pages etc -->
<script src="assets/js/light-bootstrap-dashboard.js?v=2.0.0 " type="text/javascript"></script>
<!-- Light Bootstrap Dashboard DEMO methods, don't include it in your project! -->
<script src="assets/js/demo.js"></script>

</html>
