<?php
$cid = $_POST['courseid'];
$id = $_POST['sid'];
$connect = mysqli_connect("localhost","root","","tvb");
$query1 = "SELECT * FROM performance WHERE studentid = $id AND courseid = $cid ORDER BY classno DESC";
$result1 = mysqli_query($connect, $query1);
$dynperf = '';
if($cid != 0){
  $dynperf = "<center><h4 class='nomargin' style='font-weight:bold;'>Student's performace reviews by Instructors : </h4></center><br>";
}
while($row1 = mysqli_fetch_array($result1)){
  $clno = $row1['classno'];
  $bid = $row1['batchid'];
  $query2 = "SELECT topic, classdate FROM courseclass WHERE classno = $clno AND courseid =$cid AND batchid = $bid";
  $result2 = mysqli_query($connect, $query2);
  $row2 = mysqli_fetch_array($result2);
  $topic = $row2['topic'];
  $cdate = $row2['classdate'];
  $tid = $row1['teacherid'];
  $pro = $row1['progress'];
  if(isset($row1['project'])){
    $grade = $row1['project'];
  }
  else{
    $grade = '<span style="color:red;font-weight:normal;">No Project<span>';
  }
  $cldate = date("d-m-Y",strtotime($cdate));
  $query2 = "SELECT name from teacher WHERE id=$tid";
  $result2 = mysqli_query($connect, $query2);
  $row2 = mysqli_fetch_array($result2);
  $tname = $row2['name'];
  $tnamelink = '<a class="namelink" href="teachadm.php?tid='.$tid.'">'.$tname.'</a>';
  $dynrow = '   <div class="weekrev container-fluid">
      <div class="row">
        <div class="col-2">
          <h4 style="font-weight:normal;">Class '.$clno.' : </h4>
          <br>
          <h6 style="font-weight:normal;">'.$cldate.'</h6>
          <h6 style="font-weight:normal;">'.$topic.'</h6>
        </div>
        <div class="col-10">
          <h4 style="font-weight:normal;"> By '.$tnamelink.'</h4>
          <hr>
          <h6>Project Grade - '.$grade.'</h6>
          <h6>Performance review - </h6>
          <p>'.$pro.'</p>
        </div>
      </div>
    </div><br>';
  $dynperf .= $dynrow;
}
echo $dynperf;
?>