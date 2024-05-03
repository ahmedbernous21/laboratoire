<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/threeforms.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rendez vous</title>
</head>
<style>
    body.test form {
        width: 30%;
        margin: 10px;      
        width:25%;
        min-width: 150px;
    }
    body.test .container {
        
        width: 90%;
        min-width: 250px;


    }

    .user-details {
        display: flex;
        padding: 10px;

    }
    .content form .user-details {
        Flex-wrap:wrap;
    } 
    .content {
        display: flex;
        Flex-wrap:wrap;
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
<body class="test">
   <div class='link'>
         <a href="/lab/testLaboratory.php">see test</a>
         <a href="./logout.php">logout</a>
   </div>
    <div>
     <?php
            include "./connection.php";
            $sql = "SELECT * FROM `rendezvous`";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
            // output data of each row
            echo "<div class='container test'>";
            echo "<div class='title'>Les rendez vous</div><div class='content'>";
            while($row = $result->fetch_assoc()) {
                ?>

            <form action="" method="post">
                <div class="user-details">
                    <div class="input-box">
                    <input type="text" value="<?php echo $row['userName']; ?>" name="testName" required>
                    </div>
                    <div class="input-box">
                    <input type="text" value="<?php echo $row['testType']; ?> " name="details" required>
                    </div>
                    <div class="input-box">
                        <input type="text" value="<?php if ($row['reservez']==='0') {echo 'reserver';}else{echo 'annulez';} ?>" name="price" required>
                    </div>
            </div>    

            </form>
            <?php
            }}
            ?>
        
    
</body>
</html>