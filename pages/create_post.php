<!DOCTYPE html>
<html>
  <head>
  <meta charset="UTF-8">
  <title>Create Post</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
  </head>
  <style>

.msg{
      width:100%;
      height: 400px;
    }
    .profile_pic{
      max-width:400px;
      height: 100%;
    }
    .container{
      width:100%;
      height: 100%;
      background: white;
      border-radius: 10px;
    }
.btn-info{
  margin-bottom: 50px;
  width: 90px;
}
.image{
  margin-bottom: 10px;
  width: 100%;
    
} 
    .container{
      width:100%;
      height: 100%;
      background: white;
      border-radius: 10px;
    }
/* CSS for styling image upload section */

/* Style for the icon */
#imageInputLabel {
  cursor: pointer; /* Change cursor to pointer when hovering over the icon */
}

#imageInputLabel i {
  font-size: 40px; /* Adjust icon size */
  color: #333; /* Set icon color */
}

/* Optional hover effect for the icon */
#imageInputLabel:hover i {
  color:#F4B30E; /* Change icon color on hover */
}

/* Adjust spacing and alignment */
#imageInputLabel,
#imageInput {
  margin-top: 5px; /* Add some top margin for spacing */
}

#imageInput {
  display: none; /* Hide the file input */
}
/* CSS for styling the post button, anonymous checkbox, and icon */
.post-btn {
  display: flex; /* Use flexbox for easier alignment */
  align-items: center; /* Align items vertically */
  margin-bottom: 20px; /* Add bottom margin for spacing */
}

.post-btn button {
  margin-right: 10px; /* Add some right margin for spacing between the button and other elements */
}

.post-btn i {
  margin-right: 5px; /* Add some right margin for spacing between the icon and checkbox */
  font-size: 30px; /* Adjust icon size */
  color: #333; /* Set icon color */
  margin-bottom:50px;
  margin-left: 50px
  
}

.post-btn input[type="checkbox"] {
  margin-right:px; /* Add some right margin for spacing between the checkbox and label */
  vertical-align: middle; /* Align the checkbox vertically with the label */
  margin-bottom:50px;
}

.post-btn label {
  font-size: 16px; /* Adjust label font size */
  color: #333; /* Set label color */
  vertical-align: middle; /* Align the label vertically with the checkbox */
  margin-bottom:50px;
  margin-left:5px;
}
  </style>
  <body>
<div class="container">
  <br>
<h5> <i class="fa-solid fa-mailbox"></i>+ INPUT YOUR SUGGESTIONS HERE</h5>
<br>
  <input type="hidden" name="img" id="img"/>
  <div class="">
    <div class="">
      Choose Category:
      <select class="form-control" name="category" id="category" onchange='return SelectCat(this.id)'>
      <?php 

        $datas = mysqli_query($conn,"SELECT id,Category FROM category_tb WHERE status=0
                                      UNION ALL
                                      SELECT 0,'OTHERS'");
        foreach($datas as $data){  
          echo "<option value='".$data["id"]."'>".$data["Category"]."</option>";
        }

      ?>
      </select> 
      <div id="OthersDIV"></div> 
    </div>

    <div class="">
      <br>
      <i class="fa-regular fa-pen-to-square"></i>DESSCRIBE YOUR SUGGESTIONS<br>
      <textarea class="form-control" style="height:200px" name="message" id="message" placeholder="Type your ideas here...."></textarea>
    </div>
 <div>
        Picture:<br>
        <label for="imageInput" id="imageInputLabel">
          <i class="fa-regular fa-images"></i>
        </label>
        <input type="file" id="imageInput" class="form-control" accept="image/*" style="display:none;">
      </div>
    <div class="">
      <br>  
      <center>
        <img id="imageDisplay" class="profile_pic">
        <br>
        <label class="btn btn-danger" id="RemoveBtn" style="display:none" onclick="removeImg()">Remove Image</label>
      </center>
    </div>
     <div class="post-btn">
      <button class="btn btn-info" name="submit_post" onclick="return SubmitPost()">Post</button>

      <i class="fa-solid fa-user-secret"></i>
      <input type="checkbox" name="UnkwonPost" id="UnkwonPost">  
      <label for="UnkwonPost">Post as anonymous?</label>
    </div>

    
</div>
  </body> 
  <script>

var rBtn = document.getElementById('RemoveBtn');

document.getElementById('imageInput').addEventListener('change', function(event) {
      
    const file = event.target.files[0];
    const reader = new FileReader(); 
    
    reader.onloadend = function() {
        const base64String = reader.result; 
        document.getElementById('imageDisplay').src = base64String;
        document.getElementById('img').value = base64String;
        rBtn.style.display = "block";
    };
    
    if (file) {
        reader.readAsDataURL(file);
    } 
});  

function removeImg(){
  document.getElementById('imageDisplay').src = "";
  document.getElementById('img').value = "";
  rBtn.style.display = "none";
}

function SubmitPost(){

  //var category,message
  var category = document.getElementById('category').value;
  var message = document.getElementById('message').value;

  if (category==0){
    var Others = document.getElementById('OthersTxt').value;
    if (Others==""){
      alert('Please specify others');
      return false;
    }
  }

  if (category==""){
    alert('Please select [CATEGORY]');
    return false;
  }

  if (message==""){
    alert('Please leave your [MESSAGE]');
    return false;
  } 
  
  if (confirm('Are you sure, you want to POST this?')){ 

  }else{
    return false;
  }
  
}

</script>

</html>