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
  $query6 = "SELECT courseid, batchid FROM teachercourse WHERE teacherid = $id AND                            (courseid,batchid) IN (SELECT courseid,batchid FROM batches WHERE active = 1)";
  $result6 = mysqli_query($connect, $query6);
  $i = 0;
  $dyncourses = ''; 
 while($row6 = mysqli_fetch_array($result6))  
 {  
   $dynouter = '<div class="faq-row-container">';
  $dynbtns = '<div class="faq-row-handle">';
  $dyncontent = '<div class="faq-row">';
   $cid = $row6['courseid'];
   $bid = $row6['batchid'];
//   echo "Course id - $cid Batch id- $bid";
   $query7 = "SELECT name FROM course WHERE id = $cid";
   $result7 = mysqli_query($connect, $query7);
   $row7 = mysqli_fetch_array($result7);
   $cname = $row7['name'];
   $dynouter .= '  <div class="container-fluid courserev">
    <h2 class="nomargin" style="margin-bottom:10px;">'.$cname.'- Batch '.$bid.'</h2>';
   $query8 = "SELECT * FROM courseclass WHERE courseid = $cid AND batchid = $bid AND teacherid = $id AND classdate < CURRENT_DATE AND batchid IN(SELECT batchid FROM batches WHERE courseid = $cid AND active = 1) ORDER BY classdate DESC";
   $result8 = mysqli_query($connect, $query8);
   if(mysqli_num_rows($result8) == 0){
     $dynouter .= '<center><h4 class="nomargin" style="margin-top:80px;font-weight:normal;font-size:25px;">No classes</h4></center>';
   }
   else{
     while($row8 = mysqli_fetch_array($result8))  
     {
     $classno = $row8['classno'];
     if(empty($row8['topic'])){
       $ctopic = 'Not added';
     } 
     else{
       $ctopic = $row8['topic'];
     }   
     $classdate = $row8['classdate'];
     $cdate = date("d-m-Y",strtotime($classdate));
     $btn = '<a href="javascript:;" class="btn btn-primary" rel="c'.$cid.'b'.$bid.'c'.$classno.'">Class '.$classno.'</a>';
     $dynbtns .= $btn;   
     $dyndiv = ' <div class="faq-row-content container-fluid" id="c'.$cid.'b'.$bid.'c'.$classno.'">
                  <h5 class="nomargin" style="font-weight:bold;font-size:20px;margin-bottom:10px;font-family:Montserrat;">Class date - '.$cdate.'</h5>
                  <h5 class="nomargin" style="font-weight:bold;font-size:20px;margin-bottom:10px;font-family:Montserrat;">Class topic - '.$ctopic.'</h5>
                  <center><h4 class="nomargin" style="font-weight:bold;margin-bottom:25px;font-family:Montserrat;">Review the students for class '.$classno.' - </h4></center>
                  <div class="divscroll">';
     $dyntable = '<table cellpadding="20">';   
     $query9 = "SELECT studentid FROM studentcourse WHERE courseid = $cid AND batchid = $bid;";
     $result9 = mysqli_query($connect, $query9);
     $scount = 0;  
     $i = 0;
     while($row9 = mysqli_fetch_array($result9)){
      $sid = $row9['studentid'];
      $query10 = "SELECT id FROM performance WHERE studentid = $sid AND teacherid = $id AND courseid = $cid AND batchid = $bid AND classno = $classno";
      $result10 = mysqli_query($connect, $query10);
      if(mysqli_num_rows($result10) != 0){
        
      }
      else{
      $scount++;
      $query11 = "SELECT name, photo FROM student WHERE id = $sid;";
      $result11 = mysqli_query($connect, $query11);
      $row11 = mysqli_fetch_array($result11);
      $sname = $row11['name'];
      if(empty($row11['photo']))
        { 
          $simg = '<img src="assets1/default.png" style="margin:5px auto; border:solid black 1px;" width="75px" height="75px" alt="Your profile pic here" />';
        }
      else
        {
          $simg = '<img src="data:image/jpeg;base64,'.base64_encode($row11['photo'] ).'" style="margin:5px auto; border:solid black 1px;" width="75px" height="75px" alt="Your profile pic here" />';
        }
       
      $dyncard = '<div class="card" style="width: 15rem; border:solid black 1px;">
                    '.$simg.'
                    <div class="card-body">
                      <center>
                        <h4 class="card-title nomargin" style="font-size:20px;margin-bottom:10px;font-family:Montserrat;font-weight:400;">'.$sname.'</h4>
                      </center>
                      <form class="perfform">
                      <input type="hidden" name="classno" value="'.$classno.'">
                      <input type="hidden" name="studentid" value="'.$sid.'">
                      <input type="hidden" name="teacherid" value="'.$id.'">
                      <input type="hidden" name="courseid" value="'.$cid.'">
                      <input type="hidden" name="batchid" value="'.$bid.'">
                      <textarea class="form-control perf" id="perf" name="perf" rows="2" placeholder="Write the student\'s performance review" style="margin-bottom:5px;" required></textarea>
                      <br>
                      <center>
                      <div class="form-check">
                        <label class="form-check-label">
                            <input class="projectcheck form-check-input" type="checkbox" name="project" value="1">
                            <span class="form-check-sign"></span>
                            Project?
                        </label>
                      </div>
                      <div class = "radiodiv" style="display:none;">
                        <p class="radiolabel nomargin nopadding">Select a grade - </p>
                        <input type="radio" name="radioc'.$cid.'b'.$bid.'s'.$sid.'" value="S" checked><label style="font-size:15px;font-family:Montserrat;font-weight:400;margin-left:5px;margin-right:25px;">S</label>
                        <input type="radio" name="radioc'.$cid.'b'.$bid.'s'.$sid.'" value="A"><label style="font-size:15px;font-family:Montserrat;font-weight:400;margin-left:5px;margin-right:25px;">A</label>
                        <br>
                        <input type="radio" name="radioc'.$cid.'b'.$bid.'s'.$sid.'" value="B"><label style="font-size:15px;font-family:Montserrat;font-weight:400;margin-left:5px;margin-right:25px;margin-bottom:10px;">B</label>
                        <input type="radio" name="radioc'.$cid.'b'.$bid.'s'.$sid.'" value="C"><label style="font-size:15px;font-family:Montserrat;font-weight:400;margin-left:5px;margin-right:25px;margin-bottom:10px;">C</label>
                        <br>
                      </div>
                      </center>
                      <center><button type="submit" class="btn btn-primary">Submit</button></center>
                      </form>
                      <p class="revpara"></p>
                    </div>
                  </div>';
      if ($i % 4 == 0) { // if $i is divisible by our target number (in this case "3")
        $dyntable .= "<tr><td>" . $dyncard . "</td>";
      } else {
        $dyntable .= "<td>" . $dyncard . "</td>";
      }
      $i++;
//      echo $sname.'   '.$simg.'<br>';
      }
    }
     $dyntable .= "</tr></table>";
     $dyndiv .= $dyntable;
     if($scount == 0){
         $dyndiv .= '<center><h4 style="margin-top:100px;font-family:Montserrat;">All students reviewed for the week!</h4></center>';
       }
     $dyndiv .= '</div></div>';   
     $dyncontent .= $dyndiv;  
     }
       $dynbtns .= '<div class="clear"></div>
      </div> <br>';
     $dyncontent .= '<div class="clear"></div>
      </div>';
    $dynouter .= $dynbtns;
    $dynouter .= $dyncontent;
    $dynouter .= '</div></div>';
     
   }
   
  $dyncourses .= $dynouter.'<br><hr style="height: 0.05rem; border: none; color:#333; background-color:#333;"><br>'; 
 }
  
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="assets1/logo.png">
  <title>TVB - Teacher Dashboard</title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
  <!-- CSS Files -->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="assets/css/light-bootstrap-dashboard.css?v=2.0.0 " rel="stylesheet" />
  <link href="teachrev.css?ver=<?=time();?>" rel="stylesheet" />
  <script src="jquery-3.4.1.min.js"></script>
