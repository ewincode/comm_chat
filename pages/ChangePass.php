<h4>Change Password</h4>
<br><br>
<div class='row'>
  <div class='col-md-4'>
    Curren Password:<br>
    <input type='password' name='cPassword' id='cPassword' class='form-control'/>
  </div> 
</div>

<div class='row'>
  <div class='col-md-4'>
    New Password:<br>
    <input type='password' name='nPassword' id='nPassword' class='form-control'/>
  </div> 
</div>

<div class='row'>
  <div class='col-md-4'>
    Re-type New Password:<br>
    <input type='password' name='RnPassword' id='RnPassword' class='form-control'/>
    <br><br>
    <button class='btn btn-danger' name='btnPass' onclick='return ChangePassword()'>Change Now</button>
  </div> 
</div>

<script>
  function ChangePassword(){
      //cPassword,nPassword,RnPassword
      var cPassword = document.getElementById('cPassword').value;
      var nPassword = document.getElementById('nPassword').value;
      var RnPassword = document.getElementById('RnPassword').value;

      if (cPassword==""){
        alert('Please enter current password');
        return false;
      }

      if (nPassword==""){
        alert('Please enter new password');
        return false;
      }

      if (RnPassword==""){
        alert('Please Retype new password');
        return false;
      }


      if (RnPassword!==nPassword){
        alert('New passwords does not matched');
        return false;
      } 

  }
</script>