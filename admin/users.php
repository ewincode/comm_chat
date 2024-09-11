<style>

  .tbl{
    width: 100%;
  }

</style>
<h3>Manage Users</h3>
<?php 
    $datas = mysqli_query($conn,"SELECT *
                                  FROM(
                                      SELECT t1.id,t1.fname,t1.mname,t1.lname,t1.email,t1.Status,t1.profile_pic
                                            ,CONCAT(t2.muni_desc,' ',t3.brgy_desc,' ',t1.purok)as Address,Isstaff
                                      FROM user_tbl t1
                                      LEFT JOIN add_muni t2 on t1.muni=t2.id
                                      LEFT JOIN add_brgy t3 on t2.id=t3.muni_id
                                      WHERE fname<>'admin' ORDER BY fname 
                                      )t1
                                  ORDER BY Address,fname");
    echo "<br><input type='text' id='txtSearch' class='form-control' placeholder='Search anything from table..'  onkeyup='myFunction(this.id,123455)'>";
    echo "<br>";
    echo "<table class='table table-striped' id='123455'>";
    echo "<thead>
          <tr>
            <th>Address</th>
            <th>Firstname</th>
            <th>Lastname</th>
            <th>Middlename</th>
            <th>Email</th>
            <th>Is Staff</th>
            <th>Status</th>
          </tr>
          </thead>";
    foreach($datas as $data){  
      echo "<tr>
              <td>".$data['Address']."</td>
              <td>".$data['fname']."</td>
              <td>".$data['lname']."</td>
              <td>".$data['mname']."</td>
              <td>".$data['email']."</td>
              <td>
              <select id='ddl_Isstaff".$data['id']."' onchange='return ExecCommand(".$data['id'].",this.id,4)'>
                  <option value='0' ".($data['Isstaff'] == 0 ? 'selected' : '').">NO</option>
                  <option value='1' ".($data['Isstaff'] == 1 ? 'selected' : '').">YES</option>
              </select>
          </td> 
              <td>
                  <select id='ddl_status".$data['id']."' onchange='return ExecCommand(".$data['id'].",this.id,0)'>
                      <option value='0' ".($data['Status'] == 0 ? 'selected' : '').">ACTIVE</option>
                      <option value='1' ".($data['Status'] == 1 ? 'selected' : '').">IN-ACTIVE</option>
                  </select>
              </td> 
            </tr>";
    } 
    echo "</table>"; 
?>