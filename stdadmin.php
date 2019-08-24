<?php
  if (!isset($_SESSION)) session_start();
  $connect = mysqli_connect("localhost", "root", "", "tvb");
  $id=$_SESSION['id'];
  $query2 = "SELECT name,email from admin WHERE id=$id";
  $result2 = mysqli_query($connect, $query2);
  $row2 = mysqli_fetch_array($result2);
  $aname = $row2['name'];
  $email = $row2['email'];
  if(!isset($_SESSION['email'])){
    header('location:index.php');
  }
  if(!isset($_GET['sid'])){
    header('location:adminstd.php');
  }
  if($email != $_SESSION['email']){
     echo '<script>alert("Acess denied. Log in again!")</script>';
     echo "<script> location.href='index.php'; </script>";
         exit;
  }
?>
<?php
  $connect = mysqli_connect("localhost", "root", "", "tvb");
  $id=$_GET['sid'];
  $query1 = "SELECT name,email,photo from student WHERE id=$id";
  $result1 = mysqli_query($connect, $query1);
  $row1 = mysqli_fetch_array($result1);
  $name = $row1['name'];
  $email = $row1['email'];
  $photo = $row1['photo'];
  if(empty($photo))
    {
      $profilepic = '<img src="assets1/default.png" width="100%" height = "auto" style="border: 1px black solid; margin-left:30px;" alt="Your profile pic here" />';
    }
    else{
      $profilepic = '<img src="data:image/jpeg;base64,'.base64_encode($photo ).'" width="100%" height = "auto" style="border: 1px black solid; margin-left:30px;"  alt="Your profile pic here" />';
    }
  $query2 = "SELECT courseid, batchid FROM studentcourse WHERE studentid = $id";
  $result2 = mysqli_query($connect, $query2);
  $courses='<ul>';
  $courseoptn = '<option value="0">Select a course</option>';
  while($row2 = mysqli_fetch_array($result2)){
    $cid = $row2['courseid'];
    $bid = $row2['batchid'];
    $query3 = "SELECT name FROM course WHERE id= $cid";
    $result3 = mysqli_query($connect, $query3);
    $row3 = mysqli_fetch_array($result3);
    $cname = $row3['name'];
    $courseoptn .= '<option value="'.$cid.'">'.$cname.'</option>';
    $courses .= '<li>'.$cname.' - Batch '.$bid.'</li>';
  }
  $courses .= '</ul>';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="assets1/logo.png">
  <title>TVB - Admin Dashboard</title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
  <!-- CSS Files -->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="assets/css/light-bootstrap-dashboard.css?v=2.0.0&ver=<?=time();?> " rel="stylesheet" />
  <link href="stdadmin.css" rel="stylesheet" />
  <script src="jquery-3.4.1.min.js"></script>
</head>

