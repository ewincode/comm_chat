<style>

  .tbl{
    width: 100%;
  }

</style>
<h3>Manage Address</h3>
<br>
 
<table style='width:100%;background:#d7d7d8;'>
  <tr>
    <td style='width:70%'>
    <h5 style='display:inline-block'>List of Barangay</h5>
    <button class='btn btn-info' name='btnAddress' style='display:inline-block'>+Add</button>
    </td>
    <td><input type='text' id='txtSearch' class='form-control' placeholder='Search anything from table..'  onkeyup='myFunction(this.id,123455)'></td>
  </tr>
</table> 
<?php 
    $datas = mysqli_query($conn,"SELECT * FROM add_muni"); 
    echo "<table class='table table-striped' id='123455'>";
    echo "<thead>
          <tr>
            <th>Barangay</th>
            <th>Status</th>
            <th>Edit</th>
          </tr> 
          </thead>";
    foreach($datas as $data){  
      echo "<tr>
              <td>".$data['muni_desc']."</td> 
              <td>
                  <select id='ddl_status".$data['id']."' onchange='return ExecCommand(".$data['id'].",this.id,1)'>
                      <option value='0' ".($data['status'] == 0 ? 'selected' : '').">ACTIVE</option>
                      <option value='1' ".($data['status'] == 1 ? 'selected' : '').">IN-ACTIVE</option>
                  </select>
              </td> 
              <td><label class='btn btn-info' onclick='return CallPageInto(0,".$data['id'].")'>Edit</label></td>
            </tr>";
    } 
    echo "</table>";  
  ?>

<br><br>
<table style='width:100%;background:#d7d7d8;'>
  <tr>
    <td style='width:70%'>
    <h5 style='display:inline-block'>List of Purok</h5>
    <button class='btn btn-info' name='btnBarangay' style='display:inline-block'>+Add</button>
    </td>
    <td><input type='text' id='txtSearch2' class='form-control' placeholder='Search anything from table..'  onkeyup='myFunction(this.id,123456)'></td>
  </tr>
</table> 
<?php 
    $datas = mysqli_query($conn,"SELECT t1.id,t1.brgy_desc,t2.muni_desc,t1.status
    FROM add_brgy t1
    LEFT JOIN add_muni t2 on t1.muni_id=t2.id"); 
    echo "<table class='table table-striped' id='123456'>";
    echo "<thead>
          <tr>
            <th>Purok</th>
            <th>Barangay</th>
            <th>Status</th>
            <th>Edit</th>
          </tr>
          </thead>";
    foreach($datas as $data){  
      echo "<tr>
              <td>".$data['brgy_desc']."</td> 
              <td>".$data['muni_desc']."</td> 
              <td>
                  <select id='ddl_status2".$data['id']."' onchange='return ExecCommand(".$data['id'].",this.id,2)'>
                      <option value='0' ".($data['status'] == 0 ? 'selected' : '').">ACTIVE</option>
                      <option value='1' ".($data['status'] == 1 ? 'selected' : '').">IN-ACTIVE</option>
                  </select>
              </td> 
              <td>
              <label class='btn btn-info' onclick='return CallPageInto(1,".$data['id'].")'>Edit</label>
              </td>
            </tr>";
    } 
    echo "</table>"; 
  ?>