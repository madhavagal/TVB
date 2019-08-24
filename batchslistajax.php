<?php
  $connect = mysqli_connect("localhost","root","","tvb");
  $cid = $_POST['cid']; 
  $bid = $_POST['bid'];
  $checked = json_decode(stripslashes($_POST['checked']));
  if(empty($_POST['search'])){  
    $q = "";
  }else{
    $s = $_POST['search'];
    $q = "name LIKE '%$s%' AND ";
  }
  $query1 = "SELECT id,name FROM student WHERE $q id NOT IN (
            SELECT studentid FROM studentcourse WHERE courseid = $cid AND batchid = $bid) ORDER BY name ASC";
  $result1 = mysqli_query($connect, $query1);
  $slisttable = '<table class="table table-bordered table-hover">
    <thead class="thead-dark">
      <tr>
        <th scope="col"></th>
        <th scope="col" style="color:white;">ID</th>
        <th scope="col" style="color:white;">Name</th>
      </tr>
    </thead>
    <tbody>';
  foreach($checked as $j){
    $query2 = "SELECT name FROM student WHERE id = $j";
    $result2 = mysqli_query($connect, $query2);
    $row2 = mysqli_fetch_array($result2);
    $name = $row2['name'];
    $srow = '<tr>
        <th scope="row"><input type="checkbox" name="students'.$bid.'[]" value="'.$j.'" checked></th>
        <td>'.$j.'</td>
        <td>'.$name.'</td>
      </tr>';
    $slisttable .= $srow;
  }
  while($row1 = mysqli_fetch_array($result1)){
    $sid = $row1['id'];
    if(in_array($sid,$checked)){
      //$sname = $row1['name'];
    }
    else{
      $sname = $row1['name'];
      $srow = '<tr>
        <th scope="row"><input type="checkbox" name="students'.$bid.'[]" value="'.$sid.'"></th>
        <td>'.$sid.'</td>
        <td>'.$sname.'</td>
      </tr>';
      $slisttable .= $srow;
    }
  }
  $slisttable .= '</tbody>
  </table>';
  echo $slisttable;
?>