<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/laboratoireForm.css">
</head>

<body>
    <?php
        session_start();
        if (@$_SESSION['name']!= null) {
            if ($_SESSION['type']== '0') {
                header("Location: http://localhost/lab/patient.php");
            }else if($_SESSION['type']== '1'){
                header("Location: http://localhost/lab/laboratoireForm.html");
            }
        }
        ?>
    <div class="container">
        <div class="title">User Registration</div>
        <div class="content">
            <form action="userForm.php" method="post">
                <div class="user-details">
                    <div class="input-box">
                        <span class="details">Full Name</span>
                        <input type="text" placeholder="Enter your name" name="name" required>
                    </div>
                    <div class="input-box">
                        <span class="details">email</span>
                        <input type="email" placeholder="Enter your email" name="email" required>
                    </div>
                    <div class="input-box">
                        <span class="details">password</span>
                        <input type="password" placeholder="Enter your password" name="password" required>
                    </div>
                    <div class="input-box">
                        <span class="details">Confirm password</span>
                        <input type="password" placeholder="Confirm your password" name="Cpassword" required>
                    </div>

                </div>
                <div class="gender-details">
                    <input type="radio" name="type" id="dot-1" value="0">
                    <input type="radio" name="type" id="dot-2" value="1">
                    <span class="gender-title">Type of user</span>
                    <div class="category">
                        <label for="dot-1">
                            <span class="dot one"></span>
                            <span class="gender">Patient</span>
                        </label>
                        <label for="dot-2">
                            <span class="dot two"></span>
                            <span class="gender">laboratory</span>
                        </label>
                    </div>
                </div>
                <div class="button">
                    <input type="submit" value="Register" name="sendUser">
                </div>
                <div class="signup_link">
                you already have an ?
                <a href="http://localhost/lab/login.php">login</a>
            </div>
            </form>
        </div>
    </div>
</body>

</html>