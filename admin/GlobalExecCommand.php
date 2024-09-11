 
<?php
include('../conn.php');  
$mode = $_GET['mode'];  

 
if ( $mode=='0'){/*BARANGAY*/

      $id = $_GET['id'];
      $muni = $_GET['muni'];

      /*CHECK IF RECORD IS EXISTS*/
      $datas = mysqli_query($conn,"SELECT muni_desc FROM add_muni WHERE muni_desc='$muni'");  
      foreach($datas as $data){  
        echo "<br><div class='alert alert-danger'>Opps!, ".$muni." is already exists!</div>"; 
        return;
      } 

      if ($id=='0'){ /*INSERT NEW RECORD*/ 
          $stmt = $conn->prepare("INSERT INTO add_muni (muni_desc) VALUES ('$muni')"); 
          if ($stmt->execute()) {

            echo "<br><div class='alert alert-success'>New barangay has been added!</div>"; 
          } else {
              echo "Error: " . $stmt->error;
          } 
          $stmt->close();
          $conn->close();

      }

      if ($id!=='0'){ /*UPDATE RECORD*/ 
        $stmt = $conn->prepare("UPDATE add_muni SET muni_desc='$muni' WHERE id=$id"); 
        if ($stmt->execute()) {

          echo "<br><div class='alert alert-success'>Barangay has been updated!</div>"; 
        } else {
            echo "Error: " . $stmt->error;
        } 
        $stmt->close();
        $conn->close();

    }

 
 }




 if ( $mode=='1'){/*STREET*/
        //id,brgy,muni
          $id = $_GET['id'];
          $brgy = $_GET['brgy'];
          $muni = $_GET['muni'];

          /*CHECK IF RECORD IS EXISTS*/
          $datas = mysqli_query($conn,"SELECT brgy_desc FROM add_brgy WHERE brgy_desc='$brgy'");  
          foreach($datas as $data){  
            echo "<br><div class='alert alert-danger'>Opps!, ".$brgy." is already exists!</div>"; 
            return;
          } 

          if ($id=='0'){ /*INSERT NEW RECORD*/ 
              $stmt = $conn->prepare("INSERT INTO add_brgy (brgy_desc,muni_id) VALUES ('$brgy','$muni')"); 
              if ($stmt->execute()) {

                echo "<br><div class='alert alert-success'>New street has been added!</div>"; 
              } else {
                  echo "Error: " . $stmt->error;
              } 
              $stmt->close();
              $conn->close();

          }

          if ($id!=='0'){ /*UPDATE RECORD*/ 
            $stmt = $conn->prepare("UPDATE add_brgy SET brgy_desc='$brgy',muni_id='$muni' WHERE id=$id"); 
            if ($stmt->execute()) {

              echo "<br><div class='alert alert-success'>Purok has been updated!</div>"; 
            } else {
                echo "Error: " . $stmt->error;
            } 
            $stmt->close();
            $conn->close();

        }


}


if ( $mode=='2'){/*CATEGORY*/
  
    $id = $_GET['id'];
    $cat = $_GET['cat']; 

    /*CHECK IF RECORD IS EXISTS*/
    $datas = mysqli_query($conn,"SELECT Category  FROM category_tb WHERE Category ='$cat'");  
    foreach($datas as $data){  
      echo "<br><div class='alert alert-danger'>Opps!, ".$cat." is already exists!</div>"; 
      return;
    } 

    if ($id=='0'){ /*INSERT NEW RECORD*/ 
        $stmt = $conn->prepare("INSERT INTO category_tb (Category) VALUES ('$cat')"); 
        if ($stmt->execute()) {

          echo "<br><div class='alert alert-success'>New Category has been added!</div>"; 
        } else {
            echo "Error: " . $stmt->error;
        } 
        $stmt->close();
        $conn->close();

    }

    if ($id!=='0'){ /*UPDATE RECORD*/ 
      $stmt = $conn->prepare("UPDATE category_tb SET Category='$cat' WHERE id=$id"); 
      if ($stmt->execute()) {

        echo "<br><div class='alert alert-success'>Category has been updated!</div>"; 
      } else {
          echo "Error: " . $stmt->error;
      } 
      $stmt->close();
      $conn->close();

  }


}
  
 
?>