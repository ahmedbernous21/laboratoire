<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/threeforms.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body class="test">
     <?php
            include "./connection.php";

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
                     <input type="submit" value="update" name="sendUpdate">
                 </div>
                 <div class="button">
                     <input type="submit" value="delete" name="sendDelete">
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
</body>