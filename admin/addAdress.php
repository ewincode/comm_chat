<?php
include('../conn.php');  

$id  = $_GET['id'];
$val="";

echo ($id==0) ? "<h3>Add New Barangay</h3>" : "<h3>Edit Barangay</h3>";

$datas = mysqli_query($conn,"SELECT muni_desc FROM add_muni WHERE id='$id'");  
foreach($datas as $data){  
  $val = $data['muni_desc'];
} 

echo " 
     <div classw='row'>
        <br>
        <div class='col-md-4'>
            Barangay: <br>
            <input type='text' class='form-control' id='MuniTxt' value='".$val."'/> 
            <div id='123123'></div>
            <br>
            <button class='btn btn-info' onclick='return GlobalExec(0,".$id.",123123)'>Submit</button>
        </div>
     </div>
     ";

?>