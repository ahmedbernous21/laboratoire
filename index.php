<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="css\index.css">
    <title>LabsCo</title>
</head>

<body>
    <header>
        <a href="#" class="logo">LabsCo</a>
        <nav class="navigation ">
            <a href="#services">Laboratories</a>
            <a href="#offres">Nos Offres</a>
            <a href="./login.php">Profile</a>
        </nav>
    </header>



    <section class="main">
        <div>
            <h1>Bienvenue sur notre plateforme <br>
                 de laboratoires médicaux !</h1>
            <h2 >Trouvez rapidement des laboratoires médicaux, <br>
                prenez rendez-vous et consultez vos résultats,<br>
                le tout sur une plateforme intuitive.</h2>
            <a href="/lab/singup.php" class="main-btn">Inscrivez-vous</a>
        </div>

    </section>

    <section class="cards" id="services">
        <div>
            <h2 class="title">Laboratoires disponible</h2>
            <form action="" method="GET">
                <div class="input-group mb-3">
                    <input type="text" name="search" required placeholder='emplacement , horaires' value="<?php if(isset($_GET['search'])){echo $_GET['search']; } ?>" class="form-control" placeholder="Search data">
                    <button type="submit" class="btn btn-primary">Recherche</button>
                </div>
            </form>
        </div>
        <div class="content">
            <?php
            include "./connection.php";

            if(isset($_GET['search']))
                {
                    $filtervalues = $_GET['search'];
                    $query = "SELECT * FROM laboratoire WHERE CONCAT(emplacement,horaires) LIKE '%$filtervalues%' ";
                    $query_run = mysqli_query($conn, $query);

                    if(mysqli_num_rows($query_run) > 0)
                    {
                        foreach($query_run as $items)
                        {
                            ?>
                            <div class="card">
                                <div class="icon">
                                    <i class="fas fa-layer-group"></i>
                                </div>
                                <div class="info">
                                    <h4><?php echo $items['nom']; ?></h4>
                                    <p><strong>Laboratoire Description:</strong> Lorem ipsum dolor sit amet consectetur adipisicing elit. Quis
                                        obcaecati, distinctio suscipit eaque deleniti voluptas delectus.</p>
                                    <p id="place"><strong>Emplacement:</strong><?php echo $items['emplacement']; ?></p>
                                    <p id="horaires"><strong>Horaires:</strong><?php echo $items['horaires']; ?></p>
                                    <p><strong>Phone:</strong> <?php echo $items['numeroDeTelephone']; ?> </p>
                                </div>
                        </div>
                            <?php
                        }
                    }
                }
            else {
            $sql = "SELECT * FROM `laboratoire`";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
            ?>
            <div class="card">
                <div class="icon">
                    <i class="fas fa-layer-group"></i>
                </div>
                <div class="info">
                    <h4><?php echo $row['nom']; ?></h4>
                    <p><strong>Laboratoire Description:</strong> Lorem ipsum dolor sit amet consectetur adipisicing elit. Quis
                        obcaecati, distinctio suscipit eaque deleniti voluptas delectus.</p>
                    <p id="place"><strong>Emplacement:</strong><?php echo $row['emplacement']; ?></p>
                    <p id="horaires"><strong>Horaires:</strong><?php echo $row['horaires']; ?></p>
                    <p><strong>Phone:</strong> <?php echo $row['numeroDeTelephone']; ?> </p>
                </div>
            </div>
            <?php
                }}}
            ?>
        </div>

    </section>
    <section class="offres" id="offres">
        <h2 class="title">Nos Offres</h2>
        <div class="off">
            <img src="./image/offres.jpeg" alt="">
            <p>Découvrez notre offre d'abonnement <strong>exclusive</strong> pour les laboratoires médicaux. Avec notre abonnement mensuel à <strong>2000 DA</strong><br> 
            les laboratoires peuvent bénéficier d'un accès <strong>complet</strong> à notre plateforme, leur permettant de gérer <strong>efficacement</strong> leurs informations,
            de prendre en charge les rendez-vous des patients et d'envoyer rapidement les résultats.<br>
            En plus de cela, notre système de tarification <strong>transparent</strong> prévoit des frais de rendez-vous de <strong>8%</strong> pour les consultations au laboratoire et de <strong>10%</strong> pour les consultations à domicile,<br>
            offrant ainsi une solution <strong>rentable</strong> et <strong>pratique</strong> pour les laboratoires de toutes tailles. <br>
            Rejoignez-nous dès aujourd'hui pour simplifier la gestion de votre laboratoire et offrir une expérience <strong>optimale</strong> à vos patients.</p>

        </div>

    
    </section>
</body>

</html>