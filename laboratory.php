<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/threeforms.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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

          $sql = "INSERT INTO `testtype` (`testName`, `details`, `price`, `delay`, `laboratoire`) VALUES ('$test', '$price', '$delay', '$details', '$test');";  
          $result = $conn->query($sql);
          if ($result === TRUE) {
          header("Location: http://localhost/lab/testLaboratory.php");
          }else {
            echo "connection failed";
          }
          $conn->close();
        }
  ?>
    <a href="./logout.php">logout</a>
    <div class="container">
        <div class="title">Test type</div>
        <div class="content">
            <form action="" method="post">
                <div class="user-details">
                    <div class="input-box">
                        <span class="details">Test Name</span>
                        <input type="text" placeholder="Enter the test name" name="test" required>
                    </div>
                    <div class="input-box">
                        <span class="details">Test dtails</span>
                        <input type="text" placeholder="Enter test details" name="details" required>
                    </div>
                    <div class="input-box">
                        <span class="details">Price</span>
                        <input type="text" placeholder="Enter test price" name="price" required>
                    </div>
                    <div class="input-box">
                        <span class="details">Delay time</span>
                        <input type="number" placeholder="Enter delay time of the test" name="delay" required>
                    </div>
                    <div class="input-box">
                        <span class="details">Laboratoire</span>
                        <input type="text" placeholder="Enter laboratory name" name="laboratoire" required>
                    </div>
                </div>
                <div class="button">
                    <input type="submit" value="Register" name="sendTest">
                </div>
            </form>
        </div>
    </div>
    <div class="container">
        <div class="title">Test type</div>
        <div class="content">
            <form action="" method="post">
                <div class="user-details">
                    <div class="input-box">
                        <span class="details">Test Name</span>
                        <input type="text" placeholder="Enter the test name" name="test" required>
                    </div>
                    <div class="input-box">
                        <span class="details">Test dtails</span>
                        <input type="text" placeholder="Enter test details" name="details" required>
                    </div>
                    <div class="input-box">
                        <span class="details">Price</span>
                        <input type="text" placeholder="Enter test price" name="price" required>
                    </div>
                    <div class="input-box">
                        <span class="details">Delay time</span>
                        <input type="number" placeholder="Enter delay time of the test" name="delay" required>
                    </div>
                    <div class="input-box">
                        <span class="details">Laboratoire</span>
                        <input type="text" placeholder="Enter laboratory name" name="laboratoire" required>
                    </div>
                </div>
                <div class="button">
                    <input type="submit" value="update" name="sendUpdate">
                </div>
            </form>
        </div>
    </div>

    <div class="container">
        <div class="title">Test type</div>
        <div class="content">
            <form action="" method="post">
                <div class="user-details">
                    <div class="input-box">
                        <span class="details">Test Name</span>
                        <input type="text" placeholder="Enter the test name" name="test" required>
                    </div>
                    <div class="input-box">
                        <span class="details">Test dtails</span>
                        <input type="text" placeholder="Enter test details" name="details" required>
                    </div>
                    <div class="input-box">
                        <span class="details">Price</span>
                        <input type="text" placeholder="Enter test price" name="price" required>
                    </div>
                    <div class="input-box">
                        <span class="details">Delay time</span>
                        <input type="number" placeholder="Enter delay time of the test" name="delay" required>
                    </div>
                    <div class="input-box">
                        <span class="details">Laboratoire</span>
                        <input type="text" placeholder="Enter laboratory name" name="laboratoire" required>
                    </div>
                </div>
                <div class="button">
                    <input type="submit" value="delete" name="sendDelete">
                </div>
            </form>
        </div>
    </div>     
    
</body>
</html>