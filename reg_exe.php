<?php


session_start();

require 'mailer\src\PHPMailer.php';
require 'mailer\src\SMTP.php';
require 'mailer\src\Exception.php';


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function SendEmailNow($content,$email,$RefNo,$new_otp){
 
    $mail = new PHPMailer(true);
    
    try {
          
          $mail->isSMTP();                                            // Send using SMTP
          $mail->Host       = 'smtp.gmail.com';                     // SMTP server
          $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
          $mail->Username   = 'onnix2559@gmail.com';                     // SMTP username
          $mail->Password   = 'jsdpxplkgfouqdco';                        // SMTP password
          $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
          $mail->Port       = 587;                                    // TCP port to connect to 
 
        //Recipients
        $mail->setFrom('gmail@server.org', 'CSF');
        
        $mail->addAddress($email, 'You Email');       
    
         
        $mail->isHTML(true);                                        // Set email format to HTML
        $mail->Subject =$content;
        $mail->Body    ="Hi user, please use this OTP to join us. reference#:".$RefNo." <h1>".$new_otp."</h1>";
    
        $mail->send();
        SaveRefNo($email,$RefNo,$new_otp);
        echo "We sent an OTP to you email using this reference number ".$RefNo.". please verify it now!<br>";
        echo "
            <br>Enter OTP here:<br>
            <input type='text' id='text_otp' class='form-control'>
            <br>
            <center>
            <button class='btn btn-success' onclick='return EmailVerification(2)'>Verify</button>
            </center>
             ";
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
    
}

//SaveRefNo(1232,23334,23455);
 
function SaveRefNo($email,$uDate,$new_otp){    
    include ('conn.php');
    $stmt = $conn->prepare("INSERT INTO otp_master (refno,email,OTP)VALUES (?,?,?)");
    $stmt->bind_param("sss", $email,$uDate,$new_otp); 
    if ($stmt->execute()) { 
    } else {
        echo "Error: " . $stmt->error;
    } 
    $stmt->close();
    $conn->close();  
}

$mode = $_GET['mode'];

//$email = $_GET['email'];

if ($mode==0){
   echo "
        Enter you Email:<br>
        <input type='text' id='text_email' class='form-control' value=''>
        <br>
        <center>
        <button class='btn btn-success' onclick='return EmailVerification(1)'>Get Code</button>
        </center>
        ";
        
}

if ($mode==1){  
    $new_otp = mt_rand(100000, 999999);
    $email = $_GET['email']; 
    $uDate = $_GET['uDate'];
    
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) 
    { 
        SendEmailNow("CSF Catbalogan System",$email,$uDate,$new_otp);
    } 
    else {
        echo "
        Sorry, '".$email."' is not valid emal. please try another one:<br>
        <input type='text' id='text_email' class='form-control'>
        <br>
        <center>
        <button class='btn btn-success' onclick='return EmailVerification(1)'>Get Code</button>
        </center>
        ";  
    }
 }
 

 if ($mode==2){  
    include ('conn.php');
    $otp = $_GET['otp'];  
    $num=0;
    $data1 = mysqli_query($conn,"SELECT COUNT(OTP)num FROM `otp_master` WHERE OTP='".$otp."'");

    foreach($data1 as $data){ 
        $num = $data['num']; 
        }  

    if ($num==0){
        echo "
        <br>Invalid/Wrong OTP:<br>
        <input type='text' id='text_otp' class='form-control'>
        <br>
        <center>
        <button class='btn btn-success' onclick='return EmailVerification(2)'>Verify</button>
        </center>
         ";
    }
    else{
       /*  $_SESSION['email'] = $_GET['email'];
        header("Location: register2.php");  */
        echo 99999;
    }
  }

?>