<?php


 

$unique_date = date('Y').date('m').date('d').date('H').date('m').date('s');
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
  font-size: 25px;
  color: #F4B30E;
  font-family:bold;
}
.btn{
  background-color: #F4B30E
}
  </style>
  <body>
      <div class='LoginDiv'> 
          <center><h1 class='bannerTxt'>Catbalogan Community Suggestions And Feedback</h1></center>
          <div class='centered-div'> 
            <div class="inner">
              <div class='row'>
              <!-- <div class='text'> <center>Email Verification</center> </div> -->
              <div class='col-md-12'> 
                  <div id="div_result"></div>
              <div class='col-md-12'>
               
            </div>
          </div> 
      </div>
</body>  

<script> 

    var this_email;

    function EmailVerification(mode){

      var unique_date = <?php echo $unique_date; ?>;
 
      var ThisPage;

      if(mode==0) {ThisPage="reg_exe.php?mode=0"};
      
      if(mode==1) { 
        var  email = document.getElementById('text_email').value;
        this.this_email = email;
        if(email==""){ 
          alert('Please enter your email');
          return false;
        }
        document.getElementById('div_result').innerHTML="Please wait....";
        ThisPage="reg_exe.php?mode=1&email="+email+"&uDate="+unique_date;
      };


      if(mode==2) { 
        var  otp = document.getElementById('text_otp').value;
        if(otp==""){ 
          alert('Please enter your OTP');
          return false;
        }
        document.getElementById('div_result').innerHTML="Please wait....";
        ThisPage="reg_exe.php?mode=2&otp="+otp+"&email="+this_email;
      };


      

      var xhr = new XMLHttpRequest();
      xhr.open('GET',ThisPage, true);
      xhr.onreadystatechange = function() {
          if (xhr.readyState == 4 && xhr.status == 200) {
            if (xhr.responseText=="99999"){
              window.location.href = "register2.php?email="+this_email;
            }else{
              document.getElementById('div_result').innerHTML = xhr.responseText;  
            }
              
          }
      };
      xhr.send();  
    }

    EmailVerification(0);

</script>

</html>