<?php
  include('../conn.php');  
 
  $mode= $_GET['mode'];
 
  if ($mode=='0'){ /*USERS*/

        $id= $_GET['id'];
        $ddl= $_GET['ddl'];

        
       
        $stmt = $conn->prepare("UPDATE user_tbl SET Status=$ddl WHERE id=$id"); 
        if ($stmt->execute()) { 
        } else {
            echo "Error: " . $stmt->error;
        } 
        $stmt->close();
        $conn->close();
        return; 

  }

  if ($mode=='1'){/*MUNICIPALITY*/

      $id= $_GET['id'];
      $ddl= $_GET['ddl'];
  
      $stmt = $conn->prepare("UPDATE add_muni SET status=$ddl WHERE id=$id"); 
      if ($stmt->execute()) { 
      } else {
          echo "Error: " . $stmt->error;
      } 
      $stmt->close();
      $conn->close();
      return; 

  }

  if ($mode=='2'){/*BARANGAY*/ 
    $id= $_GET['id'];
    $ddl= $_GET['ddl'];

    $stmt = $conn->prepare("UPDATE add_brgy SET status=$ddl WHERE id=$id"); 
    if ($stmt->execute()) { 
    } else {
        echo "Error: " . $stmt->error;
    } 
    $stmt->close();
    $conn->close();
    return; 

}

if ($mode=='3'){/*CATRGORY*/ 
  $id= $_GET['id'];
  $ddl= $_GET['ddl'];

  $stmt = $conn->prepare("UPDATE category_tb SET status=$ddl WHERE id=$id"); 
  if ($stmt->execute()) { 
  } else {
      echo "Error: " . $stmt->error;
  } 
  $stmt->close();
  $conn->close();
  return; 

}




  
if ($mode=='4'){/*Isstaff*/ 
    $id= $_GET['id'];
    $ddl= $_GET['ddl'];
  
    $stmt = $conn->prepare("UPDATE user_tbl SET Isstaff=$ddl WHERE id=$id"); 
    if ($stmt->execute()) { 
    } else {
        echo "Error: " . $stmt->error;
    } 
    $stmt->close();
    $conn->close();
    return; 
  
  }

?>