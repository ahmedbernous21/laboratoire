<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/laboratoireForm.css?v=<?php echo time(); ?>">
</head>
<body>
    <?php
        include ('header.php');
        if (@$_SESSION['name']!= null) {
            if ($_SESSION['type']== '0') {
                header("Location: http://localhost/lab/patient.php");
            }else if($_SESSION['type']== '1'){
                header("Location: http://localhost/lab/laboratoireForm.php");
            }
        }
        ?>
<div class="container_ptr">
    <div class="container">
        <div class="title">Inscription utilisateur</div>
        <div class="content">
            <form action="userForm.php" method="post">
                <div class="user-details">
                    <div class="input-box">
                        <span class="details">Nom complet / Nom du laboratoire</span>
                        <input type="text" placeholder="Entrez le nom" name="name" required>
                    </div>
                    <div class="input-box">
                        <span class="details">Email</span>
                        <input type="email" placeholder="Entrez votre email" name="email" required>
                    </div>
                    <div class="input-box">
                        <span class="details">Mot de passe</span>
                        <input type="password" placeholder="Entrez votre mot de passe" name="password" required>
                    </div>
                    <div class="input-box">
                        <span class="details">Confirmez le mot de passe</span>
                        <input type="password" placeholder="Confirmez votre mot de passe" name="Cpassword" required>
                    </div>

                </div>
                <div class="gender-details">
                    <input type="radio" name="type" id="dot-1" value="0">
                    <input type="radio" name="type" id="dot-2" value="1">
                    <span class="gender-title">Type d'utilisateur</span>
                    <div class="category">
                        <label for="dot-1">
                            <span class="dot one"></span>
                            <span class="gender">Patient</span>
                        </label>
                        <label for="dot-2">
                            <span class="dot two"></span>
                            <span class="gender">laboratoire</span>
                        </label>
                    </div>
                </div>
                <div class="button">
                    <input type="submit" value="Inscription" name="sendUser">
                </div>
                <div class="signup_link">
                Vous avez déjà un compte ?
                <a href="http://localhost/lab/login.php">Connexion</a>
            </div>
            </form>
        </div>
    </div>
        </div>
</body>

</html>