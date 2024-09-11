<!--<div class='post'> -->
<?php
include ('../conn.php');

if (session_status() == PHP_SESSION_NONE) { 
  session_start(); 
}
 
$id=$_GET['id'];
$mode=$_GET['mode'];
$PostdivID = "10001".$id.$mode;
$PostBox = "10002".$id.$mode; 
$LiksDiv = "10006".$id.$mode;  
$Agr = "agr_".$id.$mode;
$DisAgr = "disagr_".$id.$mode;

$profile_pic="";
$fullname="";
$DatePosted="";
$msg="";
$Category="";
$img=""; 
$IsUnkown="0"; 
$cCount = 0;

$datas = mysqli_query($conn,"SELECT t1.id,t2.profile_pic,t2.fname,t2.mname,t2.lname,t1.DatePosted,t1.OtherCat,
                                    t1.msg,t3.Category,t1.img,t1.IsUnkown,t2.id as UserID,t1.CategoryID,cCount,Isstaff 
                            FROM post_tb t1
                            LEFT JOIN user_tbl t2 on t1.UserID=t2.id
                            LEFT JOIN category_tb t3 on t1.CategoryID=t3.id
                            LEFT JOIN
                                ( 
                                  SELECT COUNT(id)as cCount,post_id
                                  FROM(
                                          SELECT id,post_id FROM comment_tbl WHERE post_id<>0
                                          UNION ALL

                                          SELECT t1.id,t2.post_id
                                          FROM(
                                              SELECT id,reply_id FROM comment_tbl WHERE reply_id<>0
                                              )t1
                                          LEFT JOIN (SELECT id,post_id FROM comment_tbl WHERE reply_id=0)t2 on t1.reply_id=t2.id
                                          WHERE t2.id is NOT NULL
                                          UNION ALL

                                          SELECT t2.id,(SELECT post_id FROM comment_tbl WHERE id=t2.reply_id) as post_id
                                          FROM (SELECT reply_id  FROM comment_tbl WHERE reply_id<>0)t1
                                          LEFT JOIN comment_tbl t2 on t1.reply_id=t2.id 
                                          WHERE t2.post_id=0
                                      )t1
                                    GROUP BY post_id
                                )t4 on t1.id=t4.post_id
                            WHERE t1.id=$id AND IsDeleted=0");
        
foreach($datas as $data){ 
if ($data['Isstaff'] ==1 ) {
 // echo "staff";
  echo"<div class='postStaff'>";
} else {
  echo"<div class='post'>";
}
  $profile_pic = $data['profile_pic'];
  $fullname = $data['fname']." ".$data['mname'].". ".$data['lname'];
  $DatePosted = $data['DatePosted'];
  $msg = $data['msg'];
  $Category = $data['Category'];
  $img = $data['img'];
  $IsUnkown = $data['IsUnkown'];
  $UserID = ($IsUnkown==1) ? 0 : $data['UserID'];
  $cCount = $data['cCount'];
   $Isstaff = $data['Isstaff'];
  

  if($data['CategoryID']==0){
    $Category = $data['OtherCat'];
  }


  if ($IsUnkown==1){
    $fullname = "Anonymous@".$id;
    $profile_pic = " data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAJcAAACUCAMAAACp1UvlAAAAZlBMVEX///8AAAD7+/v4+Pjt7e3y8vLg4ODNzc3o6Oi+vr7W1tabm5v19fW4uLjl5eXGxsZQUFCQkJBKSkobGxsODg4nJydmZmYsLCyAgIBVVVVxcXGIiIirq6tEREQXFxdhYWEzMzM6OjonTYOqAAAHCElEQVR4nO1c2bKjIBCNGy64x30j/v9PDi7JNQoCicFMVc7LrcGJHqFpTjeNl8sPP/zw/8PwLZV4wfV9TTKXBUCoJAUgXDAzRSnIjGUAKRi9uWmH6XABnsBohK2MSIPnZrWe2nP/HFqXdnq+0j8NpVbMzWd1WJDcCYRLG8/urUqpn8Lr0S+Kkj0YWOivVdlangSAdsEAOVOjvWxUojN4BUsGSg/BRQuK5KkxP4HWfdY90KXXZNWkWPJ5ufmaBAEnDKTPQUsp5fOCPLxy+Z4i5uGVeNJ5XXl4yTewgM1pQCVb7UR8vHqSCvokCjanEZKXIqvk5NXI5WWmnLwyuarV5qSlXOUaPpdXHSHVs7qITWiGVAMzeM0LezCZvHRuWkorkxentx+QGhJ5rTXhDrqAfbvDwOtVB8iM1vjExIRaHi0Bs8ceX56BCZi9VEnB7+0HyDN8XpEzQZ6WroR4SdPSVijEK5QlKZybEK/ElcRLaDoq8qQOqMs23+QiKEjjSqIEcx0PRlXIyFHcsqgx5eelXQs4pg0L1Kar3ktuZdGYDjgnYbiCqo84MW//ww8/fAc0EIgLPfybjy6SoKmrXmlrMalnF63SZnXjfICRqllNlt/jjSRHnq6xUzWqpjfosZRecwQBx6+4YTletV0Krwjaw1pDcvCaDpzAjtA2cOqyxjxE8VtNXdLTEWmLqjqKYON5dhAEtuc1MIrqCq+Z1N8kcfHmmKoWjDlTJEmSdF2X8Mqfa184L66kutOICVNh1C9MbQci3nd/A31kC82DYMekjkXXQ97xNLxeEqkZkGuH3snYdzoYrc2mZfJsLB4OZhrW6M+gpSis9dNo2ff4AHqm8QeyZuISOcc+klWJpAOPwLXgy90FYomkd1nxyyYNQFl9lkNfTPmAGn14eVR6FL0UkTtNJJbqEkCCoPeGDtNBUBw/QXusJI7IXYAhOcKdWqKju4VY5x9br2aZWIoyU0s0DBke2NjOh5L5rgWAY8OKV8Vi5GEFAwf4hyd6DModXRB4MCqqDKGyDOO4xYjjMCxLhLKqiBovABQX4OrW26VOAOER8Gxz/0aq6w7JL8NlxGGWEwzmEKep917ANpfFJdhiqygY76WLxs7aNPesqELx7eGwq3dsbZV7HsMrqPSF51u4c1iv7Bq6ZUbtvNcH1kb5ctGH2qzuNGzaqXMNzK2s6iFuXMMegP82zSMzPPHyN+vHa+7+cqk3LmtoFdu2GjCpUbBd1+JX4luNIPSHN/fID7+2cduRL03ynajsoHCiB5CKJFqdVgRTDdZiE2OWdDKktVFMQIJdBsiCGg+JRiI8V3oRKz6y6Rpl/G9CpR8BRYDFFnGDKL1PTXV7LZm6S6WqTcRv/pC6SA9vt6lKW1Qj2JtfzhUBPr0kMQ04nexOOVyHb6GuhiRZDsXajO6FCg79nkrHdYrA2NX3Y+GBEy6mXvtsusv9ya58XCOb/R03tpMlTsQ/pNOTzKhq805J+mJjt2pT9YmSpDFeuf5aWYFpxFiXHFZpajHrCw04pmkSNYMK8BUHLISIyq6UzHY9RsBWfi9UHvg8yZhrQ7eyfSuYkAv7aN5kTEnT2E6WIdpq8gfR0gOPKxrts4gaIqmaprmG4cCq35bTP3AVG0nWQt+lIRZOWFNy3c0NcJhBeVGRIyW7XueGCmiLa2rf9Api1M1fPaVTq1OuFQ6QXg4jVQPAcDukvCOpk71OFzfAeD9C0uwaPaublK/zfcJETFHNux5ywDC9bNltXGED2PZW2JhHB7euHiyocRQOWhvbrMBnIm5z8SRmcttazeYWfqqm76le+8pQwP4qSZV/rHKueZ6X4W5mxl1Xk3Yt95aLELSNJyp3xkUjpvT4tlyEYBEcZEH935tzYvfBjA4+WkGu3qNOSrouSYsj+wxQnkKRFvsHGsrDyhZsaiKO2GM+SypV3iFToNl5DiEsVZmVpN2+aOaDu/+Y7VDuavkbqg8yfRDtxzLrodwp2Mxr78iyE8vZPQqw6jHqPklpC2668MDO6Enop1pQij6NWQHiyzAhNbRcBDLkNFTWfLKiyfJoYxTezcYlRYrx4ZprA7OkxCKzvyBkE0s5p/qCguzNpizuhnUr7ciVSpmdtUZYFyOph7iNmhBQwG3408o+MHrxYb+i1dnr7krEs80HAKySnbhvjKfUWXrKBxUwtGg5mhWerEtaMgvv17AWownnL578/fNM/I0mNvEFLcknfgkwotFnJUurTzkqpz4PEN1G83osQadZ/BpOgcNv/y7TPhfBigNoF2+2tPUXdc7GPV/5ZbTuYcD5M/EZs3md8nWaPYDRvKrzvmNFwbhhlnzFWaYnBF9o8wOabzSuy+gm4u8bxTH6/8JRHPorO5sCEY0iXcxzwZZ45F4Exnd21w8//Ff4B+qnYdqZ/+eEAAAAAElFTkSuQmCC";
  }
}   

 
echo "<div id='".$PostdivID."' class='OnOff'>"; 
echo "<table>
      <tr> 
      <td><img class='prof_pic' src='".$profile_pic."'/></td>
      <td>
      <b class='UserName' onclick='return OpenProfile(".$UserID.",$PostdivID)'>".$fullname."</b>";
    
if ($_SESSION['UserID']==$data['UserID']){
    echo "&nbsp;&nbsp;&nbsp;<button onclick='return DeletePost(".$data['id'].")'>Delete</button>";
}

echo"<br>
          <div class='pDate'>".$DatePosted."</div>
          </td> 
      </tr>  
      </table>";

echo "<div onclick='return OpenDetails(1,".$id.")'>
      <div class='about'>ABOUT - ".$Category."</div>";
$msg_length = strlen($msg); 
if ($mode==0){
  echo "<div>".substr($msg, 0, 200).($msg_length>200 ? ".... <l style='color:blue'>more details</l>" : "")."</div>";
}else{
  echo "<div>".$msg."</div>";
}
echo "<div><img class='post_img' src='".$img."'/></div>"; 
echo "</div><div id='".$LiksDiv."'>";  
$_GET['LiksDiv']=$LiksDiv;
include ('likes.php');
echo "</div></div>"; 

if ($mode==1){
          echo   "<div style='display:inline-block'>
            <input type='checkbox' id='".$Agr."' onclick='return AgrDisAgr(this.id)' />
            <label for='".$Agr."'>Agree</label>
          </div>
          &nbsp;&nbsp;
          <div style='display:inline-block'>
            <input type='checkbox' id='".$DisAgr."'  onclick='return AgrDisAgr(this.id)'/>
            <label for='".$DisAgr."'>Disagree</label>
          </div>

          <table style='width:100%'  class='comm_tbl'>
          <tr>
            <td style='width:93%'> 
            <textarea id='".$PostBox."' class='form-control' style='height:50px' placeholder='Share a comment' ></textarea>
            </td>
            <td><button class='btn btn-info' onclick='return PostComment(999999999,".$PostBox.",".$id.",0)'>Send</button></td>
          </tr>
          </table>  
          ";  

          $datas = mysqli_query($conn,"SELECT t1.id
                                      ,t2.fname
                                      ,t2.profile_pic
                                      ,t2.mname
                                      ,t1.DatePosted
                                      ,t1.msg
                              FROM comment_tbl t1 
                              LEFT JOIN user_tbl t2 on t1.userID=t2.id 
                              WHERE post_id=$id and reply_id=0;");
          $num=0;
          foreach($datas as $data){ 
          $_GET['id'] =  $data['id'];
          include('Reply.php');  
          $num+=1;
          } 

}

/* 
 
echo   "<div style='display:inline-block'>
          <input type='checkbox' id='".$Agr."' onclick='return AgrDisAgr(this.id)' />
          <label for='".$Agr."'>Agree</label>
      </div>
      &nbsp;&nbsp;
      <div style='display:inline-block'>
          <input type='checkbox' id='".$DisAgr."'  onclick='return AgrDisAgr(this.id)'/>
          <label for='".$DisAgr."'>Disagree</label>
      </div>

      <table style='width:100%'  class='comm_tbl'>
        <tr>
          <td style='width:93%'> 
          <textarea id='".$PostBox."' class='form-control' style='height:50px' placeholder='Share a comment' ></textarea>
           </td>
          <td><button class='btn btn-info' onclick='return PostComment(".$PostdivID .",".$PostBox.",".$id.",0)'>Send</button></td>
        </tr>
      </table>  
      ";  

      $datas = mysqli_query($conn,"SELECT t1.id
                                    ,t2.fname
                                    ,t2.profile_pic
                                    ,t2.mname
                                    ,t1.DatePosted
                                    ,t1.msg
                            FROM comment_tbl t1 
                            LEFT JOIN user_tbl t2 on t1.userID=t2.id 
                            WHERE post_id=$id and reply_id=0;");
      $num=0;
      foreach($datas as $data){ 
        $_GET['id'] =  $data['id'];
        include('Reply.php');  
        $num+=1;
      } 
  */ 
?> 
</div>