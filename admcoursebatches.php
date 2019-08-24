<?php
  $connect = mysqli_connect("localhost","root","","tvb");
  $active = $_POST['active']; 
  $cid = $_POST['cid'];
  $q = '';
  if($active == 1){
    $q = "AND active = 1";
  }
  $query1 = "SELECT * FROM batches WHERE courseid = $cid $q";
  $result1 = mysqli_query($connect, $query1);
  $outerdiv = '';
  $outermodal = '';
  while($row1 = mysqli_fetch_array($result1)){
    $bid = $row1['batchid'];
    $act = $row1['active'];
    $query8 = "SELECT COUNT(studentid) as stdcount FROM studentcourse WHERE batchid = $bid AND courseid = $cid";
    $result8 = mysqli_query($connect, $query8);
    $row8 = mysqli_fetch_array($result8);
    $stdcount = $row8['stdcount'];
    $sdate = date("d-m-Y",strtotime($row1['sdate']));
    $addsmodal = '<div class="modal fade" id="addstudentmodal'.$bid.'" tabindex="-1">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Student</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form class="searchsform" id="searchsformb'.$bid.'">
                      <div class="row">
                        <div class="col-md-9">
                          <div class="form-group">
                            <input type="text" class="form-control" name="snameb'.$bid.'" id="snameb'.$bid.'" placeholder="Enter Student Name">
                          </div>
                        </div>
                        <div class="col-md-2">
                          <button type="submit" name="searchsb'.$bid.'" id="searchsb'.$bid.'" class="btn btn-primary">Search</button>
                        </div>
                      </div>
                    </form>
                    <div class="container-fluid slist">
                      <form class="slistform" id="slistformb'.$bid.'">
                        <input type="hidden" name="cid" value="'.$cid.'"> 
                        <input type="hidden" name="bid" value="'.$bid.'"> 
                        <div class="form-group divscrollselectstd" id="slistb'.$bid.'">
                        </div>
                        <button type="submit" id="addsbtnb'.$bid.'" class="addsbtn btn btn-primary">Submit</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>';
    $addimodal = '<div class="modal fade" id="addinstmodal'.$bid.'" tabindex="-1">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Instructor</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <div class="container-fluid ilist">
                          <form class="ilistform" id="ilistformb'.$bid.'">
                            <input type="hidden" name="cid" value="'.$cid.'"> 
                            <input type="hidden" name="bid" value="'.$bid.'">
                            <div class="form-group" id="ilistb'.$bid.'">
                            </div>
                            <button type="submit" name="addibtnb" id="addibtnb'.$bid.'" class="addibtn btn btn-primary">Submit</button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>';
    $addcmodal = '<div class="modal fade" id="addclassmodal'.$bid.'" tabindex="-1">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Add Class</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <div class="container-fluid ">
                            <p id="addcerrorsb'.$bid.'"></p>
                            <form class="addclassform" id="addcformb'.$bid.'">
                              <input type="hidden" name="cid" value="'.$cid.'"> 
                              <input type="hidden" name="bid" value="'.$bid.'"> 
                              <div class="form-group">
                                <label>Select Class Date :</label>
                                <input type="date" class="form-control classdate" id="addcdateb'.$bid.'" name="addcdate" required>
                              </div>
                              <div class="form-group">
                                <label>Select Instructor :</label>
                                <select class="form-control" id="addctb'.$bid.'" name="addct" required></select>
                              </div>
                              <div class="form-group">
                                <label for="exampleInputEmail1">Class Topic :</label>
                                <input type="text" name="addctopic" class="form-control" id="addctopicb'.$bid.'" placeholder="Enter a topic for the class">
                              </div>
                              <button type="submit" name="addcbtn" id="addcbtnb'.$bid.'" class="addcbtn btn btn-primary">Submit</button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>';
    $outermodal .= $addsmodal;
    $outermodal .= $addcmodal;
    $outermodal .= $addimodal;
    if($act == 0){
      $batchdiv = '<div class="coursecontainer deactive">
      <div class="toggle">
        <div class="row ">
          <div class="col-md-9 clickable">
            <h4 style="font-weight:bold;" class="batchhead">Batch '.$bid.'</h4>
          </div>
          <div class="col-md-3"> <button class="btn btn-success btn-fill actdeact" name="act" id="actb'.$bid.'">Activate</button></div>
        </div>
      </div>
      <div id="batch'.$bid.'" class="slider slideup">
        <div id="Actual">
          <div class="row">
            <div class="col-md-6">
              <div class="row">
                <div class="col-md-4"><button type="button" class="btn btn-primary adds" style="margin-left:30px;" id="addsb'.$bid.'" data-toggle="modal" data-target="#addstudentmodal'.$bid.'"> <i class="fa fa-plus-circle" style="font-size:20px;"></i> Add Student</button></div>
                <div class="col-md-4"><button class="btn btn-primary addi" style="margin-left:30px;" data-toggle="modal" id="addib'.$bid.'" data-target="#addinstmodal'.$bid.'"> <i class="fa fa-plus-circle" style="font-size:20px;"></i> Add Instructor</button></div>
                <div class="col-md-4"><button class="btn btn-primary addc" style="margin-left:30px;" data-toggle="modal" id="addcb'.$bid.'" data-target="#addclassmodal'.$bid.'"> <i class="fa fa-plus-circle" style="font-size:20px;"></i> Add Class</button></div>
              </div>
            </div>
            <div class="col-md-6">
              <div style="float:right;">
                <h6>Start Date - '.$sdate.'</h6>
                <h6>Number of students - '.$stdcount.'</h6> 
              </div>
            </div>
          </div>
          <br>
          <div class="row">';
    }
    else{
      $batchdiv = '<div class="coursecontainer active" >
      <div class="toggle">
        <div class="row ">
          <div class="col-md-9 clickable">
            <h4 style="font-weight:bold;" class="batchhead">Batch '.$bid.'</h4>
          </div>
          <div class="col-md-3"> <button class="btn btn-danger btn-fill actdeact" name="act" id="actb'.$bid.'">Deactivate</button></div>
        </div>
      </div>
      <div id="batch'.$bid.'" class="slider slideup">
        <div id="Actual">
          <div class="row">
            <div class="col-md-6">
              <div class="row">
                <div class="col-md-4"><button type="button" class="btn btn-primary adds" style="margin-left:30px;" id="addsb'.$bid.'" data-toggle="modal" data-target="#addstudentmodal'.$bid.'"> <i class="fa fa-plus-circle" style="font-size:20px;"></i> Add Student</button></div>
                <div class="col-md-4"><button class="btn btn-primary addi" style="margin-left:30px;" data-toggle="modal" id="addib'.$bid.'" data-target="#addinstmodal'.$bid.'"> <i class="fa fa-plus-circle" style="font-size:20px;"></i> Add Instructor</button></div>
                <div class="col-md-4"><button class="btn btn-primary addc" style="margin-left:30px;" data-toggle="modal" id="addcb'.$bid.'" data-target="#addclassmodal'.$bid.'"> <i class="fa fa-plus-circle" style="font-size:20px;"></i> Add Class</button></div>
              </div>
            </div>
            <div class="col-md-6">
              <div style="float:right;">
                <h6 style="font-weight:bold;">Start Date - '.$sdate.'</h6>
                <h6 style="font-weight:bold;">Number of students - '.$stdcount.'</h6> 
              </div>
            </div>
          </div>
          <br>
          <div class="row">';
    }
    
    $tdiv = '<div class="col-md-4">
              <div class="container-fluid teachers">
                <table class="table table-hover teachtable">
                  <thead class="thead-dark">
                    <tr>
                      <th scope="col">
                        <center style="color:white;">Instructors</center>
                      </th>
                    </tr>
                  </thead>
                  <tbody>';
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
                </table>
              </div>
            </div>';
    $sdiv = '<div class="col-md-4">
              <div class="container-fluid students">
                <div class="divscrolls">
                  <table class="table table-hover stdtable">
                    <thead class="thead-dark">
                      <tr>
                        <th scope="col">
                          <center style="color:white;">Students</center>
                        </th>
                      </tr>
                    </thead>
                    <tbody>';
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
                </table>
              </div>
            </div>
            </div>';
    $cdiv = ' <div class="col-md-4">
              <div class="container-fluid classes">
                <div class="divscrollc">
                  <table class="table table-hover classtable">
                    <thead class="thead-dark">
                      <tr>
                        <th scope="col">
                          <center style="color:white;">Classes</center>
                        </th>
                      </tr>
                    </thead>
                    <tbody>';
    $query6 = "SELECT * FROM courseclass WHERE courseid = $cid AND batchid = $bid";
    $result6 = mysqli_query($connect, $query6);
    while($row6 = mysqli_fetch_array($result6)){
      $cdat = $row6['classdate'];
      $cdate = date("d-m-Y",strtotime($cdat));
      $tdate = date("Y-m-d");
      $ctopic = $row6['topic'];
      $ctid = $row6['teacherid'];
      $cno = $row6['classno'];
      $query7 = "SELECT name FROM teacher WHERE id = $ctid";
      $result7 = mysqli_query($connect,$query7);
      $row7 = mysqli_fetch_array($result7);
      $ctname = $row7['name'];
      if($cdat < $tdate){
        $dync = '<tr>
                        <td>
                          <h6 style="font-weight:normal;">Class '.$cno.' - '.$cdate.' &nbsp;&nbsp;(Completed)</h6>
                          <h6 style="font-weight:normal;"> '.$ctopic.' By '.$ctname.'</h6>
                        </td>
                      </tr>';
      }
      else{
        $dync = '<tr>
                        <td>
                          <h6 style="font-weight:normal;">Class '.$cno.' - '.$cdate.' &nbsp;&nbsp;(Upcoming)</h6>
                          <h6 style="font-weight:normal;"> '.$ctopic.' By '.$ctname.'</h6>
                        </td>
                      </tr>';
      }
      $cdiv .= $dync;
    }
    $cdiv .= '  </tbody>
                </table>
              </div>
            </div>
            </div>';
    $batchdiv .= $tdiv;
    $batchdiv .= $sdiv;
    $batchdiv .= $cdiv;
    $batchdiv .= '</div>
        </div>
      </div>

    </div>';
    $outerdiv .= $batchdiv.'<br>';
  }
  $outerdiv .= $outermodal;
  echo $outerdiv;
?>