</head>

<body onload="showNotification('top','center')">
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
          <li>
            <a class="nav-link" href="teacherdashboard.php">
              <i class="fa fa-user"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li class="nav-item active">
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

          <?php echo $dyncourses; ?>

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
    $(".projectcheck").on('click', function() {
      //      alert("check");
      $(this).closest('.form-check').next(".radiodiv").fadeToggle();

    });

  </script>
  <script>
    $(document).ready(function() {
      $(".perfform").submit(function(e) {
        e.preventDefault();
        var form = $(this);
        var url = "submitperf.php";
        $.ajax({
          type: "POST",
          url: url,
          data: form.serialize(),
          success: function(data) {
            var result = $.trim(data);
            if (result == "success") {
              form.replaceWith("<center><h6 style='color: green;'>Review Submitted</h6></center>");
            } else {
              form.replaceWith("<center><h6 style='color: red;'>Error</h6></center>");
            }
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
  <script>
    
    $(document).ready(function() {

      var tab = $('.faq-row-handle > a'),
        tabContent = $('.faq-row-content');


      if (tab.length) {

        tab.off('click').on('click', function() {

          var ele = $(this),
            currContent = $('#' + ele.attr('rel'));

          //get this parent only
          var tabParent = $(currContent).parent();

          if (!ele.hasClass('open')) {
            
            $('.faq-row').not(tabParent).stop(true, true).animate({
              height: '0px'
            });
            $(tabParent).stop(true, true).animate({
              height: '0px'

            }, function() {
              tabContent.removeClass('open');
              currContent.addClass('open');
              tab.removeClass('open');
              ele.addClass('open');

              tabParent.stop(true, true).animate({
                height: currContent.height() + 'px'
              });

            });

          }

        });

        $('.faq-row-handle > a:eq(0)').click();
      }

    });

  </script>
  <script>
    function showNotification(from, align) {
      $.notify({
        message: "<b>Warning:</b> Reviews cannot be edited once submitted"

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
