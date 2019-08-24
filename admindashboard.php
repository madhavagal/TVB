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
  if($email != $_SESSION['email']){
     echo '<script>alert("Acess denied. Log in again!")</script>';
     echo "<script> location.href='index.php'; </script>";
         exit;
  }
?>
<?php
  $connect = mysqli_connect("localhost", "root", "", "tvb");
  $query1 = "SELECT name,id,photo FROM course";
  $result1 = mysqli_query($connect, $query1);
  $dyncourses = '<center><div class="row">';
  $i = 1;
  while($row1 = mysqli_fetch_array($result1)){
    $cname = $row1['name'];
    $cphoto = $row1['photo'];
    $cimg = '<img src="data:image/jpeg;base64,'.base64_encode($cphoto).'" height="150px" width="319px" class="card-img-top" alt="No Photo Available"/>';
    $cid = $row1['id'];
    $coursediv = '<div class="card border-dark mb-3" style="width: 18rem;">
                    '.$cimg.'
                    <div class="card-body">
                      <center><h4 class="card-title" style="font-weight:bold;">'.$cname.'</h4></center>
                      <hr style="height:0.06rem;border:none;color:#333;background-color:#333;" >
                      <center><a href="admcourse.php?cid='.$cid.'" class="btn btn-primary  ">View Details</a></center>
                    </div>
                  </div>';
      if ($i % 3 == 0) { // if $i is divisible by our target number (in this case "3")
          $dyncourses .= '<div class="col-md-4">' . $coursediv . '</div></div><br><div class="row">';
      } else {
        $dyncourses .= '<div class="col-md-4">' . $coursediv . '</div>';
      }
      $i++;
 }
$dyncourses .= "</center>";
?>
<?php
  if(isset($_POST['addcourse'])){
  $adminid = $_SESSION['id'];
  $cname = $_POST['cname'];
  $cinfo = $_POST['cinfo'];
  $cduration = $_POST['cduration'];
  $file = addslashes(file_get_contents($_FILES["cimage"]["tmp_name"]));  
  $query4 = "INSERT INTO course(name,duration,info,photo) VALUES ('$cname','$cduration','$cinfo','$file')";
  $query3 = "INSERT INTO changelog(adminid,comment) VALUES ($adminid,'Added course $cname')";
  if(mysqli_query($connect,$query4))
  {
    mysqli_query($connect,$query3); 
    echo '<script>alert("Course added successfully!")</script>';
//    echo '<script>showNotificationNewCourse("top","center");</script>';
    $_POST["addcourse"] = '';
  }
  else{
    echo '<script>alert("Error")</script>';
//    echo '<script>showNotificationError("top","center");</script>';
  } 
    header("Refresh:0");
  }

?>
<?php
  if(isset($_POST['signout'])){
    session_destroy();
	 unset($_SESSION['email']);
    header('location:index.php');
  }
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
  <link href="admindash.css?v=<?=time();?>" rel="stylesheet" />
  <script src="jquery-3.4.1.min.js"></script>
  <!--  <link rel="stylesheet" href="bootstrap-4.3.1-dist/css/bootstrap.min.css">-->
</head>

<body onload="showNotification('top','right')">
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
          <li class="nav-item active">
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
          <li>
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
            <button class="btn btn-success  " style="margin-left:48px;" data-toggle="modal" data-target="#addcoursemodal"> <i class="fa fa-plus-circle" style="font-size:20px;"></i> Add New Course</button>
            <br>
            <br>
            <?php echo $dyncourses; ?>
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
            <button type="submit" class="btn btn-primary  ">Submit</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="addcoursemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <p class="modal-title modal-heading" id="exampleModalLabel">Add Course</p>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p id="addcerrors"></p>
          <form id="addcourseform" method="post" action="admindashboard.php" enctype="multipart/form-data">
            <div class="form-group">
              <label for="exampleInputEmail1">Course Name</label>
              <input type="text" name="cname" class="form-control" id="cname" placeholder="Enter Course Name" required>
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Duration(in Weeks)</label>
              <input type="number" min="1" name="cduration" class="form-control" id="cduration" required>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Info</label>
              <textarea name="cinfo" class="form-control" id="cinfo" placeholder="Enter Course Info" required></textarea>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Select Course Image (&lt; 1MB)</label>
              <input type="file" class="form-control-file" id="cimage" name="cimage" required>
            </div>
            <button type="submit" class="btn btn-primary  " name="addcourse">Submit</button>
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
            <button type="submit" class="btn btn-primary  " name="updatepass">Update</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script>
    function showNotification(from, align) {
      color = Math.floor((Math.random() * 4) + 1);

      $.notify({
        icon: "nc-icon nc-app",
        message: "Welcome to <b>The Valley Bootcamp Review Portal</b>"

      }, {
        type: type[color],
        timer: 100,
        placement: {
          from: from,
          align: align
        }
      });
    }

  </script>
  <script>
    function showNotificationNewCourse(from, align) {
      color = Math.floor((Math.random() * 4) + 1);

      $.notify({
        message: "Course added successfully!"

      }, {
        type: 'success',
        timer: 4000,
        placement: {
          from: from,
          align: align
        }
      });
    }

  </script>
  <script>
    function showNotificationError(from, align) {
      $.notify({
        message: "An error occurred"

      }, {
        type: 'danger',
        timer: 4000,
        placement: {
          from: from,
          align: align
        }
      });
    }

  </script>

  <script>
    $(document).ready(function() {
      $("#addadminform").submit(function(e) {
        //        alert("form submitted");
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
