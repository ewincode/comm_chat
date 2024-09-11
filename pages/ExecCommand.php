<?php

include ('../conn.php');
session_start();

 
$mode = $_GET['mode'];

if ($mode==0) /*SEND COMMENT*/
{

    $PostID = $_GET['PostID'];
    $UserID = $_SESSION['UserID'];
    $ReplyID = $_GET['ReplyID'];
    $Msg = $_GET['Msg'];
    $IsAgr = $_GET['IsAgr'];

    $stmt = $conn->prepare("INSERT INTO comment_tbl (post_id,userID,reply_id,msg,IsAgree)VALUES (?,?,?,?,?)");
    $stmt->bind_param("sssss", $PostID,$UserID,$ReplyID,$Msg,$IsAgr); 
    if ($stmt->execute()) { 
    } else {
        echo "Error: " . $stmt->error;
    } 
    $stmt->close();
    $conn->close();
    return;
  
}

 
 if ($mode==1) /*SEND LIKE*/
 {
    $TopicNum = $_GET['TopicNum'];
    $PostID = $_GET['PostID'];
    $Like = $_GET['Like'];
    $DisLike = $_GET['DisLike'];
    $UserID = $_SESSION['UserID'];

    if ($Like==1)
    {
          $datas = mysqli_query($conn,"SELECT   1 as num 
                                       FROM likes_tb 
                                       WHERE topic_num=$TopicNum and  	topic_id=$PostID and UserID=$UserID and IsLike=1 LIMIT 1"); 
          foreach($datas as $data)
          {
              $stmt = $conn->prepare("DELETE FROM likes_tb WHERE topic_num=$TopicNum and  	topic_id=$PostID and UserID=$UserID and IsLike=1 "); 
              if ($stmt->execute()) { 
              } else {
                  echo "Error: " . $stmt->error;
              } 
              $stmt->close();
              $conn->close();
              return;
          }  
    } 

    if ($DisLike==1)
    {
          $datas = mysqli_query($conn,"SELECT   1 as num 
                                       FROM likes_tb WHERE topic_num=$TopicNum and  	topic_id=$PostID and  UserID=$UserID and IsDisLike=1 LIMIT 1"); 
          foreach($datas as $data)
          {
              $stmt = $conn->prepare("DELETE FROM likes_tb WHERE topic_num=$TopicNum and  	topic_id=$PostID and  UserID=$UserID and IsDisLike=1"); 
              if ($stmt->execute()) { 
              } else {
                  echo "Error: " . $stmt->error;
              } 
              $stmt->close();
              $conn->close();
              return;
          }  
    }

   
    $stmt = $conn->prepare("INSERT INTO likes_tb (UserID,topic_num,topic_id,IsLike,IsDisLike)VALUES (?,?,?,?,?)");
    $stmt->bind_param("sssss", $UserID,$TopicNum,$PostID,$Like,$DisLike); 
    if ($stmt->execute()) { 
    } else {
        echo "Error: " . $stmt->error;
    } 
    $stmt->close();
    $conn->close();
    return;
 }


if ($mode==2) /*DELETE POST*/
{

    $id = $_GET['id']; 

    $stmt = $conn->prepare("UPDATE post_tb SET IsDeleted=1 WHERE id=$id");
    if ($stmt->execute()) { 
    } else {
        echo "Error: " . $stmt->error;
    } 
    $stmt->close();
    $conn->close();
    return;
  
}


if ($mode==3) /*INSERT VIEW*/
{

    $PostID = $_GET['PostID'];
    $UserID = $_SESSION['UserID']; 

    $stmt = $conn->prepare("INSERT INTO postviews (post_id,user_id)VALUES (?,?)");
    $stmt->bind_param("ss", $PostID,$UserID); 
    if ($stmt->execute()) { 
    } else {
        echo "Error: " . $stmt->error;
    } 
    $stmt->close();
    $conn->close();
    return;
  
}


?>