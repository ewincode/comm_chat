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
  background-color: DodgerBlue;
  border: none;
  color: white;
  padding: 12px 16px;
  font-size: 16px;
  cursor: pointer;
}

.BtnMenu{

}
.comm_tbl{
  /*background:red;*/
  padding:20px;
}
 
.like{
  color:#48a4ca;
  cursor:pointer: 
}

.like:hover{
  color:gray; 
}

.ProfilePic{
  border-radius:50%;
  width: 50px;
  height: 50px;
}
  </style>
</head>
<body>
  <header class="fixed-top bg-info text-white text-center p-3">
    
    <div class="d_inline" style="float:left">
      <!--<img class='ProfilePic' src='<?php echo $_SESSION['profile_pic']; ?>'/>-->
      <!--<label>Hi, <?php echo $_SESSION['fname'];?></label>-->
     </div> 
   
    
   
    <div class="d_inline"> 
    <h5>WOW Community Chatbox</h5>
    </div>

    <div class="d_inline" style="float:right">
        <button class="navbar-toggler d-md-none" type="button" data-toggle="collapse" data-target="#sidebar"    aria-controls="sidebar" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon">&#9776;</span>
        </button>
     </div> 

</header>
<form method="post">
  <div class="container-fluid">
    <div class="row">
      <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
        <div class="position-sticky">

          <ul class="nav flex-column">
             
           <!-- <li class="nav-item">
              <a class="nav-link" href="#"> 
                + Create post
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">
                My Profile
              </a>
            </li> --> 
            <li class="nav-item">
             <!--<button name="post_button">+ POST</button> -->
             <br>
             <div class='BtnMenu'><button class="btn"><i class="fa fa-home"></i></button> Home</div>
             <br>
             <div class='BtnMenu'><button name="post_button" class="btn"><i class="fa fa-plus-square-o"></i></button> Create Post</div>
             <br>
             <div class='BtnMenu'><button class="btn"><i class="fa fa-cog"></i></button> Settings</div>
             <br>
             <div class='BtnMenu'><button name="out_button" class="btn"><i class="fa fa-sign-out"></i></button> Logout</div>
            </li>


          </ul>
        </div>
      </nav>
      <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4"> 
          <?php
          
            if(isset($_POST['post_button'])){
              include ('create_post.php'); 
            }

            else if(isset($_POST['out_button'])){   
              header("Location: logout.php"); 
            }

            else if(isset($_POST['submit_post'])){ 

              $category = $_POST['category'];
              $msg = $_POST['message'];
              $img = $_POST['img'];
              $UnkwonPost = 0; 
              $UserID=$_SESSION["UserID"];

              if (!empty($_POST['UnkwonPost'])){
                $UnkwonPost = 1;
              }
              
              $stmt = $conn->prepare("INSERT INTO post_tb (UserID,IsUnkown,CategoryID,msg,img)VALUES (?,?,?,?,?)");
              $stmt->bind_param("sssss", $UserID,$UnkwonPost,$category,$msg,$img);
      
                // Execute the statement
                if ($stmt->execute()) {
                  include ('post.php');  
                } else {
                    echo "Error: " . $stmt->error;
                }
      
                // Close the statement and connection
                $stmt->close();
                $conn->close();

              
              
            }
            else{
              include ('post.php'); 
            }
          ?> 
        </div>
      </main>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  </form>
</body>
</html>