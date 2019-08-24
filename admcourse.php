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
  if(!isset($_GET['cid'])){
    header('location:admindashboard.php');
  }
  if($email != $_SESSION['email']){
     echo '<script>alert("Acess denied. Log in again!")</script>';
     echo "<script> location.href='index.php'; </script>";
         exit;
  }
?>
<?php
  $connect = mysqli_connect("localhost", "root", "", "tvb");
  $id=$_GET['cid'];
  $query1 = "SELECT * from course WHERE id=$id";
  $result1 = mysqli_query($connect, $query1);
  $row1 = mysqli_fetch_array($result1);
  $cname = $row1['name'];
  $cinfo = $row1['info'];
  $cphoto = $row1['photo'];
  $duration = $row1['duration'];
  if(empty($cphoto))
    {
      $cpic = '<img src="assets/default.png" width="100%" height="400rem" />';
    }
    else{
      $cpic = '<img src="data:image/jpeg;base64,'.base64_encode($cphoto ).'" width="100%" height="400rem" />';
    }
  
  
?>
<?php
  $cid=$_GET['cid'];
  $query4 = "SELECT * from course WHERE id=$id";
  $result4 = mysqli_query($connect, $query4);
  $row4 = mysqli_fetch_array($result4);
  $ncname = $row4['name'];
  $ncinfo = $row4['info'];
  $ncphoto = $row4['photo'];
  $ncduration = $row4['duration'];
  if(isset($_POST['updcourse'])){
    if(!empty($_POST['ucname'])){
      $ncname = $_POST['ucname'];
    }
    if(!empty($_POST['ucinfo'])){
      $ncinfo = $_POST['ucinfo'];
    }
    if(!empty($_POST['ucduration'])){
      $ncduration = $_POST['ucduration'];
    }
    $query2 = "UPDATE course SET name = '$ncname', info = '$ncinfo', duration = '$ncduration' WHERE id = $cid";
    if(mysqli_query($connect, $query2))  
      {  
//        echo '<script>alert("Updated Course Details ")</script>'; 
         header("Refresh:0");
          $_POST["updcourse"] = '';
      }
    else{
      echo '<script>alert("Fail")</script>'; 
    }
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
  <link rel="stylesheet" href="admcourse.css?v=<?=time();?>">
  <link href="assets/css/light-bootstrap-dashboard.css?v=2.0.0&ver=<?=time();?> " rel="stylesheet" />
  <link href="admindash.css&ver=<?=time();?>" rel="stylesheet" />
  <script src="jquery-3.4.1.min.js"></script>
  <!--  <link rel="stylesheet" href="bootstrap-4.3.1-dist/css/bootstrap.min.css">-->
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

            <div class="row">
              <div class="col-md-6">
                <?php echo $cpic; ?>
              </div>
              <div class="col-md-6">
                <h1 class="nomargin"><?php echo $cname; ?></h1>
                <hr style="height: 1px; border: none; color:#333; background-color:#333;">
                <h4 class="nomargin">Course info - <h5><?php echo $cinfo; ?></h5>
                </h4>
                <br>
                <h4 class="nomargin">Duration - <?php echo $duration; ?> Weeks</h4>
                <br>
                <br>
                <div class="row">
                  <div class="col-md-6"><button class="btn btn-primary" style="margin-left:30px;float:left;" data-toggle="modal" data-target="#updcoursemodal">Update Course Details</button></div>
                  <div class="col-md-6"><button class="btn btn-danger" style="margin-left:30px;float:left;" data-toggle="modal" data-target="#delcoursemodal">Delete Course</button></div>
                </div>
              </div>
            </div>
            <hr style="height: 0.5px; border: none; color:#333; background-color:#333;">

            <div class="row">
              <div class="col-2">
                <h3 class="nomargin" style="font-weight:bold;">Batches : </h3>
              </div>
              <div class="col-8">
                <!--
                <div class="form-group" style="float:right;padding-top:7px;">
                  <input type="checkbox" name="active" id="active">
                  <label class="form-check-label" for="active">
                    <h5 class="nomargin">View Active</h5>
                  </label>
                </div>
-->
                <div class="form-check" style="float:right;padding-top:7px;">
                  <label class="form-check-label">
                    <input class="form-check-input" type="checkbox" name="active" id="active">
                    <span class="form-check-sign"></span>
                    View Active
                  </label>
                </div>
              </div>
              <div class="col-2"><button class="btn btn-success" style="margin-right:25px;float:right;" data-toggle="modal" data-target="#addbatchmodal"> <i class="fa fa-plus-circle" style="font-size:20px;"></i> Add Batch</button></div>
            </div>
            <br>
            <div class="container-fluid batches">
              <div id="batchdiv"></div>
            </div>
            <br>



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
            <button type="submit" class="btn btn-primary btn-fill">Submit</button>
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
            <button type="submit" class="btn btn-primary btn-fill" name="updatepass">Update</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div id="modaldiv"></div>
  <div class="modal fade" id="addbatchmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Batch</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p id="addberrors"></p>
          <form id="addbatchform">
            <div class="form-group">
              <label for="exampleInputEmail1">Start Date</label>
              <input type="date" name="sdate" class="form-control" id="sdate" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="updcoursemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Update Course Details</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p id="addcerrors">Only type in fields that you want to update.</p>
          <form id="addcourseform" method="post" action="admcourse.php?cid=<?php echo $id;?>">
            <div class="form-group">
              <label for="exampleInputEmail1">Course Name</label>
              <input type="text" name="ucname" class="form-control" id="ucname" placeholder="Enter Course Name">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Duration(in Weeks)</label>
              <input type="number" min="1" name="ucduration" class="form-control" id="ucduration">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Info</label>
              <textarea name="ucinfo" class="form-control" id="ucinfo" placeholder="Enter Course Info"></textarea>
            </div>
            <button type="submit" class="btn btn-primary" name="updcourse">Submit</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="delcoursemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Delete Course</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p style="color:black; font-size:18px;">Are you sure you want to delete all data related to this course?</p>
          <p style="color:red; font-size:12px;">Warning: This action is irreversible</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-danger" id="delcbtn">Delete</button>
        </div>
      </div>
    </div>
  </div>


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
  <script>
    //    $("body").on('DOMSubtreeModified', "batchdiv", function() {
    $("body").on('click', '.clickable', function() {
      $(this).parent().parent().next(".slider").toggleClass("slidedown slideup");
    });

    //    });

  </script>
  <script>
    //    $("body").on('DOMSubtreeModified', "batchdiv", function() {
    $("body").on('click', '.adds', function() {
      var btnid1 = this.id;
      var bid1 = btnid1.slice(5);
      var search1 = "#snameb" + bid1;
      var div1 = "#slistb" + bid1;
      var s = $(search1).val();
      var url1 = "batchslistajax.php";
      var cid1 = <?php echo $id; ?>;
      var checked = [];
      var arr = JSON.stringify(checked);
      $.ajax({
        type: "POST",
        url: url1,
        data: {
          cid: cid1,
          bid: bid1,
          search: s,
          checked: arr
        },
        success: function(data) {
          var result1 = $.trim(data);
          $(div1).html(result1);
        }
      });
    });

    //    });

  </script>
  <script>
    //    $("body").on('DOMSubtreeModified', "batchdiv", function() {
    $("body").on('click', '.actdeact', function() {
      $(this).toggleClass('btn-success btn-danger');
      $(this).parent().parent().parent().parent().toggleClass('deactive active');
      var t = $(this).text();
      if (t == "Activate") {
        var btnid2 = this.id;
        var bid2 = btnid2.slice(4);
        //        alert(bid);
        //          alert("activated");
        $(this).text("Deactivate");
        var url2 = "actdeact.php";
        var cid2 = <?php echo $id; ?>;
        $.ajax({
          type: "POST",
          url: url2,
          data: {
            cid: cid2,
            bid: bid2,
            act: 1
          },
          success: function(data) {
            var result2 = $.trim(data);
            //            alert(result2);
          }
        });

      }
      if (t == "Deactivate") {
        var btnid3 = this.id;
        var bid3 = btnid3.slice(4);
        //        alert(bid);
        //          alert("Deactivated");
        $(this).text("Activate");
        var url3 = "actdeact.php";
        var cid3 = <?php echo $id; ?>;
        $.ajax({
          type: "POST",
          url: url3,
          data: {
            cid: cid3,
            bid: bid3,
            act: 0
          },
          success: function(data) {
            var result3 = $.trim(data);
            //            alert(result3);
          }
        });
      }
    });

    //    });

  </script>
  <script>
    $(document).ready(function() {
      $("#active").val($("#active").checked ? 1 : 0);
      var active1 = $("#active").val();
      var url4 = "admcoursebatches.php";
      var cid4 = <?php echo $id; ?>;
      $.ajax({
        type: "POST",
        url: url4,
        data: {
          cid: cid4,
          active: active1
        },
        success: function(data) {
          var result4 = $.trim(data);
          $("#batchdiv").html(result4);
          var activediv = sessionStorage.getItem("activediv");
          $(activediv).toggleClass('slideup slidedown');
          $(activediv)[0].scrollIntoView({
            behavior: 'smooth',
            block: 'center'
          });
          var today = new Date().toISOString().split('T')[0];
          $(".classdate").attr({'min':today});
          //document.getElementsByClassName("classdate").setAttribute('min', today);
          //            $("#modaldiv").html(result.modals);
        }
      });
      //      alert($("#active").val());
      $("#active").on('click', function() {
        $(this).val(this.checked ? 1 : 0);
        //        alert($(this).val());
        var active2 = $(this).val();
        var url5 = "admcoursebatches.php";
        var cid5 = <?php echo $id; ?>;
        $.ajax({
          type: "POST",
          url: url5,
          data: {
            cid: cid5,
            active: active2
          },
          success: function(data) {
            var result5 = $.trim(data);
            $("#batchdiv").html(result5);
            var activediv = sessionStorage.getItem("activediv");
            var today = new Date().toISOString().split('T')[0];
            $(".classdate").attr({'min':today});
            //document.getElementsByClassName("classdate").setAttribute('min', today);
            $(activediv).toggleClass('slideup slidedown');
            $(activediv)[0].scrollIntoView({
              behavior: 'smooth',
              block: 'center'
            });
            //            $("#modaldiv").html(result.modals);
          }

        });

      });
    });

  </script>
  <script>
    $(document).ready(function() {
      var today = new Date().toISOString().split('T')[0];
      document.getElementsByName("sdate")[0].setAttribute('min', today);
      $("#addbatchform").submit(function(e) {
        e.preventDefault();
        var sdate = $("#sdate").val();
        var d = new Date();
        var month = d.getMonth() + 1;
        var day = d.getDate();
        var tdate = d.getFullYear() + '-' +
          (month < 10 ? '0' : '') + month + '-' +
          (day < 10 ? '0' : '') + day;
        var url6 = "addbatchajax.php";
        var cid6 = <?php echo $id; ?>;
        if (new Date(sdate) <= new Date(tdate)) {
          $("#addberrors").html("<p style='color:red;'>Start date cannot be before current date!</p>");
        } else {
          $.ajax({
            type: "POST",
            url: url6,
            data: {
              cid: cid6,
              sdate: sdate
            },
            success: function(data) {
              var result6 = $.trim(data);
              $("#addberrors").html(result6);
            }

          });
        }
      });

    });

  </script>
  <script>
    $("body").on('submit', '.searchsform', function(e) {
      e.preventDefault();
      var formid1 = this.id;
      var bid4 = formid1.slice(12);
      var search2 = "#snameb" + bid4;
      var div2 = "#slistb" + bid4;
      var s = $(search2).val();
      var url7 = "batchslistajax.php";
      var cid7 = <?php echo $id; ?>;
      var checked = [];
      var inputname = "students" + bid4;
      var condition = "input:checkbox[name='" + inputname + "[]']:checked";
      $(condition).each(function() {
        checked.push($(this).val());
      });
      //      alert(checked);
      var arr = JSON.stringify(checked);
      //      alert(arr);
      $.ajax({
        type: "POST",
        url: url7,
        data: {
          cid: cid7,
          bid: bid4,
          search: s,
          checked: arr
        },
        success: function(data) {
          var result7 = $.trim(data);
          $(div2).html(result7);
        }
      });
    });

  </script>
  <script>
    $("body").on('submit', '.slistform', function(e) {
      e.preventDefault();
      var form = $(this);
      var formid2 = this.id;
      var bid5 = formid2.slice(10);
      var url8 = "addstdbajax.php";
      var cid8 = <?php echo $id; ?>;
      var div = "#batch" + bid5;
      sessionStorage.setItem("activediv", div);
      $.ajax({
        type: "POST",
        url: url8,
        data: form.serialize(),
        success: function(data) {
          var result8 = $.trim(data);
          form.html(result8);
        }
      });
    });

  </script>
  <script>
    $("body").on('click', '.addc', function() {
      var btnid4 = this.id;
      var bid6 = btnid4.slice(5);
      var sel = "#addctb" + bid6;
      var url9 = "cteachoptnajax.php";
      var cid9 = <?php echo $id; ?>;
      var today = new Date().toISOString().split('T')[0];
      document.getElementsByName("addcdate")[0].setAttribute('min', today);
      $.ajax({
        type: "POST",
        url: url9,
        data: {
          cid: cid9,
          bid: bid6
        },
        success: function(data) {
          var result9 = $.trim(data);
          $(sel).html(result9);
        }
      });
    });

  </script>
  <script>
    $("body").on('submit', '.addclassform', function(e) {
      e.preventDefault();
      var form2 = $(this);
      var formid3 = this.id;
      var bid7 = formid3.slice(9);
      var url10 = "addclassajax.php";
      var cid10 = <?php echo $id; ?>;
      var div = "#batch" + bid7;
      sessionStorage.setItem("activediv", div);
      $.ajax({
        type: "POST",
        url: url10,
        data: form2.serialize(),
        success: function(data) {
          var result10 = $.trim(data);
          form2.html(result10);
        }
      });
    });

  </script>
  <script>
    //    $("body").on('DOMSubtreeModified', "batchdiv", function() {
    $("body").on('click', '.addi', function() {
      var btnid5 = this.id;
      var bid8 = btnid5.slice(5);
      var div3 = "#ilistb" + bid8;
      var url11 = "batchilistajax.php";
      var cid11 = <?php echo $id; ?>;
      $.ajax({
        type: "POST",
        url: url11,
        data: {
          cid: cid11,
          bid: bid8
        },
        success: function(data) {
          var result11 = $.trim(data);
          $(div3).html(result11);
        }
      });
    });

    //    });

  </script>
  <script>
    $("body").on('submit', '.ilistform', function(e) {
      e.preventDefault();
      var form3 = $(this);
      var formid4 = this.id;
      var bid9 = formid4.slice(10);
      var url12 = "addinstbajax.php";
      var cid12 = <?php echo $id; ?>;
      var div = "#batch" + bid9;
      sessionStorage.setItem("activediv", div);
      $.ajax({
        type: "POST",
        url: url12,
        data: form3.serialize(),
        success: function(data) {
          var result12 = $.trim(data);
          form3.html(result12);
        }
      });
    });

  </script>
  <script>
    $("body").on('click', '.delinst', function() {
      var button2 = this;
      var btnid6 = this.id;
      var index = btnid6.indexOf('t');
      var bid10 = btnid6.slice(1, index);
      var tid = btnid6.slice(index + 1);
      var url13 = "delinstbajax.php";
      var cid13 = <?php echo $id; ?>;
      $.ajax({
        type: "POST",
        url: url13,
        data: {
          cid: cid13,
          bid: bid10,
          tid: tid
        },
        success: function(data) {
          var result13 = $.trim(data);
          $(button2).closest(".teachtable").replaceWith(result13);
        }
      });
    });

  </script>
  <script>
    $("body").on('click', '.delstd', function() {
      var button = this;
      var btnid7 = this.id;
      var index2 = btnid7.indexOf('s');
      var bid11 = btnid7.slice(1, index2);
      var sid = btnid7.slice(index2 + 1);
      var url14 = "delstdbajax.php";
      var cid14 = <?php echo $id; ?>;
      $.ajax({
        type: "POST",
        url: url14,
        data: {
          cid: cid14,
          bid: bid11,
          sid: sid
        },
        success: function(data) {
          var result14 = $.trim(data);
          $(button).closest(".stdtable").replaceWith(result14);
        }
      });
    });

  </script>

  <script>
    $(document).ready(function() {
      $("#delcbtn").click(function(e) {
        var cid15 = <?php echo $id; ?>;
        var url15 = "delcourse.php";
        $.ajax({
          type: "POST",
          url: url15,
          data: {
            cid: cid15
          },
          success: function(data) {
            var result = $.trim(data);
            alert(result);
            window.location.replace("admindashboard.php");
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
