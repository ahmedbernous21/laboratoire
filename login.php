<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Login Form</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' href='./css/login.css'>

</head>

<body>
    <?php
    include ('header.php');
    include ('connection.php');
    session_start();
    $loggedIn = false;
    if (isset($_POST["login"]) != null) {
        $username = $_POST['user'];
        $password = $_POST['pass'];
        //to prevent from mysqli injection  
        $username = stripcslashes($username);
        $password = stripcslashes($password);
        $username = mysqli_real_escape_string($conn, $username);
        $password = mysqli_real_escape_string($conn, $password);

        $sql = "SELECT  * FROM users WHERE nom = '$username' and password = '$password'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $loggedIn = true;
            while ($row = $result->fetch_assoc()) {
                $_SESSION['user_id'] = $row["id"];
                $_SESSION['name'] = $row["nom"];
                $_SESSION['emailUser'] = $row["email"];
                $_SESSION['password'] = $row["password"];
                $_SESSION['type'] = $row["type"];
                $_SESSION['is_admin'] = $row["is_admin"];

                if ($row["type"] == '0') {
                    header("Location: http://localhost/lab/index.php");
                } else if ($row["type"] == '1') {
                    header("Location: http://localhost/lab/profile.php");
                }
            }
        } else {
            echo "check your username or password";
        }
        $conn->close();
    }
    ?>
    <div class="center">
        <h1>Connexion</h1>
        <form method="post">
            <div class="txt_field">
                <input type="text" required name="user">
                <span></span>
                <label>Nom Complet</label>
            </div>
            <div class="txt_field">
                <input type="password" required name="pass">
                <span></span>
                <label>Mot de passe</label>
            </div>
            <input type="submit" value="Connexion" name="login">
            <div class="signup_link">
                Non membre ?
                <a href="http://localhost/lab/singup.php">Inscrivez vous</a>
            </div>
        </form>
    </div>
</body>

</html>