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
  background-color:#F4B30E;
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

.post{
  margin:2%;
  margin-bottom:5%;
  border:1px solid #E3E5E7;
  padding:10px;
}

.post_img{
  width: 50%;
  max-width:50%;
  border-radius:5px;
}

.prof_pic_r{
  width:30px;
  height:30px;
  border-radius:50%;
}
.about{
  color:green;
  margin:2px;
  font-weight: bold;
}
.UserName{
  cursor: pointer;
}
  </style>
</head>
<body>
  <header class="fixed-top bg-info text-white text-center p-3">
    
     <div class="d_inline" style="float:left">
        <button class="navbar-toggler d-md-none" type="button" data-toggle="collapse" data-target="#sidebar"    aria-controls="sidebar" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon">&#9776;</span>
        </button>
     </div> 

    <div class="d_inline">
    <h5>Catbalogan Community Suggestions And Feedback</h5>
    </div> 

</header>
<form method="post">
  <div class="container-fluid">
    <div class="row">
      <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
        <div class="position-sticky">

          <ul class="nav flex-column">
             
          
            <li class="nav-item">  
             <!--<button name="post_button">+ POST</button> -->
             <br>
             <div class='BtnMenu'><button name="dash_button" class="btn"><i class="fa fa-dashboard"></i></button> Dashboard</div>
             <br>
             <div class='BtnMenu'><button name="users_button" class="btn"><i class="fa fa-user"></i></button> Users</div>
             <br>
             <div class='BtnMenu'><button name="add_button" class="btn"><i class="fa fa-map-marker"></i></button> Address</div>
             <br>
             <div class='BtnMenu'><button name="cat_button" class="btn"><i class="fa fa-book"></i></button> Categoires</div> 
             <br>
             <div class='BtnMenu'><button name="out_button" class="btn"><i class="fa fa-sign-out"></i></button> Logout</div>
            
            </li>


          </ul>
        </div> 
      </nav>
      <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4"> 
      <div id='divContent'>
          <?php
            
            if(isset($_POST['users_button'])){
              include ('users.php');  
            }

           else if(isset($_POST['cat_button'])){
              include ('categories.php');  
            }

            else if(isset($_POST['add_button'])){
              include ('address.php');  
            }

            else if(isset($_POST['out_button'])){
              include ('logout.php');  
            }
            
            else if(isset($_POST['dash_button'])){
              include ('post.php');  
            }
            else if(isset($_POST['btnAddress'])){
              $_GET['id']=0; 
              include ('addAdress.php');  
            }
            else if(isset($_POST['btnBarangay'])){
              $_GET['id']=0;  
              $_GET['bar']=0;  
              include ('addBarangay.php');  
            }
            else if(isset($_POST['btnCategory'])){
              $_GET['id']=0;  
              $_GET['bar']=0;  
              include ('addCategory.php');  
            }
            else{
              include ('post.php'); 
            }
 
          ?> 
        </div>
        <div id='divExec'></div>
        </div>
      </main>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  </form>
</body>

<script>
  
  function myFunction(textBoxId, tableId) {
    var $rows = $('#' + tableId + ' tr');
    $('#' + textBoxId).keyup(function() {
        var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();

        $rows.show().filter(function() {
            var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
            return !~text.indexOf(val);
        }).hide();
    });
}
 

function ExecCommand(UserID,DropDownID,mode){
 
  var ddl = document.getElementById(DropDownID);

  if (mode==0){ /*USERS*/
      if (confirm('Are you sure, you want to continue?')){
          ExecNow('ExecCommand.php?mode='+mode+'&id='+UserID+'&ddl='+ddl.value); 
      }else{ 
        if (ddl.value==1){
          ddl.value = 0;
        }else{
          ddl.value = 1;
        }
      } 
  }


  if (mode==1){ /*MUNICIPALITY*/
      if (confirm('Are you sure, you want to continue?')){
          ExecNow('ExecCommand.php?mode='+mode+'&id='+UserID+'&ddl='+ddl.value); 
      }else{ 
        if (ddl.value==1){
          ddl.value = 0;
        }else{
          ddl.value = 1;
        }
      } 
  }

  if (mode==2){ /*BARANGAY*/
      if (confirm('Are you sure, you want to continue?')){
          ExecNow('ExecCommand.php?mode='+mode+'&id='+UserID+'&ddl='+ddl.value); 
      }else{ 
        if (ddl.value==1){
          ddl.value = 0;
        }else{
          ddl.value = 1;
        }
      } 
  }

    if (mode==3){ /*CATEGORY*/ 
        if (confirm('Are you sure, you want to continue?')){
            ExecNow('ExecCommand.php?mode='+mode+'&id='+UserID+'&ddl='+ddl.value);  
        }else{ 
          if (ddl.value==1){
            ddl.value = 0;
          }else{
            ddl.value = 1;
          }
        } 
    }


    if (mode==4){ /*Isstaff*/ 
        if (confirm('Are you sure, you want to continue?')){
            ExecNow('ExecCommand.php?mode='+mode+'&id='+UserID+'&ddl='+ddl.value);  
        }else{ 
          if (ddl.value==1){
            ddl.value = 0;
          }else{
            ddl.value = 1;
          }
        } 
    }


}


