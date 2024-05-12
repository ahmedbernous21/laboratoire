<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/threeforms.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    a {
        color: #212121;
        text-decoration: none;
        font-size: .9rem;
    }
    .link {
        display: flex;
        flex-direction: column;
        position: absolute;
        top: 20px;
        left: 20px;
        padding:10px;
        z-index: 1253;
        background: #fff;
        border-radius: 5px; 
        box-shadow: 0 1px 4px #333;
    }
</style>
<body class="test">
  <?php 
  include "header.php";
  ?>
  <div class="container_ptr">
    <div class='link'>
         <a href="/lab/laboratory.php">Ajouter un test</a>
         <a href="/lab/rendezVous.php">consultez les rendez vous</a>
   </div>
     <?php
            include "./connection.php";
      if(isset($_POST["sendUpdate"])!=null){
            $id = $_POST['id'];  
            $test = $_POST['testName'];
            $price = $_POST['price'];  
            $delay = $_POST['delay'];  
            $details = $_POST['details'];  
            $laboratoire = $_POST['laboratoire'];  
            $sql = "UPDATE `testtype` SET `testName` = '$test', `details` = '$details', `price` = '$price', `delay` = '$delay', `laboratoire` = '$laboratoire' WHERE `testtype`.`id` = '$id';";  
          $result = $conn->query($sql);
          if ($result === TRUE) {
            echo "success";
          }else {
            echo "connection failed";
          }
      }
      else if(isset($_POST["sendDelete"])!=null){
            $id = $_POST['id'];  
            $test = $_POST['testName'];  
            $price = $_POST['price'];  
            $delay = $_POST['delay'];  
            $details = $_POST['details'];  
            $laboratoire = $_POST['laboratoire'];  
            $sql = "DELETE FROM `testtype` WHERE `testtype`.`id` = '$id';";  
          $result = $conn->query($sql);
          if ($result === TRUE) {
            echo "success";
          }else {
            echo "connection failed";
          }
      }
            $sql = "SELECT * FROM `testtype`";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
            // output data of each row
            echo "<div class='container test'>";
            echo "<div class='title'>Test type</div><div class='content'>";
            while($row = $result->fetch_assoc()) {
                ?>
            <form action="" method="post">
                <div class="user-details">
                <div class="input-box">
                    <input type="hidden"  name="id" required value=<?php echo $row['id']; ?>>
                </div>
                <div class="input-box">
                 <input type="text" value="<?php echo $row['testName']; ?>" name="testName" required>
                 </div>
                 <div class="input-box">
                   <input type="text" value="<?php echo $row['details']; ?>" name="details" required>
                  </div>
                 <div class="input-box">
                    <input type="text" value="<?php echo $row['price']; ?>" name="price" required>
                 </div>
                 <div class="input-box">
                   <input type="number" value="<?php echo $row['delay']; ?>" name="delay" required>
                </div>
                  <div class="input-box">
                        <input type="text" value="<?php echo $row['laboratoire']; ?>" name="laboratoire" required>
                  </div>
                 </div>
                 <div class="button">
                     <input type="submit" value="Mise a jour" name="sendUpdate">
                 </div>
                 <div class="button">
                     <input type="submit" value="suprimer" name="sendDelete">
                 </div>
            </form>
            <?php
            }
            ?>
            </div>
        </div>
        <?php
            } else {
            echo "0 results";
            }
            $conn->close();
?> 
        
    </div>
    </div>
</body>
</html>