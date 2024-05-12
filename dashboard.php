<!DOCTYPE html>
<bod lang="en">

   <head>
      <meta charset="UTF-8">
      <link rel="stylesheet" href="css/threeforms.css">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
         integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

      <title>Dashboard</title>
   </head>
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
            $sql = "SELECT r.id AS randezvous_id,r.*, u.* 
                FROM randezvous r
                INNER JOIN users u ON r.labo_id = u.id_labo
                WHERE u.id = $userId";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
               if (isset($_POST['sendResult'])) {
                  $rdvId = $_POST['rdvId'];
                  $results = $_POST['result'];

                  // Insert the result into the 'result' table
                  $insert_sql = "INSERT INTO `result` (`id_patient`, `id_labo`, `id_rdv`, `resultat`, `date_resultat`) 
                                 SELECT r.user_id, u.id_labo, r.id, '$results', NOW() 
                                 FROM randezvous r
                                 INNER JOIN users u ON r.labo_id = u.id_labo
                                 WHERE r.id = $rdvId";
                  $update_rdv = "UPDATE `randezvous` SET `status` = 'finished' WHERE `id` = $rdvId";
                  $result_rdv = $conn->query($update_rdv);

                  if ($conn->query($insert_sql) === TRUE) {
                        header("Location: " . $_SERVER['REQUEST_URI']);
                     } else {
                        echo "Error deleting appointment: " . $conn->error;
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
                  $test_id = $row['test_type'];
                  if ($test_id == "other") {
                     $testName = "Un autre test";
                  } else {
                     $sql_test = "SELECT * FROM testtype WHERE `id`= $test_id";
                     $result_test = $conn->query($sql_test);
                     $test_name = $result_test->fetch_assoc();
                     if ($result_test->num_rows > 0) {
                        $testName = $test_name['testName'];
                     } else {
                        $testName = "Test inconnu";
                     }
                  }
                  ?>
                  <div class="card rendezvous border border-primary mt-4 w-100">
                     <div class="details-section">
                        <p><i class="fas fa-vial me-2"></i><strong>Nom du test:</strong> <?php echo $testName; ?></p>
                        <p><i class="fas fa-user me-2"></i><strong>Nom du patient:</strong> <?php echo $row['nom']; ?></p>
                        <p><i class="fas fa-envelope me-2"></i><strong>Email du patient:</strong> <?php echo $row['email']; ?>
                        </p>

                        </p>
                     </div>

                     <div class="date-section">
                        <p><i class="fas fa-calendar-alt me-2"></i><strong>La date du Rendez-vous:</strong>
                           <?php echo $row['date']; ?></p>
                     </div>

                     <div class="description-section">
                        <p><i class="fas fa-info-circle me-2"></i><strong>Détails de Rendez-vous:</strong>
                           <?php echo $row['description']; ?></p>
                     </div>

                     <div class="status-section">
                        <p><i class="fas fa-info-circle me-1"></i> <strong>Statut:</strong>
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

                     <div class="d-flex justify-content-center">
                        <?php 
                        if($row['status'] == 'pending'){
                           ?>
                        <button class="btn btn-primary send-result-btn" type="button" data-bs-toggle="modal"
                           data-bs-target="#exampleModal" data-rdv-id="<?php echo $row['randezvous_id']; ?>"
                           data-rdv-date="<?php echo $row['date']; ?>"
                           data-rdv-details="<?php echo $row['description']; ?>"><i class="fas fa-poll-h"></i>
                           Envoyer les résultats</button>
                           <?php
                        }
                        ?>
                     </div>
                  </div>


                  <?php
               }
            } else {
               echo "No appointments found.";
            }
            ?>
         </div>
         <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
               <div class="modal-content">
                  <div class="modal-header">
                     <h5 class="modal-title" id="exampleModalLabel">Envoyer les résultats
                     </h5>
                  </div>
                  <form action="" method="post">
                     <input type="hidden" name="rdvId" id="rdvId">
                     <div class="modal-body">
                        <div class="input-group mb-4">
                           <span class="input-group-text" id="">résultat</span>
                           <textarea class="form-control" id="result" rows="3" name="result"></textarea>
                        </div>
                     </div>
                     <div class="modal-footer">
                        <button type="button" class="btn btn-secondary mx-4" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary" value="Enregistrer"
                           name="sendResult">Envoyer</button>
                     </div>
                  </form>
               </div>
            </div>
         </div>
         <script>
            $(document).ready(function () {
               $('.send-result-btn').on('click', function () {
                  var rdvId = $(this).data('rdv-id');
                  console.log(rdvId);
                  $('#exampleModal').find('input[name="rdvId"]').val(rdvId);
               });
            })
         </script>
         <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
            crossorigin="anonymous"></script>
         <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
            integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
            crossorigin="anonymous"></script>
   </body>

   </html>