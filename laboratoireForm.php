<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <title>Laboratoire Registration </title>
    <link rel="stylesheet" href="css/laboratoireForm.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

</head>

<body>
    <?php
    include 'header.php';
    include "./connection.php";
    session_start();
    $user_id = $_SESSION['user_id'];
    if (isset($_POST["sendLaborat"]) != null) {
        $emplacement = $_POST['emplacement'];
        $phone = $_POST['phone'];
        $horraire = $_POST['horraire'];
        $imageData = addslashes(file_get_contents($_FILES['image']['tmp_name']));


        $sql = "INSERT INTO `laboratoire` (`emplacement`, `phone`, `horaires`, `recu`) 
        VALUES ( '$emplacement', '$phone','$horraire', '$imageData');";

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
                        <div class="input-box">
                            <span class="details">Emplacement</span>
                            <input type="text" placeholder="Entrez votre emplacement" name="emplacement" required>
                        </div>
                        <div class="input-box">
                            <span class="details">Numéro de téléphone</span>
                            <input type="text" placeholder="Entrez votre numéro" name="phone" required>
                        </div>
                        <div class="input-box">
                            <span class="details">horraires</span>
                            <input type="text" placeholder="Entrez votre horaires de travail" name="horraire" required>
                        </div>
                        <div class="">
                            <p class="payment-info">Payer ici <strong>00XXXXXXXXXX</strong> une somme de <strong>2000
                                    DA</strong> pour activer votre compte</p>
                            <p class="details">Reçu de votre paiement</p>
                            <div class="input-group mb-3">
                                <input type="file" class="form-control" id="image" name="image" accept="image/*"
                                    required>
                            </div>
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