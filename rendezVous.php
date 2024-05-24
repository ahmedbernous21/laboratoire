<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/threeforms.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <title>Rendez vous</title>
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            margin-top: auto;
            margin-bottom: auto;

        }

        .title {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .rendezvous {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .edit-btn {
            margin-top: 10px;
        }

        .card {
            padding-top: 4em;
        }
    </style>
</head>

<body>
    <?php
    include "./connection.php";
    include "./header.php";
    ?>
    <div class="d-flex justify-content-center align-items-center min-vh-100">
        <div class="container mt-5">

            <?php
            $userId = $_SESSION['user_id'];
            $sql = "SELECT r.*, GROUP_CONCAT(t.testName SEPARATOR ', ') AS testNames
                FROM randezvous r
                LEFT JOIN rdv_tests rt ON r.id = rt.rdv_id
                LEFT JOIN testtype t ON rt.test_id = t.id
                WHERE r.user_id = $userId
                GROUP BY r.id";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                if (isset($_POST['updateRdv']) && !empty($_POST["date"])) {
                    $rdvId = $_POST['rdvId'];
                    $date = $_POST['date'];
                    $details = $_POST['details'];
                    $domicile = $_POST['domicile'];

                    $update_sql = "UPDATE randezvous SET `date` = '$date', `description` = '$details',`is_domicile` = '$domicile' WHERE id = '$rdvId'";
                    if ($conn->query($update_sql) === TRUE) {
                        header("Location: " . $_SERVER['REQUEST_URI']);
                    } else {
                        echo "Error updating test: " . $conn->error;
                    }
                }
                if (isset($_POST['sendDelete'])) {
                    $rdvId = mysqli_real_escape_string($conn, $_POST['rdvId']);
                    $delete_sql = "DELETE FROM `randezvous` WHERE `randezvous`.`id` = '$rdvId';";
                    $result = $conn->query($delete_sql);
                    if ($result === TRUE) {
                        header("Location: " . $_SERVER['REQUEST_URI']);
                    } else {
                        echo "connection failed";
                    }
                }
                while ($row = $result->fetch_assoc()) {
                    $labo_id = $row['labo_id'];
                    $sql_labo = "SELECT laboratoire.*, users.nom AS user_name 
                            FROM laboratoire 
                            INNER JOIN users ON laboratoire.id = users.id_labo 
                            WHERE laboratoire.id = $labo_id";
                    $result_labo = $conn->query($sql_labo);
                    $labo_name = $result_labo->fetch_assoc();
                    if ($result_labo->num_rows > 0) {
                        $labo_emplacement = $labo_name['emplacement'];
                        $labo_horaires = $labo_name['horaires'];
                        $labo_name = $labo_name['user_name'];
                    }
                    // retrieve test
                    ?>
                    <div class="card rendezvous border border-primary mt-4 w-100">
                        <div class="details-section">
                            <p><i class="fas fa-vial me-2"></i><strong>Nom du test:</strong>
                                <?php echo !empty($row['testNames']) ? $row['testNames'] : 'un autre test'; ?>
                            </p>
                            <p><i class="fas fa-building me-2"></i><strong>Nom du labo:</strong> <?php echo $labo_name; ?>
                            </p>
                            <p><i class="fas fa-map-marker-alt me-2"></i><strong>Emplacement du labo:</strong>
                                <?php echo $labo_emplacement; ?></p>
                            <p><i class="fas fa-clock me-2"></i><strong>Horaires du labo:</strong>
                                <?php echo $labo_horaires; ?></p>
                        </div>

                        <div class="date-section">
                            <p><i class="fas fa-calendar-alt me-2"></i><strong>La date du Rendez-vous:</strong>
                                <?php echo $row['date']; ?></p>
                            <p><i class="fas fa-map-marker-alt me-2"></i><strong>A domicile:</strong>
                                <?php echo $row['is_domicile'] === '1' ? "oui" : "non"; ?></p>
                        </div>

                        <div class="description-section">
                            <p><i class="fas fa-info-circle me-2"></i><strong>Détails de Rendez-vous:</strong>
                                <?php echo $row['description']; ?></p>
                        </div>

                        <div class="status-section">
                            <p><i class="fas fa-info-circle"></i> <strong>Statut:</strong>
                                <?php
                                $status = $row['status'];
                                $statusColor = '';
                                switch ($status) {
                                    case 'pending':
                                        $statusColor = 'orange';
                                        break;
                                    case 'finished':
                                        $statusColor = 'green';
                                        break;
                                    default:
                                        $statusColor = 'black';
                                        break;
                                }
                                echo "<span style='color: $statusColor;'><strong>$status</strong></span>";
                                ?>
                            </p>
                        </div>

                        <?php if ($row['status'] == 'unconfirmed') { ?>
                            <div class="d-flex justify-content-between">
                                <button class="btn btn-primary edit-rdv-btn" type="button" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal" data-rdv-id="<?php echo $row['id']; ?>"
                                    data-rdv-date="<?php echo $row['date']; ?>"
                                    data-rdv-details="<?php echo $row['description']; ?>"><i class="fas fa-pencil-alt me-1"></i>
                                    Modifier</button>
                                <button type="button" class="btn btn-danger mt-2 delete-rdv-btn"
                                    data-rdv-id="<?php echo $row['id']; ?>" name="sendDelete"><i class="fas fa-trash-alt me-1"></i>
                                    Supprimer</button>
                            </div>
                            <?php
                        } else {
                            $rdv_id = $row['id'];
                            $sql_result = "SELECT * FROM result WHERE `id_rdv` = $rdv_id";
                            $result_query = $conn->query($sql_result);

                            // Check if the fetch operation was successful
                            if ($result_query && $result_query->num_rows > 0) {
                                // Fetch the row from the result set
                                $row_result = $result_query->fetch_assoc();
                                ?>

                                <div class="d-flex justify-content-center">
                                    <div class="accordion" id="resultAccordion">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="resultHeading">
                                                <button class="accordion-button collapsed bg-primary" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#resultCollapse<?php echo $row['id']; ?>"
                                                    aria-expanded="false" aria-controls="resultCollapse<?php echo $row['id']; ?>">
                                                    View result
                                                </button>
                                            </h2>
                                            <div id="resultCollapse<?php echo $row['id']; ?>" class="accordion-collapse collapse"
                                                aria-labelledby="resultHeading"
                                                data-bs-parent="#resultAccordion<?php echo $row['id']; ?>">
                                                <div class="accordion-body">
                                                    <!-- Download button -->
                                                    <a href="data:image/jpeg;base64,<?php echo base64_encode($row_result['resultat']); ?>" download="payment_receipt.jpg" class="btn btn-secondary">Imprimer le résultat</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                    <?php
                }
            } else {
                echo "<div class='container'>";
                echo "<div class='title'>Aucun rendez-vous trouvé</div>";
                echo "</div>";
            }
            ?>
        </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Prendre un Rendez-vous
                    </h5>
                </div>
                <form action="" method="post">
                    <input type="hidden" name="rdvId" id="rdvId">
                    <div class="modal-body">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="">Date de test</span>
                            </div>
                            <input type="date" class="form-control" id="date" name="date">
                        </div>
                        <div class="input-group mb-4">
                            <span class="input-group-text" id="">Détails de test</span>
                            <textarea class="form-control" id="details" rows="3" name="details"></textarea>
                        </div>
                        <div class="mb-4">
                            <span class="input-group-text">Résultat à domicile</span>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="domicile" id="domicileYes" value="1">
                                <label class="form-check-label" for="domicileYes">Oui</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="domicile" id="domicileNo" value="0"
                                    checked>
                                <label class="form-check-label" for="domicileNo">Non</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary mx-4" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary" value="Enregistrer" name="updateRdv">Modifier le
                            Rendez-vous</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('.edit-rdv-btn').on('click', function () {
                var rdvId = $(this).data('rdv-id');
                var rdvDetails = $(this).data('rdv-details');
                var rdvDate = $(this).data('rdv-date');
                console.log(rdvId);
                $('#exampleModal').find('input[name="rdvId"]').val(rdvId);
                $('#exampleModal').find('input[name="date"]').val(rdvDate);
                $('#exampleModal').find('textarea[name="details"]').val(rdvDetails);
            });
            $('.delete-rdv-btn').on('click', function () {
                console.log("hey");
                var rdvId = $(this).data('rdv-id');
                var confirmDelete = confirm("Are you sure you want to delete this test?");
                if (confirmDelete) {
                    $.ajax({
                        method: 'POST',
                        url: '<?php echo $_SERVER['PHP_SELF']; ?>',
                        data: {
                            sendDelete: true,
                            rdvId: rdvId
                        },
                        success: function (response) {
                            location.reload();
                        },
                        error: function (xhr, status, error) {
                            console.error(error);
                        }
                    });
                }
            });

            // Print button functionality
            $('.print-btn').on('click', function () {
                var resultContent = $(this).data('result');
                var printWindow = window.open('', '_blank');
                printWindow.document.write('<html><head><title>Print Result</title></head><body>');
                printWindow.document.write('<h1>Test Result</h1>');
                printWindow.document.write('<p>' + resultContent + '</p>');
                printWindow.document.write('</body></html>');
                printWindow.document.close();
                printWindow.print();
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