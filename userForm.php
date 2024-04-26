<?php
        include "./connection.php";
        session_start();
        if ($_SESSION['name']!= null) {
            if ($_SESSION['type']== '0') {
                header("Location: http://localhost/lab/patient.php");
            }else if($_SESSION['type']== '1'){
                header("Location: http://localhost/lab/laboratoireForm.html");
            }
        }
        isset($_POST["sendUser"]);
        if(isset($_POST["sendUser"])!=null){
            $name = $_POST['name'];
            $type = $_POST['type'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $Cpassword = $_POST['Cpassword'];
            
            if ($password==$Cpassword) {
                if ($name & $email) {
                    $sql = "INSERT INTO `users` (`nom`, `email`, `password`, `type`) 
                    VALUES ('$name', '$email', '$password','$type');";
                    if ($conn->query($sql) === TRUE) {
                    echo "New record created successfully";
                    $_SESSION['name'] = $name;
                    $_SESSION['emailUser'] = $email;
                    $_SESSION['password'] = $password;
                    $_SESSION['type']   = $type;
                    
                    if ($type=='0') {
                        // header("Location: http://localhost/lab/patient.php");
                    }else if($type=='1'){
                        // header("Location: http://localhost/lab/laboratoireForm.html");
                    }
                    } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                    $conn->close();
                }else{
                    die('confirme your name and username');
                }
            }else{
                die('confirme your password');
            }    
        }
        else{
            die ("arjq3 man jiti");
            }
?>