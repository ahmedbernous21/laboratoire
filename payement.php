<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <title>Laboratoire Registration</title>
    <link rel="stylesheet" href="css/laboratoireForm.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <?php
    include 'header.php';
    include "./connection.php";
    session_start();
    $user_id = $_SESSION['user_id'];
    if(isset($_POST["sendLaborat"]) != null){

        // Image upload handling
        $imageData = addslashes(file_get_contents($_FILES['image']['tmp_name']));
        
        $update_sql = "UPDATE laboratoire SET `recu` = '$imageData' WHERE id = '$user_id'";
 

        if ($conn->query($sql) === TRUE) {
            $lab_id = $conn->insert_id;
            $update_sql = "UPDATE `users` SET `id_labo` = '$lab_id' WHERE `id` = '$user_id'";
            if ($conn->query($update_sql) === TRUE) {
                echo "New record created successfully";
                header("Location: http://localhost/lab/profile.php");
            } else {
                echo "Error updating utilisateur table: " . $conn->error;
            }
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    }
    ?>
    <div class="container_ptr">
        <div class="container">
            <div class="title">Laboratoire Inscription</div>
            <div class="content">
                <form method="post" enctype="multipart/form-data">
                    <div class="user-details">
                        <!-- Input field for image upload -->
                        <div class="input-box">
                            <span class="details">Reçu de votre paiment</span>
                            <input type="file" name="image" accept="image/*" required>
                        </div>
                    </div>
                    <div class="button">
                        <input type="submit" value="Inscrivez-vous" name="sendLaborat">
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
