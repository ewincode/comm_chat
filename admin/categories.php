<style>

  .tbl{
    width: 100%;
  }

</style>
<table style='width:100%'>
  <tr>
    <td><h3>Manage Categories</h3></td>
    <td>
      <button class='btn btn-info' name='btnCategory' style='float:right'>+ Create new</button>
    </td>
  </tr>
</table>
<?php 
    $datas = mysqli_query($conn,"SELECT * FROM category_tb");
    echo "<br><input type='text' id='txtSearch' class='form-control' placeholder='Search anything from table..'  onkeyup='myFunction(this.id,123455)'>";
    echo "<br>";
    echo "<table class='table table-striped' id='123455'>";
    echo "<thead>
          <tr>
            <th>Category</th> 
            <th>Status</th>
            <th>Edit</th>
          </tr>
          </thead>";
    foreach($datas as $data){  
      echo "<tr>
              <td>".$data['Category']."</td> 
              <td>
                  <select id='ddl_status".$data['id']."' onchange='return ExecCommand(".$data['id'].",this.id,3)'>
                      <option value='0' ".($data['status'] == 0 ? 'selected' : '').">ACTIVE</option>
                      <option value='1' ".($data['status'] == 1 ? 'selected' : '').">IN-ACTIVE</option>
                  </select>
              </td> 
              <td>
              <label class='btn btn-info' onclick='return CallPageInto(2,".$data['id'].")'>Edit</label>
              </td>
            </tr>";
    } 
    echo "</table>"; 
?>