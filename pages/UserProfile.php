<style>
  .user_pic{

    width: 300px;
    max-width: 300px;
    height: 300px;
    border-radius:50%;
  }

  .cont{
    border:1px solid #e0e5e5;
    background:white;
    padding:10px;
    margin-left:10px;
    margin-right: 10px;
    border-radius: 10px;
  }

  label{
    color:#6d6f6f;
    margin-left:10px;
  }

  .prof_pic{
  width:40px;
  height:40px;
  border-radius:50%;
}

.prof_pic_r{
  width:30px;
  height:30px;
  border-radius:50%;
}

.pDate{
  font-size:11px; 
}

.post{
  margin:2%;
  margin-bottom:5%;
  border:1px solid #E3E5E7;
  padding:10px;
  background-color: white;
  border-radius:10px;
}

.post_img{
  width: 50%;
  max-width:50%;
  border-radius:5px;
}
.about{
  color:green;
  margin:2px;
  font-weight: bold;
}
.comment{
  margin-top:10px;
  padding:10px; 
  display:none;
}
.reply{
  /*margin-left:3%;*/
  margin-left:5px;
  font-size:12px; 
  /*background:#f0eceb;*/
  padding:5px;
  border-radius:3px;
  /*display:none*/
}

.subreply{
  display:none;
}
</style>
<?php
include ('../conn.php');
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
$id = $_GET['id']; 
//echo $_SESSION['UserID'];

if ($id==0){
  echo "<p>Hello there,</p>"; 
 echo "<p>Sytem not allow users to view anonymous post user profile. this is one of the policy on this community.<br> salamat po.</p>";
  return;
}

$datas = mysqli_query($conn,"SELECT t1.id,t1.fname,t1.mname,t1.lname,t1.email
                                    ,t2.muni_desc,t3.brgy_desc,t1.purok,t1.DateCreated,t1.profile_pic
                            FROM user_tbl t1
                            LEFT JOIN add_muni t2 on t1.muni=t2.id
                            LEFT JOIN add_brgy t3 on t2.id=t3.muni_id
                            WHERE t1.id=$id");
        
foreach($datas as $data){ 
  $fname = $data['fname'];
  $mname = $data['mname'];
  $lname = $data['lname'];
  $email = $data['email'];  
  $muni_desc = $data['muni_desc'];
  $brgy_desc = $data['brgy_desc'];
  $purok = $data['purok'];
  $DateCreated = $data['DateCreated'];
  $profile_pic = $data['profile_pic'];
} 
//$profile_pic;
 

echo "
    <div class='row cont'>
      <div class='col-md-4'> 
        <center>
        <img class='user_pic' src='".$profile_pic."'/>
        </center>
      </div>
      <div class='col-md-8'>
          <b>Firstname:</b>
          <label>".$fname."</label><br>

          <b>Middlename:</b>
          <label>".$mname."</label><br>

          <b>Lastname:</b>
          <label>".$lname."</label><br>

          <b>Address:</b>
          <label>".$muni_desc."</label><br>
          <hr>
          <b>Purok:</b>
          <label>".$brgy_desc."</label><br>

          <b>Street:</b>
          <label>".$purok."</label><br>
          <hr>
          <b>Date Joined:</b>
          <label>".$DateCreated."</label><br>
          <hr>";
          
          if ($_SESSION['UserID']==$id){
            echo "<button class='btn btn-info' name='btn_editProfile'>Edit my profile</button>
            <button class='btn btn-danger' name='btn_changePass'>Change Password</button>";
          }
         

     echo "</div>
    </div>
    ";

    echo "<hr>";

    $datas2 = mysqli_query($conn,"SELECT t1.id 
                                    FROM post_tb t1
                                    LEFT JOIN user_tbl t2 on t1.UserID=t2.id
                                    LEFT JOIN category_tb t3 on t1.CategoryID=t3.id
                                    WHERE IsDeleted=0 and t2.id=$id
                                    ORDER BY t1.id DESC");
      $num=1;
      foreach($datas2 as $data){   
              $_GET['id'] = $data["id"]; 
              include ('post_content.php');
              //echo "</div>";
              $num+=1;
      } 
      if ($num==1){
        echo "<center><h5>No post here!</h5></center>";
      }
?>


