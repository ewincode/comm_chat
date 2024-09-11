<?php

$id=$_GET['id']; 
$_SESSION["num"]=0; 
$datas = mysqli_query($conn,"SELECT t1.id,t1.fname,t1.mname,t1.lname,t1.email
                                    ,t2.id as muniID,t3.id as BrgID,t1.purok,t1.DateCreated,t1.profile_pic
                            FROM user_tbl t1
                            LEFT JOIN add_muni t2 on t1.muni=t2.id
                            LEFT JOIN add_brgy t3 on t2.id=t3.muni_id
                            WHERE t1.id=$id");
        
foreach($datas as $data){ 
  $fname = $data['fname'];
  $mname = $data['mname'];
  $lname = $data['lname'];
  $email = $data['email'];  
  $muniID = $data['muniID'];
  $BrgID = $data['BrgID'];
  $purok = $data['purok'];
  $DateCreated = $data['DateCreated'];
  $profile_pic = $data['profile_pic'];
} 

?>

<style>
  .profile_pic{
    width:400px;  
    height:400px; 
    box-shadow: 2px 2px 10px  #888888;
  }
</style>
<body></body>
<form method="POST">
  <center><h1>Join Here</h1></center> 
  <input type="hidden" name="img_profile" id="img_profile" value='<?php echo $profile_pic; ?>'>
  <div class="container">  
      <div class="row">
      <div class="col-md-6"> 
      <br>
      <div class="row">
        <div class="col-md-12"> 
          <center>
          <img id="imageDisplay" alt="" src='<?php echo $profile_pic; ?>' class="profile_pic">
          </center>
        </div>
        
        <div class="col-md-12">
        <hr>
          <center>
          <input type="file" id="imageInput" accept="image/*">
          </center>
        </div>
      </div> 

      </div>
        <div class="col-md-6">
        <div class="row"> 
                <div class="col-md">
                    Firstname:
                    <input type="text" class="form-control" name="fname" value='<?php echo $fname; ?>'/>
                  </div>  
              </div>
              <div class="row"> 
                  <div class="col-md">
                    Middlename:
                    <input type="text" class="form-control" name="mname" value='<?php echo $mname; ?>'/>
                  </div>  
              </div>
              <div class="row"> 
                  <div class="col-md">
                    Lastname:
                    <input type="text" class="form-control" name="lname" value='<?php echo $lname; ?>'/>
                  </div>  
              </div> 
              <div class="row"> 
                  <div class="col-md">
                    Email:
                    <input type="email" class="form-control" name="email" value='<?php echo $email; ?>'/>
                  </div>  
              </div> <!--../brgy.php-->
              <div class="row"> 
                  <div class="col-md">
                    <br>
                    Barangay:
                    <select class='form-control' name='municipality' id='municipality' onchange="return SelectCity(this.id)">
                      <?php
                        $datas = mysqli_query($conn,"SELECT 0 as id,'' as muni_desc
                                                      UNION ALL
                                                      SELECT id,muni_desc 
                                                      FROM add_muni  "); 
                          foreach($datas as $data)
                          { 
                            echo "<option value='".$data['id']."' ".($data['id'] == $data['id'] ? 'selected' : '').">".$data['muni_desc']."</option>"; 
                          } 


                      ?>
                    </select>
                  </div>  
              </div>
              <div class="row">
                <div class="col-md">
                  <div id='divBrgy'>
                    <?php
                      $_GET['id']=$muniID;
                      $_GET['val']=$BrgID;
                      $_GET['purok']=$purok;
                      include('../brgy.php');
                    ?>
                  </div>
                </div>
              </div>

              <hr>
              <br> 
              <div class="row">  
                  <div class="col-md"> 
                  <br>
                    <center>
                    <button class="btn btn-info" name="updt_btn" onclick='return SaveUpdates()'>Save Updates</button>
                    </center>
                  </div>  
              </div>
        </div> 
      </div>
  </div> 
</form> 

<script>
        function SaveUpdates(){
          if (confirm('Are you sure, you want to save updates?')){ 
          }else{
            return false;
          }
        }

       function SelectCity(ddl_id){
          var val = document.getElementById(ddl_id).value; 
          var xhr = new XMLHttpRequest();
            xhr.open('GET', '../brgy.php?id='+val, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                  //document.getElementById('divBrgy').innerHTML = "hahaha"; 
                   document.getElementById('divBrgy').innerHTML = xhr.responseText; 
                }
            };
            xhr.send();
       }

        document.getElementById('imageInput').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const reader = new FileReader(); 
            
            reader.onloadend = function() {
                const base64String = reader.result; 
                console.log(base64String);
                document.getElementById('imageDisplay').src = base64String;
                document.getElementById('img_profile').value = base64String;
            };
            
            if (file) {
                reader.readAsDataURL(file);
            } 
        });
 

    </script>


</html>