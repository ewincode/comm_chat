<style>
    .divs{
        width: 100%;
        height: 100%;
        background-color:white;
        padding:5px;
    }
    
    .dPost{
         color:orange;
         margin-top:-20px;   
         font-size:10px;
    }

    .tdDiv{

        background-color:#bdf4fc;
        width: 100%;
        padding:5px;
        border-radius:4px;
    }

    table td{
        padding:5px
    }
</style>

<?php

include ('../conn.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }
$UserID = $_SESSION['UserID'];
 

$mode = $_GET['mode'];
 
$datas = mysqli_query($conn,"SELECT t2.userID
                                    ,t1.user_id as sID
                                    ,CONCAT(fname, ' ', lname) AS FullName
                                    ,(CASE
                                        WHEN t1.mode=0 THEN '&#128233;'
                                        WHEN t1.mode=1 THEN '&#128077;'
                                        ELSE ''
                                    END) as mode 
                                    ,'POST' as mode2
                                    ,t1.created_date
                                    ,LEFT(t2.msg,20)as msg
                            FROM(
                                SELECT (CASE 
                                        WHEN t1.mode=0 THEN t2.post_id 
                                        WHEN t1.mode=1 THEN t3.topic_id
                                        ELSE 0
                                        END)as PostID
                                ,t1.user_id
                                ,t1.created_date
                                ,t1.mode
                                ,t1.status
                                FROM notifi_tbl t1
                                LEFT JOIN comment_tbl t2 on t1.new_id=t2.id and t1.mode=0
                                LEFT JOIN likes_tb t3 on t1.new_id=t3.id and t1.mode=1
                                WHERE t1.status=0
                            )t1
                            LEFT JOIN post_tb t2 on t1.PostID=t2.id
                            LEFT JOIN user_tbl t3 on t1.user_id=t3.id
                            WHERE t2.userID=$UserID
                            ");
        
 

if ($mode==0){

    $num =0;
    foreach($datas as $data){ 
        $num+=1;
      } 

    echo $num;
    return;
}

if ($mode==1){

   echo "<div class='divs'> 
        <h5>Notifications</h5>
        <table style='width:100%;'>";
        foreach($datas as $data){ 
        echo "<tr>
                    <td><div class='tdDiv' onclick='return ViewNotification(1)'>
                            <p><b>".$data['FullName']."</b> ".$data['mode']." on ".$data['mode2']." about ''<i style='color:blue'>".$data['msg']."...</i>''</p>
                            <p class='dPost'>".$data['created_date']."</p>
                        </div>
                     </td>
               </tr>";
        } 
   echo "</table>
         <br>
         <center>No more notifications here</center>
        </div>";
}

?>