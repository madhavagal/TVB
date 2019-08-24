<?php
  $connect = mysqli_connect("localhost","root","","tvb");
  $cid = $_POST['cid']; 
  $tid = $_POST['tid']; 
  $bid = $_POST['bid'];
  $week = $_POST['week'];
  $query1 = "SELECT * FROM review WHERE courseid = $cid AND batchid = $bid AND teacherid = $tid AND classno = $week";
  $result1 = mysqli_query($connect, $query1);
  $query3 = "SELECT AVG(rating) as avgrating FROM review WHERE courseid = $cid AND batchid = $bid AND teacherid = $tid AND classno = $week";
  $result3 = mysqli_query($connect, $query3);
  $row3 = mysqli_fetch_array($result3);
  $avg = round($row3['avgrating'],2);
  $allrev = '<h4 class="nomargin" style="font-weight:normal;font-size:20px;">Average rating for the class - '.$avg.'/5 </h4><hr>
              <h4 class="nomargin" style="font-weight:normal;font-size:20px;">Individual reviews by the students - </h4><br>';
  while($row1 = mysqli_fetch_array($result1)){
    $sid = $row1['studentid'];
    $rating = $row1['rating'];
    $fdb = $row1['feedback'];
    $sugg = $row1['suggestions'];
    $query2 = "SELECT name,photo from student WHERE id=$sid";
    $result2 = mysqli_query($connect, $query2);
    $row2 = mysqli_fetch_array($result2);
    $sname = $row2['name'];
    $sphoto = $row2['photo'];
    $snamelink = '<a class="namelink" href="stdadmin.php?sid='.$sid.'">'.$sname.'</a>';
    $spic = '<img src="data:image/jpeg;base64,'.base64_encode($sphoto ).'" class="commentpic img-fluid" />';
    $review = '<div class="stdrev container-fluid">
          <div class="row padding-top">
            <div class="col-6">
              <div class="row">
                <div class="col-2 nopadding-right">'.$spic.'</div>
                <div class="col-9 nopadding-left">
                  <h5 style="padding-top:5px;">'.$snamelink.'</h5>
                </div>
              </div>
            </div>
            <div class="col-6">
              <h6 style="float:right; padding-top:8px;">Rating - '.$rating.'/5</h6>
            </div>
          </div>
          <hr>
          <h6>Suggestions - </h6>
          <p class="para">'.$sugg.'</p>
          <h6>Feedback - </h6>
          <p class="para">'.$fdb.'</p>
        </div> <br> ';
    $allrev .= $review;
    
  }
  echo $allrev;
?>
