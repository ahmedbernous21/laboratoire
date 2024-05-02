<?php
        include "./connection.php";
        if(isset($_POST["sendLaborat"])!=null){
            $name = $_POST['name'];
            $emplacement = $_POST['emplacement'];
            $email = $_POST['email'];
            $number = $_POST['number'];
            $horraire = $_POST['horraire'];
              
            $sql = "INSERT INTO `laboratoire` (`nom`, `emplacement`, `email`, `numeroDeTelephone`, `horaires`) 
            VALUES ('$name', '$emplacement', '$email', '$number','$horraire');";

            if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
            } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
            }

            $conn->close();
            
        }
        else{
            die ("Error 404");
            }
        header("Location: http://localhost/lab/laboratory.php");
?>