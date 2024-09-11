<?php 
include('../conn.php');  
session_start();
if(empty($_SESSION["IsLogin"])){
  header("Location: logout.php"); 
} 
$UserID = $_SESSION['UserID']; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Responsive Website with Bootstrap</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"> 

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <style>
    body {
  padding-top: 60px; /* Adjust based on your fixed header height */
  background-color: #f1f1f1;
}


 
#sidebar {
  top: 60px; /* Adjust based on your fixed header height */
  height: calc(100vh - 60px); /* Adjust based on your fixed header height */
  position: fixed;
}

main {
  margin-left: 250px; /* Width of the sidebar */
  margin-top:2%;
}

/* Adjust the margin for smaller screens */
@media (max-width: 767.98px) {
  main {
    margin-left: 0;
  }

  .navbar-toggler {
    display: block;
  }
}

.d_inline{
  display:inline-block;
}

.btn {
  background-color: #F4B30E;
  border: none;
  color: white;
  padding: 12px 16px;
  font-size: 16px;
  cursor: pointer;
}

.comm_tbl{
  /*background:red;*/
  padding:20px;
}
 
.like{
  color:#48a4ca;
  cursor:pointer; 
}

.like:hover{
  color:gray; 
}

.ProfilePic{
  border-radius:50%;
  width: 50px;
  height: 50px;
}

.UserName{
  cursor: pointer;
}



.SearchResult{ 
   position: relative;
      width: 300px; /* Or any other width you prefer */ 
      background-color: #f0f0f0; 
}

.SearchBox{ 
  color: black;
  position: fixed;  
  background-color: #ffffff;  
  width: 300px; /* Set your desired fixed width */
  border: 1px solid gray;
   
}

.Searchbox2{
        display:none;
    }
.Searchbox{ 
     display:inline-block;
     float: right;
}
 
 .srch_row{
    cursor: pointer;
}

.srch_row:hover{
   background:#E5E0DF;
}

@media (max-width: 767.98px) {
      /* Adjust sidebar width and other styles for smaller screens */
      #sidebar {
        width: 100%; /* background-color: red; */
        z-index: 1; 
      }
      main {
        margin-top: 20px; 
      }

      .sysTitle{
        display:none
      }

      .Searchbox2{
        display:block;
    }
    .Searchbox{
        display:none;
    }

    .SearchBox{   
      width: 100%; /* Set your desired fixed width */ 
    }
  }
  
  #not_bdg{
    background-color:red;
    padding:5px;
    border-radius:3px; 
    position: relative; 
  }


  /* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 2000; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
  background-color: #fefefe;
  margin: auto; 
  border: 1px solid #888;
  width: 100%;
  height: 100%;
}

/* The Close Button */
.close {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}


  </style>
</head>
<body>
  <header class="fixed-top bg-info text-white text-center p-3" >
 
    <div class="d_inline" style="float:left">
     <?php
      echo "<img class='ProfilePic' src='".$_SESSION['profile_pic']."'/>"; 
      echo " Hi, ".$_SESSION["fname"]; 
     ?>
     </div> 
   
    
   
    <div class="d_inline sysTitle"> 
    <h5>WEb-based Community Suggestion and Feedback System</h5>
    </div>

      <div class="Searchbox"> 
         <input type="text" class="form-control" id="search" name="search" placeholder="Search.." onkeyup="return SearchNow(this.value,0)"/>
         <div class="SearchResult" id="DivResult" ></div>
      </div>

      
    <div class="d_inline" style="float:right" id="ThisMenu">  
        <button class="navbar-toggler d-md-none" type="button" data-toggle="collapse" data-target="#sidebar"    aria-controls="sidebar" aria-expanded="false" aria-label="Toggle navigation">  
        <span class="navbar-toggler-icon">&#9776;</span>
        </button>
     </div>  

     <div  class="d_inline" style="float:right" id="" onclick="return ShowNotifications()">
        <i class="fa fa-bell" style="font-size:24px; color:#78eafa"></i>
        <span id='not_bdg'>0</span> 
     </div>

