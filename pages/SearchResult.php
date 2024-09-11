<style>
    
    .fa{
        color:#46B5F5;
    }
</style>
<?php
include('../conn.php');
$value=$_GET['value'];
                // SELECT * FROM `user_tbl` WHERE  fname LIKE '%%' mname LIKE '%%' lname LIKE '%%'
                //$datas = mysqli_query($conn,"SELECT * FROM `user_tbl` WHERE  fname LIKE '%$value%' or  mname LIKE '%$value%' or lname LIKE '%$value%'");
                $datas = mysqli_query($conn,"SELECT 0 AS typ, CONCAT(t1.fname,' ',t1.mname,' ',t1.lname) AS MyWant, t1.id 
                                             FROM user_tbl t1
                                             WHERE  fname LIKE '%$value%' or  mname LIKE '%$value%' or lname LIKE '%$value%'
                                             
                                             UNION ALL 
                                            
                                            SELECT 1 AS typ, CONCAT(t2.Category,'-',LEFT(t1.msg,10)) AS MyWant,t1.id
                                            FROM post_tb t1
                                            LEFT JOIN category_tb t2 on t1.CategoryID=t2.id
                                            WHERE msg LIKE '%$value%' OR t2.Category LIKE '%$value%' ");
        $num=1; 
        echo "<div class='SearchBox' id='fixedDiv'>"; 
        echo "Result for '".$value ."'<br>"; 
        echo "<table style='width:100%'>";
        foreach($datas as $data){    
                    echo "<tr class='srch_row' onclick='ViewSearch(".$data['typ'].",".$data['id'].")'>";
                    //echo "<td>".$num."</td><td>".$data['MyWant']."</td>"; 
                    echo "
                        <td>".(($data['typ']==0) ? "<i class='fa fa-user'></i>" : "<i class='fa fa-book'></i>")."</td>
                        <td style='text-align:left'>".$data['MyWant']."</td>
                         ";
                    echo "</tr>";
                    
                    //echo "<div>1</div>";
            $num+=1;
            }   
        echo"</table>";
        echo"</div>"; 
?>