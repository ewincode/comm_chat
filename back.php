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
                  <label id="lbl_ind">Enter your email:</label>
                  <br> 
                  <input type='text' class='form-control' id="email_box"/></div> 
              <div class='col-md-12'>
              <div id="idMsg"></div>
              <br>
              <center><button class='btn btn-info'  id="submit" onclick="return EmailVerification(0)">Next</button></center>
              </div>
            </div>
          </div> 
      </div>
</body>  

<script> 

    function EmailVerification(mode){
      
      document.getElementById('idMsg').innerHTML = "Please wait.....";
      var email_box = document.getElementById('email_box').value;
      
      var xhr = new XMLHttpRequest();
      xhr.open('GET', 'reg_exe.php?mode='+mode+'&email='+email_box, true);
      xhr.onreadystatechange = function() {
          if (xhr.readyState == 4 && xhr.status == 200) {
              document.getElementById('idMsg').innerHTML = xhr.responseText;  
          }
      };
      xhr.send();  
    }

</script>

</html>