<body>
  <div class="wrapper">
    <div class="sidebar" data-image="assets/img/sidebar-4.jpg" data-color="red">
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
          <li>
            <a class="nav-link" href="admindashboard.php">
              <i class="nc-icon nc-icon nc-paper-2"></i>
              <p>Courses</p>
            </a>
          </li>
          <li>
            <a class="nav-link" href="adminfaculty.php">
              <i class="fa fa-users"></i>
              <p>Faculty</p>
            </a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="adminstd.php">
              <i class="fa fa-graduation-cap"></i>
              <p>Students</p>
            </a>
          </li>
          <li>
            <a class="nav-link" href="adminviewreviews.php">
              <i class="fa fa-comments-o"></i>
              <p>View Reviews</p>
            </a>
          </li>
          <li>
            <a class="nav-link" href="changelog.php">
              <i class="fa fa-pencil"></i>
              <p>Changelog</p>
            </a>
          </li>


        </ul>
      </div>
    </div>
    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg " color-on-scroll="500">
        <div class="container-fluid">
          <p class="navbar-brand">Welcome <?php echo $aname; ?></p>
          <button href="" class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar burger-lines"></span>
            <span class="navbar-toggler-bar burger-lines"></span>
            <span class="navbar-toggler-bar burger-lines"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end" id="navigation">
            <ul class="navbar-nav ml-auto">
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <span class="no-icon">Action</span>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                  <button type="button" class="dropdown-item" data-toggle="modal" data-target="#addadminmodal">Add Admin</button>
                  <button type="button" class="dropdown-item" data-toggle="modal" data-target="#updatepassmodal">Update password</button>
                </div>
              </li>
              <li class="nav-item">
                <form action="admindashboard.php" method="post">
                  <button class="btn nav-link" name="signout" style="border-width: 0px;border-color: white;font-size:16px;cursor:pointer;" id="logout" href="#">
                    <span class="no-icon">Log out</span>
                  </button>
                </form>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <!-- End Navbar -->
      <div class="content">
        <div class="container-fluid">
          <div class="section">

            <div class="row">
              <div class="col-md-2" style="margin-right:10px;">
                <?php echo $profilepic; ?>
              </div>
              <div class="col-md-9">
                <br>
                <h2 class="nomargin" style="font-weight:bold;"><?php echo $name;?></h2>
                <br>
                <h4 class="nomargin">Courses enrolled - </h4>
                <h5 class="nomargin" style="font-weight:normal;font-size:20px;"><?php echo $courses;?></h5>
              </div>
            </div>
            <br>
            <button type="button" class="btn btn-danger custbtn" data-toggle="modal" data-target="#delstdmodal" style="margin-left:30px;padding-left: 20px;padding-right: 20px;margin-bottom:20px;">Remove Student</button>
            <br>
            <div class="container-fluid">
              <div class="row">
                <div class="col-md-2" style="margin-left:10px;"><select class="form-control" name="course" id="course">
                    <?php echo $courseoptn; ?>
                  </select></div>
              </div>
            </div>
            <br>

            <div class="row">
              <div class="col"></div>
              <div class="col-md-8">
                <p id="res"></p>
              </div>
              <div class="col"></div>
            </div>

          </div>
        </div>
      </div>

    </div>
  </div>

  <!--Modals-->

  <div class="modal fade" id="addadminmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <p class="modal-title modal-heading" id="exampleModalLabel">Add Admin</p>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p id="addaerrors"></p>
          <form id="addadminform">
            <div class="form-group">
              <label for="exampleInputEmail1">Name</label>
              <input type="text" name="aname" class="form-control" id="aname" placeholder="Enter Admin Name" required>
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Email address</label>
              <input type="email" name="aemail" class="form-control" id="aemail" placeholder="Enter Admin Email" required>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Phone number</label>
              <input type="tel" name="aphno" class="form-control" id="aphone" placeholder="Enter Admin Phone Number" required>
            </div>
            <button type="submit" class="btn btn-primary ">Submit</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="updatepassmodal" tabindex="-1" role="dialog" aria-labelledby="updatepassmodal" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <p class="modal-title modal-heading" id="exampleModalLabel">Update Password</p>
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
            <button type="submit" class="btn btn-primary " name="updatepass">Update</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="delstdmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Remove Student</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p style="color:black; font-size:18px;">Are you sure you want to delete all data related to this student?</p>
          <p style="color:red; font-size:12px;">Warning: This action is irreversible</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-danger" id="delsbtn">Delete</button>
        </div>
      </div>
    </div>
  </div>


  <script>
    $(document).ready(function() {
      var course = $("#course").val();
        //        alert(course);
        var url = "stdadminajax.php";
        var sid = <?php echo $id; ?>;
        //        alert(sid);
        $.ajax({
          type: "POST",
          url: url,
          data: {
            courseid: course,
            sid: sid
          },
          success: function(data) {
            var result = $.trim(data);
            //            alert(result);
            $("#res").html(result);
          }

        });
      
      $("#course").change(function() {
        var course = $("#course").val();
        //        alert(course);
        var url = "stdadminajax.php";
        var sid = <?php echo $id; ?>;
        //        alert(sid);
        $.ajax({
          type: "POST",
          url: url,
          data: {
            courseid: course,
            sid: sid
          },
          success: function(data) {
            var result = $.trim(data);
            //            alert(result);
            $("#res").html(result);
          }

        });

      });
    });

  </script>
  <script>
    $(document).ready(function() {
      $("#delsbtn").click(function(e) {
        var sid = <?php echo $id; ?>;
        var url5 = "delstd.php";
        $.ajax({
          type: "POST",
          url: url5,
          data: {
            sid: sid
          },
          success: function(data) {
            var result = $.trim(data);
            alert(result);
            window.location.replace("adminstd.php");
          }

        });
      });
    });

  </script>


  <script>
    $(document).ready(function() {
      $("#addadminform").submit(function(e) {
        alert("form submitted");
        e.preventDefault();
        var form = $(this);
        var url = "addadmin.php";
        $.ajax({
          type: "POST",
          url: url,
          data: form.serialize(),
          success: function(data) {
            var result = $.trim(data);
            $("#addaerrors").replaceWith(data);
          }

        });

      });

    });

  </script>
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

</body>
<!--   Core JS Files   -->
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
