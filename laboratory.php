<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/threeforms.css?v=<?php time()?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laboratoire </title>
</head>
<body>
    <?php      
      include('header.php');
      include('connection.php');  
      if(isset($_POST["sendTest"])!=null){
      $test = $_POST['test'];  
      $price = $_POST['price'];  
      $delay = $_POST['delay'];  
      $details = $_POST['details'];  
      $currentLabId = $_SESSION['users_id_labo'];
          //to prevent from mysqli injection  
          $password = stripcslashes($password);  
          $test = stripcslashes($test);  
          $price = stripcslashes($price);  
          $delay = stripcslashes($delay);  
          $details = stripcslashes($details);  
          
          $test = mysqli_real_escape_string($conn, $test);  
          $price = mysqli_real_escape_string($conn, $price);  
          $delay = mysqli_real_escape_string($conn, $delay);  
          $details = mysqli_real_escape_string($conn, $details);  

          $sql = "INSERT INTO `testtype` (`id_labo`,`testName`, `details`, `price`, `delay`) VALUES ('$currentLabId','$test', '$details', '$delay', '$price');";  
          $result = $conn->query($sql);
          if ($result === TRUE) {
          header("Location: http://localhost/lab/testLaboratory.php");
          }else {
            echo "connection failed";
          }
          $conn->close();
        }
  ?>
  <div class="container_ptr">
    <a href="/lab/testLaboratory.php">Afficher les tests</a>
    <div class="container">
        <div class="title">Type de Test</div>
        <div class="content">
            <form action="" method="post">
                <div class="user-details">
                    <div class="input-box">
                        <span class="details">Nom du test</span>
                        <input type="text" placeholder="Entrez le nom du test" name="test" required>
                    </div>
                    <div class="input-box">
                        <span class="details">Détails du test</span>
                        <input type="text" placeholder="Entrez les détails du test" name="details" required>
                    </div>
                    <div class="input-box">
                        <span class="details">Prix</span>
                        <input type="text" placeholder="Entrez le prix du test" name="price" required>
                    </div>
                    <div class="input-box">
                        <span class="details">Délai</span>
                        <input type="number" placeholder="Entrez le délai du test" name="delay" required>
                    </div>
                </div>
                <div class="button">
                    <input type="submit" value="Enregistrer" name="sendTest">
                </div>
            </form>
        </div>
    </div>     
    </div>
</body>
</html>