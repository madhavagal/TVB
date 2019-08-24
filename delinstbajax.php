<?php
  session_start();
  $connect = mysqli_connect("localhost","root","","tvb");
  $adminid = $_SESSION['id'];
  $cid = $_POST['cid'];
  $bid = $_POST['bid'];
  $tid = $_POST['tid'];
  $query4 = "SELECT name FROM course WHERE id = $cid";
  $result4 = mysqli_query($connect, $query4);
  $row4 = mysqli_fetch_array($result4);
  $cname = $row4['name'];
  $query5 = "SELECT name FROM teacher WHERE id = $tid";
  $result5 = mysqli_query($connect, $query5);
  $row5 = mysqli_fetch_array($result5);
  $tname = $row5['name'];
  $query2 = "DELETE FROM teachercourse WHERE courseid = $cid AND batchid = $bid AND teacherid = $tid";
  $query3 = "INSERT INTO changelog(adminid,comment) VALUES ($adminid,'Removed Instructor $tname from $cname - Batch $bid')";
  $tdiv = '     <table class="table table-hover teachtable">
                  <thead class="thead-dark">
                    <tr>
                      <th scope="col">
                        <center style="color:white;">Instructors</center>
                      </th>
                    </tr>
                  </thead>
                  <tbody>';
  if(mysqli_query($connect,$query2))
  {
   mysqli_query($connect,$query3);
  }
  else{
//    echo 'Error';
  }
  $query2 = "SELECT teacherid FROM teachercourse WHERE courseid = $cid AND batchid = $bid";
  $result2 = mysqli_query($connect, $query2);
  while($row2 = mysqli_fetch_array($result2)){
    $tid = $row2['teacherid'];
    $query3 = "SELECT name,photo FROM teacher WHERE id = $tid";
    $result3 = mysqli_query($connect,$query3);
    $row3 = mysqli_fetch_array($result3);
    $tname = $row3['name'];
    $tphoto = $row3['photo'];
    $tnamelink = '<a class = "namelink" href="teachadm.php?tid='.$tid.'">'.$tname.'</a>';
    if(empty($tphoto))
      {
        $tpic = '<img src="assets1/default.png" class="smallpic" />';
      }
      else{
        $tpic = '<img src="data:image/jpeg;base64,'.base64_encode($tphoto ).'" class="smallpic"  />';
      }
    $dynt='<tr>
                    <td>
                      <div class="row">
                        <div class="col-md-3">'.$tpic.'</div>
                        <div class="col-md-6">
                          <h6 style="margin-top:5px;">'.$tnamelink.'</h6>
                        </div>
                        <div class="col-md-3"><button class="delinst btn btn-danger" id="b'.$bid.'t'.$tid.'" style="float:right;" data-toggle="modal" data-target="#delt'.$tid.'"> <i class="fa fa-times-circle" style="font-size:20px;"></i></button></div>
                      </div>
                    </td>
                  </tr>';
    $tdiv .= $dynt;
  }
  $tdiv .= '  </tbody>
              </table>';
  echo $tdiv;
  

?>