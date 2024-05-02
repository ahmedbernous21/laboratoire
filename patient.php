<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/threeforms.css">
    <title>Patient</title>
</head>
<body>
    <style>
    .user-details .input-box input:focus, .user-details .input-box input:valid {
        border: none;
    }
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
    <div class='link'>
         <a href="./logout.php">logout</a>
   </div>
    <?php
            session_start();
            include "./connection.php";
                  if(isset($_POST["reservez"])!=null){
                        $userName = $_POST['userName'];  
                        $id = $_POST['id'];  
                        $test = $_POST['testName'];  
                        $sql = "INSERT INTO `rendezvous` (`userName`, `testType`, `reservez`) VALUES ('$userName', '$test', '1');";  
                    $result = $conn->query($sql);
                    if ($result === TRUE) {
                        echo "success";
                    }else {
                        echo "connection failed";
                    }
                }else if(isset($_POST["annulez"])!=null){
                    $userName = $_POST['userName'];  
                        $id = $_POST['id'];  
                        $test = $_POST['testName'];  
                        $sql = "UPDATE `rendezvous` SET `reservez` = '0' WHERE `userName` = '$userName' AND `testType` = '$test';";  
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
            echo "<div class='title'>Test disponible</div><div class='content'>";
            while($row = $result->fetch_assoc()) {
                ?>
            <form action="" method="post">
                <div class="user-details">
                <div class="input-box">
                    <input type="hidden"  name="userName" required value=<?php echo $_SESSION['name']; ?>>
                </div>
                <div class="input-box">
                    <input type="hidden"  name="id" required value=<?php echo $row['id']; ?>>
                </div>
                <div class="input-box">
                 <input type="text" value=<?php echo $row['testName']; ?> name="testName" required>
                 </div>
                 <div class="input-box">
                   <input type="text" value=<?php echo $row['details']; ?> name="details" required>
                  </div>
                 <div class="input-box">
                    <input type="text" value=<?php echo $row['price']; ?> name="price" required>
                 </div>
                 <div class="input-box">
                   <input type="number" value=<?php echo $row['delay']; ?> name="delay" required>
                </div>
                  <div class="input-box">
                        <input type="text" value=<?php echo $row['laboratoire']; ?> name="laboratoire" required>
                  </div>
                 </div>
                 <div class="button">
                     <input type="submit" value="reservez" name="reservez">
                 </div>
                 <div class="button">
                     <input type="submit" value="annulez" name="annulez">
                 </div>
            </form>
            <?php
            }}
            ?>
</body>
</html>