<?php
  $connect = mysqli_connect("localhost","root","","tvb");

  $cid = $_POST['course'];
  $bid = $_POST['batch'];
  $query1 = "SELECT classno,classdate,teacherid FROM courseclass WHERE courseid = $cid AND batchid = $bid AND classdate < CURRENT_DATE ORDER BY classno DESC";
  $result1 = mysqli_query($connect, $query1);
  $query4 = "SELECT name FROM course WHERE id = $cid";
  $result4 = mysqli_query($connect, $query4);
  $row4 = mysqli_fetch_array($result4);
  $cname = $row4['name'];
  if(mysqli_num_rows($result1) == 0){
    $dynouter = '<h4 class="nomargin" style="font-weight:normal;">No Reviews</h4>';
    echo $dynouter;
  }
  else{
  
  
  $dynouter = '<div class="faq-row-container">';
  $dynbtns = '<div class="faq-row-handle">';
  $dyncontent = '<div class="faq-row">';
  while($row1 = mysqli_fetch_array($result1)){
    $weekno = $row1['classno'];
    $tid = $row1['teacherid'];
    $btn = '<a href="javascript:;" class="btn btn-primary" rel="week'.$weekno.'">Class '.$weekno.'</a>';
    $dynbtns .= $btn;
    $query2 = "SELECT name FROM teacher WHERE id = $tid";
    $result2 = mysqli_query($connect, $query2);
    $row2 = mysqli_fetch_array($result2);
    $tname = $row2['name'];
    $tnamelink = '<a class="namelink" href="teachadm.php?tid='.$tid.'" style="font-weight:bold;">'.$tname.'</a>';
    $query3 = "SELECT AVG(rating) AS avg FROM review WHERE classno = $weekno AND courseid = $cid AND batchid = $bid AND teacherid = $tid";
    $result3 = mysqli_query($connect, $query3);
    $row3 = mysqli_fetch_array($result3);
    $avgrating = round($row3['avg'], 2) ;
    $query9 = "SELECT COUNT(*) AS stdcount FROM studentcourse WHERE courseid = $cid AND batchid = $bid";
    $result9 = mysqli_query($connect, $query9);
    $row9 = mysqli_fetch_array($result9);
    $stdcount = $row9['stdcount'];
    $query10 = "SELECT COUNT(*) AS stdrev FROM review WHERE courseid = $cid AND batchid = $bid AND classno = $weekno";
    $result10 = mysqli_query($connect, $query10);
    $row10 = mysqli_fetch_array($result10);
    $stdrev = $row10['stdrev'];
    $dynweek = '<div class="faq-row-content weekrev" id="week'.$weekno.'">

                  <h4 class="nomargin" style="font-weight:bold;margin-bottom:10px;">Class '.$weekno.'<span style="font-weight:normal;"> by </span>'.$tnamelink.'</h4>
                  <h6 class="nomargin" style="font-weight:normal;margin-bottom:10px;">'.$stdrev.' out of '.$stdcount.' students have reviewed this class</h6>
                  <h6 class="nomargin" style="font-weight:bold;">Average rating - '.$avgrating.'</h6>
                  <br>
                  <div class="scrollable">

                  <table class="table table-bordered">
                    <thead class="thead-dark ">
                      <tr>
                        <th scope="col" style="color:white;">Photo</th>
                        <th scope="col" style="color:white;">Name</th>
                        <th scope="col" style="color:white;">Suggestions By Student</th>
                        <th scope="col" style="color:white;">Feedback By Student</th>
                        <th scope="col" style="color:white;">Student Performance By Teacher</th>
                        <th scope="col" style="color:white;">Project Grades By Teacher</th>
                      </tr>
                    </thead>
                    <tbody>';
    
//      $query5 = "SELECT review.studentid, review.teacherid, review.courseid, review.batchid,            review.classno, review.feedback, review.suggestions, performance.progress FROM review LEFT OUTER JOIN performance ON review.courseid = performance.courseid AND review.classno = performance.classno AND review.batchid = performance.batchid AND review.studentid = performance.studentid AND review.teacherid = performance.teacherid WHERE review.courseid = $cid AND review.batchid = $bid AND review.classno = $weekno
//        UNION
//        SELECT performance.studentid, performance.teacherid, performance.courseid, performance.batchid, performance.classno, review.feedback, review.suggestions, performance.progress FROM review RIGHT OUTER JOIN performance ON review.courseid = performance.courseid AND review.classno = performance.classno AND review.batchid = performance.batchid AND review.studentid = performance.studentid AND review.teacherid = performance.teacherid WHERE performance.courseid = $cid AND performance.batchid = $bid AND performance.classno = $weekno";
    $query5 = "SELECT studentid FROM studentcourse WHERE courseid = $cid AND batchid = $bid";
    $result5 = mysqli_query($connect, $query5);
    while($row5 = mysqli_fetch_array($result5)){
      $sid = $row5['studentid'];
      $query7 = "SELECT feedback,suggestions FROM review WHERE studentid = $sid AND courseid = $cid AND batchid = $bid AND classno = $weekno";
      $result7 = mysqli_query($connect, $query7);
      $row7 = mysqli_fetch_array($result7);
      $query8 = "SELECT progress,project FROM performance WHERE studentid = $sid AND courseid = $cid AND batchid = $bid AND classno = $weekno";
      $result8 = mysqli_query($connect, $query8);
      $row8 = mysqli_fetch_array($result8);
      if(empty($row7['suggestions'])){
        $sug = "<p style='color:red;'>Not added yet</p>";
      }
      else{
        $sug = $row7['suggestions'];
      }
      if(empty($row7['feedback'])){
        $feed = "<p style='color:red;'>Not added yet</p>";
      }
      else{
        $feed = $row7['feedback'];
      }
      if(empty($row8['progress'])){
        $perf = "<p style='color:red;'>Not added yet</p>";
      }
      else{
        $perf = $row8['progress'];
      }
      if(empty($row8['project'])){
        $grade = "<p style='color:red;'>No Project</p>";
      }
      else{
        $grade = $row8['project'];
      }
      $query6 = "SELECT name,photo FROM student WHERE id = $sid";
      $result6 = mysqli_query($connect, $query6);
      $row6 = mysqli_fetch_array($result6);
      $sname = $row6['name'];
      $sphoto = $row6['photo'];
      if(empty($sphoto))
        {
          $sprofilepic = '<img src="assets1/default.png" width="50" height = "60"  alt="Your profile pic here" />';
        }
        else{
          $sprofilepic = '<img src="data:image/jpeg;base64,'.base64_encode($sphoto ).'" width="50" height = "60"  alt="Your profile pic here" />';
        }
      $snamelink = '<a class="namelink" href="stdadmin.php?sid='.$sid.'">'.$sname.'</a>';
      $dynrow = '  <tr>
              <td>'.$sprofilepic.'</td>
              <td>'.$snamelink.'</td>
              <td>'.$sug.'</td>
              <td>'.$feed.'</td>
              <td>'.$perf.'</td>
              <td>'.$grade.'</td>
            </tr>';
      
      $dynweek .= $dynrow;
    }
    $dynweek .= '      </tbody>
        </table>

      </div>

    </div>';
    $dyncontent .= $dynweek;
  }
  $dynbtns .= '<div class="clear"></div>
    </div> <br>';
  $dyncontent .= '<div class="clear"></div>
    </div>';
  $dynouter .= $dynbtns;
  $dynouter .= $dyncontent;
  $dynouter .= '</div>';
  echo $dynouter;
  }
?>