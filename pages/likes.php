<?php
include ('../conn.php');

$id = $_GET['id'];
$LiksDiv = $_GET['LiksDiv'];

$Likes = 0;
$DisLikes = 0;

$datas = mysqli_query($conn,"SELECT SUM(IsLike)as LikeNum,
                                    SUM(IsDisLike)as DisLikeNum
                              FROM likes_tb
                              WHERE topic_id=$id");
        
foreach($datas as $data){ 
  $Likes = $data['LikeNum'];
  $DisLikes = $data['DisLikeNum'];
} 

 
$data2 = mysqli_query($conn,"SELECT IFNULL(SUM(CASE WHEN IsAgree=1 THEN 1 ELSE 0 END),0) as Agree 
                                    ,IFNULL(SUM(CASE WHEN IsAgree=0 THEN 1 ELSE 0 END),0) as DisAgree 
                             FROM comment_tbl 
                             WHERE post_id<>0 and post_id=$id");

foreach($data2 as $data){ 
  $Agree = $data['Agree'];
  $DisAgree = $data['DisAgree'];
}  


$data3 = mysqli_query($conn,"SELECT COUNT(DISTINCT user_id)as cView FROM postviews WHERE post_id=$id");
foreach($data3 as $data){ 
  $cView = $data['cView']; 
}  

echo "<hr>
<i class='fa fa-thumbs-up fa-1x like' onclick='return LikeDisLike(0,".$id.",1,0,".$LiksDiv.")'> ".$Likes ."</i>
&nbsp;
<i class='fa fa-thumbs-down fa-1x like' onclick='return LikeDisLike(0,".$id.",0,1,".$LiksDiv.")'> ".$DisLikes."</i>
&nbsp;";
echo "Agree[".$Agree."]  - DisAgree[".$DisAgree."]&nbsp;";
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$cView." View(s)";

?>