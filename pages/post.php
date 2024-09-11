<html>
  <header></header>
  
<style>

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
  margin-bottom:5%;
  border:1px solid #E3E5E7;
  border-radius:3px;
  padding:10px;
  background-color: white;
}

.postStaff{ 
  margin-bottom:5%;
  padding:10px;
  box-shadow: 2px 2px 5px 5px red;
  background-color: wheat;
  border-radius:15px;
}

.post_img{
  /*width: 50%;*/
 /* max-width:50%;*/
  width: 100%;
  height: auto;
  border-radius:5px;
}
.about{
  color:green;
  margin:2px;
  font-weight: bold;
}
.comment{
   /*margin-left:3%;*/
   margin:2px;
  font-size:12px; 
  /*background:#f0eceb;*/
  padding:5px;
  border-radius:3px;
  border:1px solid #f1f1f1;
  /*display:none*/
}
.reply{
  /*margin-left:3%;*/
  margin-left:20px;
  font-size:12px; 
  /*background:#f0eceb;*/ 
  border-radius:3px;
  /*display:none*/
}

.subreply{
  display:none;
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
  <body>
    <div class="">
      <br>
      <?php
        //$UserID = 1;
        //echo $_GET['id'];
        include('../conn.php');  


        if (!empty($_GET['id'])){
            $id = $_GET['id']; 
           $datas = mysqli_query($conn,"SELECT t1.id,IFNULL(cCount,0)as cCount
                                      FROM post_tb t1
                                      LEFT JOIN user_tbl t2 on t1.UserID=t2.id
                                      LEFT JOIN category_tb t3 on t1.CategoryID=t3.id
                                      LEFT JOIN (
                                              SELECT COUNT(id) as cCount,post_id
                                              FROM comment_tbl  
                                              GROUP BY post_id
                                                )t4 on t1.id=t4.post_id
                                      WHERE IsDeleted=0 and t1.id='$id'
                                      ORDER BY t1.id DESC 
                                      ");

        }else{

           $datas = mysqli_query($conn,"SELECT t1.id,IFNULL(cCount,0)as cCount
                                      FROM post_tb t1
                                      LEFT JOIN user_tbl t2 on t1.UserID=t2.id
                                      LEFT JOIN category_tb t3 on t1.CategoryID=t3.id
                                      LEFT JOIN (
                                              SELECT COUNT(id) as cCount,post_id
                                              FROM comment_tbl  
                                              GROUP BY post_id
                                                )t4 on t1.id=t4.post_id
                                      LEFT JOIN (SELECT COUNT(DISTINCT user_id)as cView,post_id
                                                FROM postviews
                                                GROUP BY post_id)t5 on t1.id=t5.post_id

                                      WHERE IsDeleted=0 
                                      ORDER BY cView  DESC
                                      ");

        }
        
       
        $num=1;
        //$count = 0;
        foreach($datas as $data){   
               $_GET['cCount']  = $data['cCount'];
               $_GET['id'] = $data["id"]; 
               $_GET['mode']=0;
               include ('post_content.php');
               //echo "</div>";
               $num+=1;
        }   
      ?>  
  <div id='div_content'></div>

  <!-- The Modal -->
<div id="myModal" class="modal"> 
<!-- Modal content -->
<div class="modal-content">
  <!-- <span class="close">&times;</span> -->
  <span class="close"></span>
  <div id="999999999"></div>
</div> 
</div>

  </body> 

  <script>
    var AgrDisAgrChck;   

  var modal = document.getElementById("myModal"); 
  var btn = document.getElementById("myBtn"); 
  var span = document.getElementsByClassName("close")[0];

    function DeletePost(id,divID){
 
        if (confirm('Are you sure, you want to delete this post?')){  
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'ExecCommand.php?mode=2&id='+id, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById('div_content').innerHTML = xhr.responseText; 
                    location.reload(); 
                }
            };
            xhr.send(); 
        }else{
          return false;
        }
        
    }

    function OpenProfile(UserID){
      //divContatin 
             var xhr = new XMLHttpRequest();
            xhr.open('GET', 'UserProfile.php?id='+UserID, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById('divContatin').innerHTML = xhr.responseText; 
                    window.scrollTo(0, 0);
                }
            };
            xhr.send(); 
    }

    function PostComment(PostdivID,PostBox,PostID,ReplyID){ 
        var id =  (ReplyID==0) ? PostID : ReplyID;
        var div = document.getElementById(PostdivID);
        var msg = document.getElementById(PostBox).value;
        var mode = (PostID==0) ? 0 : 1;


        if (PostID!==0 &&  AgrDisAgrChck==undefined){
            alert('Please specify agree or disagree on this post!');
            return false;
        }

        
        if (msg==""){
            alert('Please enter your message');
            return;
        } 

        ExecComment('ExecCommand.php?mode=0&PostID='+PostID+'&ReplyID='+ReplyID+'&Msg='+msg+'&IsAgr='+AgrDisAgrChck,div,id,mode);  
        return false;
    }
 
    function ExecComment(php_page,divReply,id,mode) { 
            //var page =  (mode=="0") ? 'Reply.php' : 'post_content.php';  

            var page;
             
            if (mode=="0"){page='Reply.php?id='+id;}
            if (mode=="1"){page='post_content.php?id='+id+'&mode=1';}
            if (mode=="2"){page='Likes.php?id='+id+'&LiksDiv='+divReply;}

            if (mode=="2"){
              divReply = document.getElementById(divReply);
            } 

            var xhr = new XMLHttpRequest();
            xhr.open('GET', php_page, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById('div_content').innerHTML = xhr.responseText;
                    AgrDisAgrChck=undefined; 
                   RefreshComments(divReply,page); 
                }
            };
            xhr.send();
      } 
      function RefreshComments(divReply,php_page){   
          //divReply.innerHTML = "";
          var xhr = new XMLHttpRequest();
          xhr.open('GET', php_page, true);
          xhr.onreadystatechange = function() {
              if (xhr.readyState == 4 && xhr.status == 200) {
                divReply.innerHTML = xhr.responseText;
              }
          };
          xhr.send();
          return false;
    }
    function OpenReply(ThisId){ 
      //alert(ThisId);
      document.getElementById(ThisId).style.display="block";
      return false;
    }
    
    function AgrDisAgr(ThisID){

      var num = ThisID.match(/\d+/)[0];

      var disagr = document.getElementById('agr_'+num);
      var agr = document.getElementById('disagr_'+num); 
      disagr.checked =false;
      agr.checked =false; 
      let pattern = /disagr_/;

      document.getElementById(ThisID).checked=true; 
      AgrDisAgrChck = (pattern.test(ThisID)) ? 0 : 1; 
    } 
    function LikeDisLike(TopicNum,PostID,Like,DisLike,DivID){ 
    ExecComment('ExecCommand.php?mode=1&TopicNum='+TopicNum+'&PostID='+PostID+'&Like='+Like+'&DisLike='+DisLike,DivID,PostID,2);  
    }


    span.onclick = function() {
    modal.style.display = "none";
    }


    function OpenDetails(mode,id){

      /*mode   --999999999
      1 - POST DETAILS
      */
      var php_page;
      if (mode=="1"){php_page='post_content.php?id='+id+'&mode=1'}
 

      var xhr = new XMLHttpRequest();
          xhr.open('GET', php_page, true);
          xhr.onreadystatechange = function() {
              if (xhr.readyState == 4 && xhr.status == 200) { 
                document.getElementById('999999999').innerHTML = xhr.responseText;
              }
          };
          xhr.send(); 

      /*INSERT INTO VIEWS*/
     if (mode=="1"){ 
      ExecCMD('ExecCommand.php?mode=3&PostID='+id); 
    }

      modal.style.display = "block";

    }


    function ExecCMD(php_page) { 
            var xhr = new XMLHttpRequest();
            xhr.open('GET', php_page, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById('div_content').innerHTML = xhr.responseText; 
                }
            };
            xhr.send();
      }

 
    window.onclick = function(event) {
      if (event.target == modal) {
        modal.style.display = "none";
      }
    }

  </script>
</html>