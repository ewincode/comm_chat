<?php
include('../conn.php');  

$id  = $_GET['id'];
$val="";

echo ($id==0) ? "<h3>Add New Category</h3>" : "<h3>Edit Category</h3>";

$datas = mysqli_query($conn,"SELECT Category FROM category_tb WHERE id='$id'");  
foreach($datas as $data){  
  $val = $data['Category'];
} 

echo " 
     <div classw='row'>
        <br>
        <div class='col-md-4'>
            Category:<br>
            <input type='text' class='form-control' id='CatTxt' value='".$val."'/> 
            <div id='123123'></div>
            <br>
            <button class='btn btn-info' onclick='return GlobalExec(2,".$id.",123123)'>Submit</button>
        </div>
     </div>
     ";

/*
$datas = mysqli_query($conn,"SELECT muni_desc FROM add_muni WHERE id='$id'");  
foreach($datas as $data){  
  $val = $data['muni_desc'];
} 

echo " 
     <div classw='row'>
        <br>
        <div class='col-md-4'>
            Municipality:<br>
            <input type='text' class='form-control' id='MuniTxt' value='".$val."'/> 
            <div id='123123'></div>
            <br>
            <button class='btn btn-info' onclick='return GlobalExec(0,".$id.",123123)'>Submit</button>
        </div>
     </div>
     ";

*/
?>