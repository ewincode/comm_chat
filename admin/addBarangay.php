<?php
include('../conn.php'); 

$id = $_GET['id'];
$val="";
$muni_id=0;
echo ($id==0) ? "<h3>Add New Purok</h3>" : "<h3>Edit Purok</h3>";

 

$datas = mysqli_query($conn,"SELECT brgy_desc,muni_id FROM add_brgy WHERE id='$id'");  
foreach($datas as $data){  
  $val = $data['brgy_desc'];
  $muni_id = $data['muni_id'];
} 

echo "<div class='row'>
          <div class='col-md-6'>
          Purok: <br>
          <input type='text' id='brgyTxt' class='form-control' value='".$val."'/>
          </div>
      </div>";

$data1 = mysqli_query($conn,"SELECT 0 as id,'' as muni_desc
                              UNION ALL
                              SELECT id,muni_desc 
                              FROM add_muni  "); 

echo "<div class='row'><br><br>
      <div class='col-md-6'><br>";
echo "Barangay:<br>";
echo "<select class='form-control' id='muni_ddl'>";
foreach($data1 as $data)
{ 
echo "<option value='".$data['id']."' ".($muni_id == $data['id'] ? 'selected' : '').">".$data['muni_desc']."</option>"; 
} 
echo "</select>
<br>
<div id='123123'></div>
<br>
<button class='btn btn-info' onclick='return GlobalExec(1,".$id.",123123)'>Submit</button>
</div>
</div>";
/*

$datas = mysqli_query($conn,"SELECT 0 as id,'' as muni_desc
                              UNION ALL
                              SELECT id,muni_desc 
                              FROM add_muni  "); 

echo "<div class='row'><br><br>
      <div class='col-md-6'>";
echo "Municipality:<br>";
echo "<select class='form-control'>";
foreach($datas as $data)
{ 
echo "<option value='".$data['id']."' ".($id == $data['id'] ? 'selected' : '').">".$data['muni_desc']."</option>"; 
} 
echo "</select>
</div>
</div>";
*/


?>