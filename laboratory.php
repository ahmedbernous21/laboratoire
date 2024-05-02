<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/threeforms.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laboratoire </title>
</head>
<body>
    <?php      
       session_start();
      include('connection.php');  
      if(isset($_POST["sendTest"])!=null){
      $test = $_POST['test'];  
      $price = $_POST['price'];  
      $delay = $_POST['delay'];  
      $details = $_POST['details'];  
      $laboratoire = $_POST['laboratoire'];  
      
          //to prevent from mysqli injection  
          $username = stripcslashes($username);  
          $password = stripcslashes($password);  
          $test = stripcslashes($test);  
          $price = stripcslashes($price);  
          $delay = stripcslashes($delay);  
          $details = stripcslashes($details);  
          
          $username = mysqli_real_escape_string($conn, $username);  
          $test = mysqli_real_escape_string($conn, $test);  
          $price = mysqli_real_escape_string($conn, $price);  
          $delay = mysqli_real_escape_string($conn, $delay);  
          $details = mysqli_real_escape_string($conn, $details);  
          $laboratoire = mysqli_real_escape_string($conn, $laboratoire);  

          $sql = "INSERT INTO `testtype` (`testName`, `details`, `price`, `delay`, `laboratoire`) VALUES ('$test', '$details', '$delay', '$price', '$laboratoire');";  
          $result = $conn->query($sql);
          if ($result === TRUE) {
          header("Location: http://localhost/lab/testLaboratory.php");
          }else {
            echo "connection failed";
          }
          $conn->close();
        }
  ?>
     <a href="./logout.php">Déconnexion</a>
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
                    <div class="input-box">
                        <span class="details">Laboratoire</span>
                        <input type="text" placeholder="Entrez le nom du laboratoire" name="laboratoire" required>
                    </div>
                </div>
                <div class="button">
                    <input type="submit" value="Enregistrer" name="sendTest">
                </div>
            </form>
        </div>
    </div>     
    
</body>
</html>