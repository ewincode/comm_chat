<?php
 include ('conn.php'); 
//echo $_GET['id'];
$id = $_GET['id'];
$purok = ""; 

if (!empty($_GET['purok'])){ 
  $purok =$_GET['purok'];
}

$datas = mysqli_query($conn,"SELECT 0 as id,'' as brgy_desc
                            UNION ALL
                            SELECT id,brgy_desc 
                            FROM add_brgy 
                            WHERE muni_id=$id and status=0");
echo "<br>";
echo "Purok:";
echo "<select class='form-control' name='brgy'>";
foreach($datas as $data)
{ 
if (!empty($_GET['val'])){ 
  echo "<option value='".$data['id']."' ".($_GET['val'] == $data['id'] ? 'selected' : '').">".$data['brgy_desc']."</option>"; 
}else{
  echo "<option value='".$data['id']."'>".$data['brgy_desc']."</option>";
}

}  
echo "</select>
<br>
Street<br>
<input type='text' class='form-control' name='Purok' value='".$purok."'/>
";

?>