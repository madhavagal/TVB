<?php
  session_start();
  $connect = mysqli_connect("localhost","root","","tvb");
  $adminid = $_SESSION['id'];
  $cid = $_POST['cid'];
  $bid = $_POST['bid'];
  $sid = $_POST['sid'];
  $query4 = "SELECT name FROM course WHERE id = $cid";
  $result4 = mysqli_query($connect, $query4);
  $row4 = mysqli_fetch_array($result4);
  $cname = $row4['name'];
  $query5 = "SELECT name FROM student WHERE id = $sid";
  $result5 = mysqli_query($connect, $query5);
  $row5 = mysqli_fetch_array($result5);
  $sname = $row5['name'];
  $query2 = "DELETE FROM studentcourse WHERE courseid = $cid AND batchid = $bid AND studentid = $sid";
  $query3 = "INSERT INTO changelog(adminid,comment) VALUES ($adminid,'Removed Student $sname from $cname - Batch $bid')";
  $sdiv = '<table class="table table-hover stdtable">
                    <thead class="thead-dark">
                      <tr>
                        <th scope="col">
                          <center style="color:white;">Students</center>
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
$query4 = "SELECT studentid FROM studentcourse WHERE courseid = $cid AND batchid = $bid";
$result4 = mysqli_query($connect, $query4);
while($row4 = mysqli_fetch_array($result4)){
  $sid = $row4['studentid'];
  $query5 = "SELECT name,photo FROM student WHERE id = $sid";
  $result5 = mysqli_query($connect,$query5);
  $row5 = mysqli_fetch_array($result5);
  $sname = $row5['name'];
  $sphoto = $row5['photo'];
  $snamelink = '<a class = "namelink" href="stdadmin.php?sid='.$sid.'">'.$sname.'</a>';
  if(empty($sphoto))
    {
      $spic = '<img src="assets1/default.png" class="smallpic" />';
    }
    else{
      $spic = '<img src="data:image/jpeg;base64,'.base64_encode($sphoto ).'" class="smallpic"  />';
    }
  $dyns='<tr>
          <td>
            <div class="row">
              <div class="col-md-3">'.$spic.'</div>
              <div class="col-md-6">
                <h6 style="margin-top:5px;">'.$snamelink.'</h6>
              </div>
              <div class="col-md-3"><button class="delstd btn btn-danger" id="b'.$bid.'s'.$sid.'" style="float:right;" data-toggle="modal" data-target="#dels'.$sid.'"> <i class="fa fa-times-circle" style="font-size:20px;"></i></button></div>
            </div>
          </td>
        </tr>';
  $sdiv .= $dyns;
}
$sdiv .= '  </tbody>
            </table>';
echo $sdiv;
?>
