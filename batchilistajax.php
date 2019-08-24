<?php
  $connect = mysqli_connect("localhost","root","","tvb");
  $cid = $_POST['cid']; 
  $bid = $_POST['bid'];
  $query1 = "SELECT id,name FROM teacher WHERE id NOT IN (
            SELECT teacherid FROM teachercourse WHERE courseid = $cid AND batchid = $bid) ORDER BY name ASC";
  $result1 = mysqli_query($connect, $query1);
  $ilisttable = '<table class="table table-bordered table-hover">
    <thead class="thead-dark">
      <tr>
        <th scope="col"></th>
        <th scope="col" style="color:white;">ID</th>
        <th scope="col" style="color:white;">Name</th>
      </tr>
    </thead>
    <tbody>';
  while($row1 = mysqli_fetch_array($result1)){
    $tid = $row1['id'];
    $tname = $row1['name'];
    $trow = '<tr>
        <th scope="row"><input type="checkbox" name="teachers[]" value="'.$tid.'"></th>
        <td>'.$tid.'</td>
        <td>'.$tname.'</td>
      </tr>';
    $ilisttable .= $trow;
  }
  $ilisttable .= '</tbody>
  </table>';
  echo $ilisttable;
?>