</header>
<form method="post">
  <div class="container-fluid">
    <div class="row">
      <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
        <div class="position-sticky" >

          <ul class="nav flex-column">
            
            <li class="nav-item">
             <!--<button name="post_button">+ POST</button> -->
             <br>
             <div class='BtnMenu'><button name="home_button" class="btn"><i class="fa fa-home"></i></button> Home</div>
             <br>
             <div class='BtnMenu'><button name="post_button" class="btn"><i class="fa fa-plus-square-o"></i></button> Create Post</div>
             <br>
             <div class='BtnMenu'><button name="prof_button" class="btn"><i class="fa fa-cog"></i></button> Profile Settings</div>
             <br>
             <div class='BtnMenu'><button name="out_button" onclick="return LogOutNow()" class="btn"><i class="fa fa-sign-out"></i></button> Logout</div>

            <div class="Searchbox2"> 
              <br>
           <!-- <input type="text" class="form-control" id="search" name="search" placeholder="Search.." onchange="return 
            (this.value)"/>-->
              <input type="text" class="form-control" id="search2" name="search2" placeholder="Search.." onkeyup="return SearchNow(this.value,1)"/>
              <div class="SearchResult" id="DivResult2" ></div>
            </div>
            </li>
            

          </ul>
        </div>
      </nav>
      <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4"> 
      <div id='divContatin'>
          <?php
           
            if(isset($_POST['home_button'])){
              include ('post.php'); 
            }

            else if(isset($_POST['post_button'])){
              include ('create_post.php'); 
            }

            else if(isset($_POST['prof_button'])){
              $_GET['id']=$UserID;
              include ('UserProfile.php'); 
            }

            else if(isset($_POST['btn_editProfile']))
            {
              $_GET['id']=$UserID;
              include ('EditProfile.php'); 
            }

            else if(isset($_POST['btn_changePass']))
            {
              $_GET['id']=$UserID;
              include ('ChangePass.php'); 
            }

            else if(isset($_POST['btnPass']))
            {
             // $_GET['id']=$UserID;
              //include ('ChangePass.php'); 

              if ($_SESSION["pass"]!==$_POST['cPassword']){
                echo $_SESSION["pass"]."\n";
                echo "<div class='alert alert-danger'>Current password is incorrect</div>";
              }else{

                $hashed_password = password_hash($_POST['nPassword'], PASSWORD_DEFAULT);

          
                $stmt = $conn->prepare("UPDATE user_tbl SET upass='$hashed_password' WHERE id=$UserID");
         
                  if ($stmt->execute()) {
                    echo "<div class='alert alert-info'>Password has been successfully changed!</div>";
                  } else {
                      echo "Error: " . $stmt->error;
                  } 
                  $stmt->close();
                  $conn->close(); 
              }
            }
            //btnPass,cPassword,nPassword

            else if(isset($_POST['updt_btn'])){
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $mname = $_POST['mname'];
            $email = $_POST['email']; 
            $img_profile = $_POST['img_profile']; 
            $muni = $_POST['municipality'];
            $brgy = $_POST['brgy'];
            $Purok = $_POST['Purok'];
            
            $stmt = $conn->prepare("UPDATE user_tbl
                                  SET fname='$fname',
                                      lname='$lname',
                                      mname='$mname',
                                      email='$email', 
                                      profile_pic='$img_profile',
                                      muni=$muni,
                                      brgy=$brgy,
                                      purok='$Purok'
                                  WHERE id=$UserID
                                  ");
          
            // Execute the statement
            if ($stmt->execute()) {   
              $_SESSION["profile_pic"]=$img_profile;
              $_SESSION["fname"]=$fname;
              
              if ($_SESSION["num"]==0){
                echo '<script>location.reload();</script>';
                $_SESSION["num"]=1;
              } 
            } else {
                echo "Error: " . $stmt->error;
            }
           
            $stmt->close();
            $conn->close();
          
          }
           
          else if(isset($_POST['submit_post'])){ 

              $category = $_POST['category'];
              $msg = $_POST['message'];
              $img = $_POST['img'];
              $UnkwonPost = 0; 
              $UserID=$_SESSION["UserID"];
              $Other = "";

              if(!empty($_POST['OthersTxt'])){
                $Other=$_POST['OthersTxt'];
              }

              if (!empty($_POST['UnkwonPost'])){
                $UnkwonPost = 1;
              }
              
              $stmt = $conn->prepare("INSERT INTO post_tb (UserID,IsUnkown,CategoryID,msg,img,OtherCat)VALUES (?,?,?,?,?,?)");
              $stmt->bind_param("ssssss", $UserID,$UnkwonPost,$category,$msg,$img,$Other);
      
                // Execute the statement
                if ($stmt->execute()) {
                  include ('post.php');  
                } else {
                    echo "Error: " . $stmt->error;
                }
       
                $stmt->close();
                $conn->close(); 
            } 
            else{
              include ('post.php'); 
            }
          ?>
          </div>
        </div>
      </main>
    </div>
  </div>

  <!-- The Modal -->
  <div id="myModal" class="modal">  
  <div class="modal-content"> 
    <span class="close"></span>
    <div id="999999999"></div>
  </div> 
  </div>


  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  </form>
</body>
<script>

  var modal = document.getElementById("myModal"); 
  var btn = document.getElementById("myBtn"); 
  var span = document.getElementsByClassName("close")[0];


  span.onclick = function() {
    modal.style.display = "none";
    }

    window.onclick = function(event) {
      if (event.target == modal) {
        modal.style.display = "none";
      }
    }

  function LogOutNow(){
    //alert(123);
    window.location.href="logout.php";
    return false;
  }

  function SelectCat(ThisID){
    //OthersDIV
    var ddl = document.getElementById(ThisID).value;
    if (ddl==0){ 
      var NewBox = "<input type='text' class='form-control' id='OthersTxt' name='OthersTxt' placeholder='Specify others here..' />";
      document.getElementById('OthersDIV').innerHTML=NewBox;
    }else{
      document.getElementById('OthersDIV').innerHTML="";
    }
  }

  function SearchNow(ThisValue,mode){ 

    if (ThisValue==""){
         if (mode==0) {
             document.getElementById('DivResult').innerHTML = ""; 
          } else {
             document.getElementById('DivResult2').innerHTML =  ""; 
          }
          return false;
    }

    var xhr = new XMLHttpRequest();
          xhr.open('GET', 'SearchResult.php?value='+ThisValue, true);
          xhr.onreadystatechange = function() {
              if (xhr.readyState == 4 && xhr.status == 200) {
 

                 if (mode==0) {
                   document.getElementById('DivResult').innerHTML = xhr.responseText; 
                } else {
                   document.getElementById('DivResult2').innerHTML = xhr.responseText; 
                }

               
              }
          };
          xhr.send();

           document.getElementById('sidebar').style.display == "none";
  }


   document.addEventListener('click', function(event) {
        var fixedDiv = document.getElementById('fixedDiv');
        var targetElement = event.target;
 
        if (targetElement != fixedDiv && !fixedDiv.contains(targetElement)) { 
            fixedDiv.style.display = 'none';
        }
    });


  function ViewSearch(thistyp,ThisValue){
     var page = (thistyp==0 ? "UserProfile.php": "post.php"); 
      var xhr = new XMLHttpRequest();
      xhr.open('GET', page+'?id='+ThisValue, true);
      xhr.onreadystatechange = function() {
          if (xhr.readyState == 4 && xhr.status == 200) {
              document.getElementById('divContatin').innerHTML = xhr.responseText; 
              window.scrollTo(0, 0);
          }
      };
      xhr.send();  
   }

   function ShowNotifications(){

    var xhr = new XMLHttpRequest();
      xhr.open('GET', 'notes.php?mode=1', true);
      xhr.onreadystatechange = function() {
          if (xhr.readyState == 4 && xhr.status == 200) { 
            document.getElementById('myModal').innerHTML = xhr.responseText;  
          }
      };
      xhr.send();  

    modal.style.display = "block";
   }

   function ViewNotification(mode){
    alert('Sorry, you cannot open details this time. this may under construct. thank you');
    return false;
   }
 
   function RefreshNotification(){
    var xhr = new XMLHttpRequest();
      xhr.open('GET', 'notes.php?mode=0', true);
      xhr.onreadystatechange = function() {
          if (xhr.readyState == 4 && xhr.status == 200) {
           
            
              if (xhr.responseText=="0"){
                document.getElementById('not_bdg').style.opacity = "0";
              }else{
                document.getElementById('not_bdg').style.opacity = "1";
                document.getElementById('not_bdg').innerHTML = xhr.responseText;  
              }
              
          }
      };
      xhr.send();  
   }

   setInterval(function() {
      RefreshNotification();
  }, 2000); // 10000 milliseconds = 10 seconds

  setInterval();
</script>
</html> 