
<!--<div class='reply'>-->
<?php   
include ('../conn.php');
 
//$IsAdmin

$id=$_GET['id'];
$profile_pic = "";
$fullname = "";
$DatePosted  = "";
$msg  = "";
$UserID="";
$subreply="10003".$id;
$msgBox="10004".$id;
$PostdivID="10005".$id;

$datas = mysqli_query($conn,"SELECT t1.id,
                                    t1.msg,
                                    t1.DatePosted,
                                    CONCAT(t2.fname, ' ', t2.mname, ' ', t2.lname) as fullname,
                                    t2.profile_pic,
                                    t2.id as UserID,IsUnkown,IsAgree,post_id,t1.reply_id
                              FROM comment_tbl t1
                              LEFT JOIN user_tbl t2 ON t1.userID = t2.id
                              LEFT JOIN post_tb t3 on t1.post_id=t3.id
                              WHERE t1.id = $id;");
        
foreach($datas as $data){ 
  $profile_pic = $data['profile_pic'];
  $fullname = $data['fullname'];
  $DatePosted = $data['DatePosted'];
  $reply_id = $data['reply_id'];
  $msg = $data['msg'];  
  //$UserID = $data['UserID'];  
  $UserID = ($data['IsUnkown']==1) ? 0 : $data['UserID'];
  $IsAgree = ($data['post_id']=="0") ? "" : (($data['IsAgree']=="1") ? " <b style='color:green'>- Agree</b>" : " <b style='color:red'>- Disagree</b>");
} 
$class = ($reply_id==0 ? "comment" : "reply"); 
echo "<div class='".$class."' id='".$PostdivID."'>";
echo "<table>
      <tr> 
      <td><img class='prof_pic_r' src='".$profile_pic."'/></td>
      <td>
          <b class='UserName' onclick='return OpenProfile(".$UserID.")'>".$fullname."</b>  ".$IsAgree." 
          <div class='pDate'>".$DatePosted."</div>
      </td> 
      </tr>  
      </table>"; 

  echo "<div style='margin-left:30px'>".$msg." ";
  if (!isset($_GET['IsAdmin'])){ 
  echo "<br> <a href='#' onclick='return OpenReply($subreply)'>Reply</a>
  </div> 
  <div class='subreply' id='".$subreply."'>
  <table style='width:100%'>
           <tr> 
             <td  style='width:90%'>
               <textarea class='form-control' style='height:50px' placeholder='Enter you reply here' id='".$msgBox."' name='".$msgBox."'></textarea></td>
             <td style='width:10%'>
               <label class='btn btn-primary' onclick='return PostComment(".$PostdivID .",".$msgBox.",0,".$id.")'>Send</label>
             </td>
           </tr>
   </table>
   </div>
  "; 
  }

/*
 if (!isset($_GET['IsAdmin'])){ 
  echo "<div style='margin-left:30px'>".$msg." 
  <br> <a href='#' onclick='return OpenReply($subreply)'>Reply</a>
  </div> 
  <div class='subreply' id='".$subreply."'>
  <table style='width:100%'>
           <tr> 
             <td  style='width:90%'>
               <textarea class='form-control' style='height:50px' placeholder='Enter you reply here' id='".$msgBox."' name='".$msgBox."'></textarea></td>
             <td style='width:10%'>
               <label class='btn btn-primary' onclick='return PostComment(".$PostdivID .",".$msgBox.",0,".$id.")'>Send</label>
             </td>
           </tr>
   </table>
   </div>
  "; 
 }
*/

 
   $datas = mysqli_query($conn,"SELECT  t1.id
                                        ,t2.fname
                                        ,t2.profile_pic
                                        ,t2.mname
                                        ,t1.DatePosted
                                        ,t1.msg
                                FROM comment_tbl t1 
                                LEFT JOIN user_tbl t2 on t1.userID=t2.id 
                                WHERE  reply_id=$id;");

   foreach($datas as $data){   
      $_GET['id']= $data["id"];
      include('Reply.php'); 
   } 
 echo "</div>";
  ?>
<!--</div>-->