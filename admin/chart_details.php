<style>
  .prof_pic{
  width:40px;
  height:40px;
  border-radius:50%;
}

.table{

}

.table tr:hover{
  cursor:pointer;
}
</style>
<?php
include ('../conn.php'); 
$muni = $_GET['muni'];

//echo $muni;

$datas = mysqli_query($conn,"SELECT t1.id,CONCAT(t2.fname,' ',t2.mname,' ',t2.lname) as Fullname
                                    ,t2.profile_pic,t1.DatePosted,t5.cCount,t4.Category
                                    ,IFNULL(LikeCount,0)as LikeCount
                                    ,IFNULL(DisLikeCount,0)as DisLikeCount
                                    ,IsUnkown,CategoryID
                            FROM post_tb t1
                            LEFT JOIN user_tbl t2 on t1.UserID=t2.id
                            LEFT JOIN add_muni t3 on t2.muni=t3.id
                            LEFT JOIN category_tb t4 on t1.CategoryID=t4.id
                            LEFT JOIN (
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
                                       )t5 on t1.id=t5.post_id
                            LEFT JOIN (
                                      SELECT topic_id,SUM(IsLike)as LikeCount,SUM(IsDisLike)as DisLikeCount
                                      FROM likes_tb 
                                      WHERE topic_num=0
                                      GROUP BY topic_id
                                    )t6 on t1.id=t6.topic_id
                            WHERE t3.muni_desc='".$muni."'  and t1.IsDeleted=0
                                "); 
echo "<br>";
 
echo "<table style='width:100%;background:#eeeeee'>
        <tr>
           <td><h5>POST FROM BARANGAY $muni</h5></td>
           <td>
           <input type='text' id='TxtId' class='form-control' placeholder='Search here' onkeyup='myFunction(this.id,12335)' />
           </td>
        </tr>
     </table>
     ";
 
/*
echo "<input type='text' id='TxtId' class='form-control' placeholder='Search here' onkeyup='myFunction(this.id,12335)' />";
*/
echo "<table class='table table-striped'  id='12335'>";
echo "<thead>
      <tr>  
        <th>Fullname</th>
        <th>Category</th> 
        <th>Date Posted</th>
        <th>Like Count</th>
        <th>Dis LikeCount</th>
        <th>Comment Count</th> 
      </tr>
      </thead>";
foreach($datas as $data){  
 
  echo "<tr onclick='return OpenPost(".$data['id'].")'>"; 
  $NewName = $data['Fullname'];
  $NewCat = ($data['CategoryID']==0) ? "OTHERS" : $data['Category'];


  if ($data['IsUnkown']){
    $NewName = "Anonymous@".$data['id'];
  }

  echo    "<td>".$NewName."</td>
          <td>".$NewCat."</td>
          <td>".$data['DatePosted']."</td>
          <td>".$data['LikeCount']."</td>
          <td>".$data['DisLikeCount']."</td>
          <td>".$data['cCount']."</td>
        </tr>"; 
} 
echo "</table>"; 
?>
<div id='PostConvo' class='post'></div>