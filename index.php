<?php

include ('conn.php');
 
if(isset($_POST['reg'])){
  header("Location : register.php");
  exit;
}
 
if (isset($_POST['submit'])) { 
    $user = $_POST['uname'];
    $pass = $_POST['upass'];
 
    $stmt = $conn->prepare("SELECT  fname,profile_pic,Status,isAdmin,id,upass 
                            FROM user_tbl WHERE uname = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Bind result variables
        $stmt->bind_result($fname,$profile_pic,$Status,$isAdmin,$userID,$hashed_password);
        $stmt->fetch();
 
        if (password_verify($pass, $hashed_password)) {  
            session_start(); 
            
            $_SESSION["IsLogin"]="1";  
            $_SESSION["pass"]=$_POST['upass'];
            $_SESSION["UserID"]=$userID;
            $_SESSION["sys_color"]="#709EBD";  
            $_SESSION["profile_pic"]=$profile_pic;
            $_SESSION["fname"]=$fname;
            $_SESSION["num"]=0;

            if ($Status==1){
              echo "Sorry, this access is already INACTIVATED!"; 
              return;
            }

            if ($isAdmin==1){
              header("Location: admin"); 
              return;
            }

            header("Location: pages"); 
            
        } else {
            echo "Invalid password!";
        }
    } else {
        echo "No user found with that username!";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>

<html>
  <head>
  <?php  include('web_thems.php'); ?> 
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>
  <style>
    body,html{
      background-image: url('bg/log_bg.jpeg'); 
      background-size: cover; /* You can also use contain or specific dimensions */ 
      background-repeat: no-repeat; /* This ensures the image is not repeated */ 
      background-position: center center; 
      margin: 0;
      padding: 0; 
      height: 100vh;
    }
    .ThisDiv{ 
      background:#cdefef;
    }

    .centered-div {
    width: 500px; /* Adjust width as needed */
    margin: 0 auto; /* This centers the div horizontally */ 
    /*background-color: lightblue;*/
    padding: 20px;
  }

  .inner{
    padding:20px;
    background-color:white;
    width: auto;
    border-radius:15px;
    margin-top:50px;
  }

  .bannerTxt {
    color:white;
    font-size: 36px;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); 
  }
  .text{
  margin-left: 190px;
  font-size: 25px;
  color: #F4B30E;
  font-family:bold;
}
.btn{
  background-color: #F4B30E
}
  </style>
  <body></body>
  <form method="POST">
    <div class='LoginDiv'> 
       <center><h1 class='bannerTxt'>Catbalogan Community Suggestions And Feedback</h1></center>
            <div class='centered-div'>
           
              <div class="inner">
                <div class='row'>
                  <div class='text'>LOGIN</div>
                  <div class='col-md-12'>
                    Username:<br>
                    <input type='text' class='form-control' name="uname"/>
                  </div>
                  <div class='col-md-12'>
                    <br>
                    Password:<br>
                    <input type='password' class='form-control'  name="upass" />
                  </div>
                  <div class='col-md-12'>
                    <br>
                    <table style='width:100%'>
                      <tr>
                        <td><button class='btn btn-info' name="submit">Login now</button></td>
                        <td>
                          <!--<button style='float: right' name="reg" class='btn btn-success'>Join to us?</button>-->
                          <a href="register.php" style='float: right' class='btn btn-success'>Register now</a>
                        </td>
                      </tr>
                    </table>
                  </div>
                </div>
              </div>
            </div>  
    </div>
  </form>
</html>