function ExecNow(php_page){
  //divExec
    var xhr = new XMLHttpRequest();
      xhr.open('GET', php_page, true);
      xhr.onreadystatechange = function() {
          if (xhr.readyState == 4 && xhr.status == 200) {
              document.getElementById('divExec').innerHTML = xhr.responseText;  
          }
      };
      xhr.send();
}

function OpenPost(PosID){ 
  var xhr = new XMLHttpRequest();
      xhr.open('GET', 'post_convo.php?id='+PosID, true);
      xhr.onreadystatechange = function() {
          if (xhr.readyState == 4 && xhr.status == 200) {
              document.getElementById('PostConvo').innerHTML = xhr.responseText; 
              //window.scrollTo(0, document.body.scrollHeight);
              //scrollDownSlowly();
          }
      };
      xhr.send();
}

function scrollDownSlowly() {
    var scrollInterval = setInterval(function() { 
        window.scrollBy(0, 10); 
        if ((window.innerHeight + window.pageYOffset) >= document.body.offsetHeight) {
            clearInterval(scrollInterval);
        }
    }, 10);  
}

function GlobalExec(mode,id,divId){
 

  var Div = document.getElementById(divId);

  if (mode==0) /*Modify Municipality*/
  {
   
      var MuniTxt = document.getElementById('MuniTxt').value; 
      if (MuniTxt==''){  
          Div.innerHTML = "Please enter Municipality name!"; 
          return false;
      }  
      CallPage('GlobalExecCommand.php?mode='+mode+'&id='+id+'&muni='+MuniTxt,divId);
      return false;
  } 

  if (mode==1) /*Modify Barangay*/
  {
   //id,brgy,muni
      var brgyTxt = document.getElementById('brgyTxt').value; 
      var muni_ddl = document.getElementById('muni_ddl').value; 

      if (brgyTxt==''){  
          Div.innerHTML = "Please enter Barangay name!"; 
          return false;
      } 

      if (muni_ddl=='0'){  
          Div.innerHTML = "Please select municipality!"; 
          return false;
      }  
      CallPage('GlobalExecCommand.php?mode='+mode+'&id='+id+'&brgy='+brgyTxt+'&muni='+muni_ddl,divId);
      return false;
  } 


  if (mode==2) /*Modify Category*/
  {
   //id,brgy,muni
      var CatTxt = document.getElementById('CatTxt').value;  

      if (CatTxt==''){  
          Div.innerHTML = "Please enter Category name!"; 
          return false;
      } 
 
      CallPage('GlobalExecCommand.php?mode='+mode+'&id='+id+'&cat='+CatTxt,divId);
      return false;
  } 



}

function CallPage(Page,DIV){ 
  var xhr = new XMLHttpRequest();
      xhr.open('GET', Page, true);
      xhr.onreadystatechange = function() {
          if (xhr.readyState == 4 && xhr.status == 200) {
              document.getElementById(DIV).innerHTML = xhr.responseText;   
          }
      };
      xhr.send();
}
//divContent
function CallPageInto(mode,id){
      var Page;
      if (mode=='0')/*EDIT MUNICIPALITY*/
      {
        Page = "addAdress.php?id="+id; 
      }

      if (mode=='1')/*EDIT BARANGAY*/
      {
        Page = "addBarangay.php?id="+id; 
      }

      if (mode=='2')/*EDIT CATEGORY*/
      {
        Page = "addCategory.php?id="+id; 
      }

      //addBarangay.php
      
      var xhr = new XMLHttpRequest();
      xhr.open('GET', Page, true);
      xhr.onreadystatechange = function() {
          if (xhr.readyState == 4 && xhr.status == 200) {
              document.getElementById('divContent').innerHTML = xhr.responseText; 
          }
      };
      xhr.send();
}
 
function OpenProfile(UserID){ 
      var xhr = new XMLHttpRequest();
            xhr.open('GET', '../pages/UserProfile.php?id='+UserID, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById('divContent').innerHTML = xhr.responseText; 
                    window.scrollTo(0, 0);
                }
            };
            xhr.send(); 
    }
</script>


</html>