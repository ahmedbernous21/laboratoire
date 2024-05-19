<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <link rel="stylesheet" href="css\index.css?v=<?php time() ?>">
    <title>LabsCo</title>
</head>

<body>
    <?php
    include ('header.php');
    include "./connection.php";
    if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];
    }
    if (isset($_POST['sendRDV'])) {
        if (isset($_POST['laboId'])) {
            $laboId = $_POST['laboId'];
            $selectedTests = $_POST['testType'];
            $status = 'unconfirmed';
            $date = $_POST['date'];
            $details = $_POST['details'];
            $domicile = $_POST['domicile'];
            $sql_rdv = "INSERT INTO `randezvous` (`user_id`,`labo_id`,`status`,`date`, `description`, `is_domicile`) VALUES ('$userId', '$laboId', '$status', '$date', '$details', '$domicile')";
            $result_rdv = $conn->query($sql_rdv);

            if ($result_rdv == TRUE && $_SESSION['http://localhost/lab/type'] == '0') {
                $rdvId = $conn->insert_id;
                foreach($selectedTests as $test_id) {
                    if($test_id !="other"){
                    $sql_insert_test = "INSERT INTO `rdv_tests` (`rdv_id`, `test_id`) 
                                        VALUES ('$rdvId', '$test_id')";
                    // Execute the SQL query
                    $conn->query($sql_insert_test);
                    }
                }
            
                header("Location: rendezVous.php");
            } else {
                echo "Une erreur s'est produite lors de l'enregistrement du rendez-vous.";
            }
            $conn->close();
        } else {
            echo "Tous les champs du formulaire doivent être remplis.";
        }
    }
    ?>



    <section class="main">
        <div>
            <h1>Bienvenue sur notre plateforme <br>
                de laboratoires médicaux !</h1>
            <h2>Trouvez rapidement des laboratoires médicaux, <br>
                prenez rendez-vous et consultez vos résultats,<br>
                le tout sur une plateforme intuitive.</h2>
            <?php
            if (isset($_SESSION['name'])) {
                ?>
                <a href="#services" class="main-btn">Prendre un Rendez-vous</a>
                <?php
            } else {
                echo '<a href="/lab/signup.php" class="main-btn">Inscrivez-vous</a>';
            }

            ?>
        </div>

    </section>

    <section class="cards" id="services">
        <div>
            <h2 class="title">Laboratoires disponible</h2>
            <form action="" method="GET">
                <div class="input-group mb-3">
                    <input type="text" name="search" required placeholder='emplacement , horaires' value="<?php if (isset($_GET['search'])) {
                        echo $_GET['search'];
                    } ?>" class="form-control" placeholder="Search data">
                    <button type="submit" class="btn btn-primary">Recherche</button>
                </div>
            </form>
        </div>
        <div class="content">
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                <?php
                if (isset($_GET['search'])) {
                    $filtervalues = $_GET['search'];
                    $query = "SELECT laboratoire.*, users.* , laboratoire.id AS laboID
                    FROM laboratoire 
                    INNER JOIN users ON users.id_labo = laboratoire.id 
                    WHERE CONCAT(laboratoire.emplacement, laboratoire.horaires) LIKE '%$filtervalues%' AND `is_paid` = '1'";
                    $query_run = mysqli_query($conn, $query);

                    if (mysqli_num_rows($query_run) > 0) {
                        foreach ($query_run as $items) {
                            ?>
                            <div class="col">
                                <div class="card" style="border-radius: 15px;">
                                    <div class="card-body text-center">
                                        <div class="mt-3 mb-4">
                                            <img src="./image/laboratory.png" class="rounded-circle img-fluid"
                                                style="width: 100px;" />
                                        </div>
                                        <h4 class="mb-2"><?php echo $items['nom']; ?></h4>
                                        <p class="text-muted mb-4"><?php echo $items['email']; ?><span class="mx-2">|</span> <a
                                                href="#!"><?php echo $items['phone']; ?></a></p>
                                        <div class="mb-2 pb-2">
                                            <p><strong>Emplacement: </strong><span><?php echo $items['emplacement']; ?></span></p>
                                            <p><strong>Horaires: </strong><span><?php echo $items['horaires']; ?></span></p>
                                        </div>
                                        <div class="accordion mt-2 mb-4" id="testAccordion">
                                            <?php
                                            $filter_id = $items['laboID'];
                                            $sql_display = "SELECT * FROM `testtype` WHERE id_labo = '$filter_id' ";
                                            $result_test = $conn->query($sql_display);
                                            if ($result_test->num_rows > 0) {
                                                while ($row = $result_test->fetch_assoc()) {

                                                    ?>
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="heading<?php echo $row['id'] ?>">
                                                            <button class="accordion-button collapsed" type="button"
                                                                data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $row['id'] ?>"
                                                                aria-expanded="false" aria-controls="collapse<?php echo $row['id'] ?>">
                                                                <?php echo $row['testName'] ?>
                                                            </button>
                                                        </h2>
                                                        <div id="collapse<?php echo $row['id'] ?>" class="accordion-collapse collapse"
                                                            aria-labelledby="heading<?php echo $row['id'] ?>"
                                                            data-bs-parent="#testAccordion">
                                                            <div class="accordion-body">
                                                                <p><strong>Détails:</strong> <?php echo $row['details'] ?></p>
                                                                <p><strong>Prix:</strong> <?php echo $row['price'] ?></p>
                                                                <p><strong>Délai:</strong> <?php echo $row['delay'] ?></p>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </div>
                                        <div class="d-block">
                                            <div class="modal fade" id="exampleModal<?php echo $filter_id ?>" tabindex="-1"
                                                role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Prendre un Rendez-vous
                                                            </h5>
                                                        </div>
                                                        <form action="" method="post">
                                                            <input type="hidden" name="laboId" id="laboId"
                                                                value="<?php echo $filter_id ?>">
                                                            <div class="modal-body">
                                                                <div class="input-group mb-4">
                                                                    <select class="form-select" id="testType" name="testType">
                                                                        <?php
                                                                        $sql_modal = "SELECT * FROM `testtype` WHERE id_labo = '$filter_id' ";
                                                                        $result_modal = $conn->query($sql_modal);
                                                                        if ($result_modal->num_rows > 0) {
                                                                            while ($row_test = $result_modal->fetch_assoc()) {
                                                                                $price = $row_test['testName'];
                                                                                $test_id = $row_test['id'];
                                                                                ?>
                                                                                <option value="<?php echo $test_id; ?>" name="test_id">
                                                                                    <?php echo $price ?></option>
                                                                                <?php
                                                                            }
                                                                        }
                                                                        ?>
                                                                        <option value="other">Un autre test</option>
                                                                    </select>
                                                                </div>
                                                                <div class="input-group mb-4">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" id="">Date de test</span>
                                                                    </div>
                                                                    <input type="date" class="form-control" id="date" name="date">
                                                                </div>
                                                                <div class="input-group mb-4">
                                                                    <span class="input-group-text" id="">Détails de test</span>
                                                                    <textarea class="form-control" id="details" rows="3"
                                                                        name="details"></textarea>
                                                                </div>
                                                                <div class="input-group mb-4">
                                                                    <span class="input-group-text">Résultat à domicile</span>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="domicile" id="domicileYes" value="1">
                                                                        <label class="form-check-label" for="domicileYes">Oui</label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="domicile" id="domicileNo" value="O" checked>
                                                                        <label class="form-check-label" for="domicileNo">Non</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary mx-4"
                                                                    data-bs-dismiss="modal">Fermer</button>
                                                                <button type="submit" class="btn btn-primary" value="Enregistrer"
                                                                    name="sendRDV">Enregistrer</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="info">
                                            <?php if (isset($_SESSION['name']) && $_SESSION['is_admin'] == '0') {
                                                ?>
                                                <button class="btn btn-info open-rdv" id="sendLaboId" data-bs-toggle="modal"
                                                    data-bs-target="#exampleModal<?php echo $filter_id ?>">Prendre un
                                                    RDV</button>
                                                <?php
                                            } else {
                                                echo '<div class="btn btn-secondary"><a class="link-dark" href="./login.php">Prendre un RDV</a></div>';
                                            } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }
                } else {
                    $sql = "SELECT * FROM `laboratoire` WHERE `is_paid` = '0'";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        // output data of each row
                        while ($row = $result->fetch_assoc()) {
                            $laboId = $row['id'];
                            $sql_user = "SELECT * FROM `users` WHERE id_labo = '$laboId'";
                            $result_user = $conn->query($sql_user);
                            if ($result_user->num_rows > 0)
                                $username = mysqli_fetch_assoc($result_user);
                            ?>
                            <div class="col">
                                <div class="card" style="border-radius: 15px;">
                                    <div class="card-body text-center">
                                        <div class="mt-3 mb-4">
                                            <img src="./image/laboratory.png" class="rounded-circle img-fluid"
                                                style="width: 100px;" />
                                        </div>
                                        <h4 class="mb-2"><?php echo $username['nom']; ?></h4>
                                        <p class="text-muted mb-4"><?php echo $username['email']; ?><span class="mx-2">|</span> <a
                                                href="#!"><?php echo $row['phone']; ?></a></p>
                                        <div class="mb-2 pb-2">
                                            <p><strong>Emplacement: </strong><span><?php echo $row['emplacement']; ?></span></p>
                                            <p><strong>Horaires: </strong><span><?php echo $row['horaires']; ?></span></p>
                                        </div>
                                        <div class="accordion mt-2 mb-4" id="testAccordion">
                                            <?php
                                            $sql_display = "SELECT * FROM `testtype` WHERE id_labo = '$laboId' ";
                                            $result_test = $conn->query($sql_display);
                                            if ($result_test->num_rows > 0) {
                                                while ($row = $result_test->fetch_assoc()) {

                                                    ?>
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="heading<?php echo $row['id'] ?>">
                                                            <button class="accordion-button collapsed" type="button"
                                                                data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $row['id'] ?>"
                                                                aria-expanded="false" aria-controls="collapse<?php echo $row['id'] ?>">
                                                                <?php echo $row['testName'] ?>
                                                            </button>
                                                        </h2>
                                                        <div id="collapse<?php echo $row['id'] ?>" class="accordion-collapse collapse"
                                                            aria-labelledby="heading<?php echo $row['id'] ?>"
                                                            data-bs-parent="#testAccordion">
                                                            <div class="accordion-body">
                                                                <p><strong>Détails:</strong> <?php echo $row['details'] ?></p>
                                                                <p><strong>Prix:</strong> <?php echo $row['price'] ?></p>
                                                                <p><strong>Délai:</strong> <?php echo $row['delay'] ?></p>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </div>
                                        <div class="d-block">
                                            <div class="modal fade" id="exampleModal<?php echo $laboId ?>" tabindex="-1"
                                                role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Prendre un Rendez-vous
                                                            </h5>
                                                        </div>
                                                        <form action="" method="post">
                                                            <input type="hidden" name="laboId" id="laboId"
                                                                value="<?php echo $laboId ?>">
                                                            <div class="modal-body">
                                                                <div class="input-group mb-4">
                                                                <select class="form-select" id="testType" name="testType[]" data-mdb-select-init multiple>
                                                                    <?php
                                                                    $sql_modal = "SELECT * FROM `testtype` WHERE id_labo = '$laboId' ";
                                                                    $result_modal = $conn->query($sql_modal);
                                                                    if ($result_modal->num_rows > 0) {
                                                                        while ($row_test = $result_modal->fetch_assoc()) {
                                                                            $price = $row_test['testName'];
                                                                            $test_id = $row_test['id'];
                                                                    ?>
                                                                            <option value="<?php echo $test_id; ?>">
                                                                                <?php echo $price ?>
                                                                            </option>
                                                                    <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                       <option value="other">
                                                                                <p>Un autre test</p>
                                                                        </option>
                                                                </select>       
                                                                </div>
                                                                <div class="input-group mb-4">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" id="">Date de test</span>
                                                                    </div>
                                                                    <input type="date" class="form-control" id="date" name="date">
                                                                </div>
                                                                <div class="input-group mb-4">
                                                                    <span class="input-group-text" id="">Détails de test</span>
                                                                    <textarea class="form-control" id="details" rows="3"
                                                                        name="details"></textarea>
                                                                </div>
                                                                <div class="input-group mb-4">
                                                                    <span class="input-group-text">Résultat à domicile</span>
                                                                    <div class="form-check ms-4">
                                                                        <input class="form-check-input" type="radio" name="domicile" id="domicileYes" value="1">
                                                                        <label class="form-check-label" for="domicileYes">Oui</label>
                                                                    </div>
                                                                    <div class="form-check ms-4">
                                                                        <input class="form-check-input" type="radio" name="domicile" id="domicileNo" value="0" checked>
                                                                        <label class="form-check-label" for="domicileNo">Non</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary mx-4"
                                                                    data-bs-dismiss="modal">Fermer</button>
                                                                <button type="submit" class="btn btn-primary" value="Enregistrer"
                                                                    name="sendRDV">Enregistrer</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="info">
                                            <?php if (isset($_SESSION['name']) && $_SESSION['is_admin'] == '0') {
                                                ?>
                                                <button class="btn btn-info open-rdv" id="sendLaboId" data-bs-toggle="modal"
                                                    data-bs-target="#exampleModal<?php echo $laboId ?>">Prendre un
                                                    RDV</button>
                                                <?php
                                            } else {
                                                echo '<div class="btn btn-secondary"><a class="link-dark" href="./login.php">Prendre un RDV</a></div>';
                                            } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }
                }
                ?>
            </div>
        </div>

    </section>

    <section class="offres" id="offres">
        <h2 class="title">Nos Offres</h2>
        <div class="off">
            <img src="./image/offres.jpeg" alt="">
            <p>Découvrez notre offre d'abonnement <strong>exclusive</strong> pour les laboratoires médicaux. Avec notre
                abonnement mensuel à <strong>2000 DA</strong><br>
                les laboratoires peuvent bénéficier d'un accès <strong>complet</strong> à notre plateforme, leur
                permettant de gérer <strong>efficacement</strong> leurs informations,
                de prendre en charge les rendez-vous des patients et d'envoyer rapidement les résultats.<br>
                En plus de cela, notre système de tarification <strong>transparent</strong> prévoit des frais de
                rendez-vous de <strong>8%</strong> pour les consultations au laboratoire et de <strong>10%</strong> pour
                les consultations à domicile,<br>
                offrant ainsi une solution <strong>rentable</strong> et <strong>pratique</strong> pour les laboratoires
                de toutes tailles. <br>
                Rejoignez-nous dès aujourd'hui pour simplifier la gestion de votre laboratoire et offrir une expérience
                <strong>optimale</strong> à vos patients.
            </p>

        </div>


    </section>
    <script>
        $(document).ready(function () {
            $(".open-rdv").on("click", function () {
                var laboID = $(this).data("labo-id");
                console.log(laboID)
                $.ajax({
                    type: "POST",
                    url: "<?php echo $_SERVER['PHP_SELF']; ?>",
                    data: {
                        sendId: true, labo_ID: laboID,
                    },
                    success: function (response) {
                        // Handle the response if needed
                    },
                    error: function (xhr, status, error) {
                        console.error("Error:", error);
                    }
                });
                $('#exampleModal').modal('show');
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>
</body>

</html>