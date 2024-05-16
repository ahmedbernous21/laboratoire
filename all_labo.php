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
   $userId = $_SESSION['user_id'];
   if (isset($_POST['addSubs'])) {
      $labo_id = $_POST['laboid'];
      $sql_rdv = "UPDATE `laboratoire` SET `is_paid` = '1', `payment_day` = NOW() WHERE `id` = $labo_id";
      $result_rdv = $conn->query($sql_rdv);

      if ($result_rdv == TRUE) {
         header("Location: " . $_SERVER['REQUEST_URI']);
      } else {
         echo "Une erreur s'est produite lors de l'enregistrement du rendez-vous.";
      }
      $conn->close();
   }
   if (isset($_POST['removeSubs'])) {
      $labo_id = $_POST['laboid'];
      $sql_rdv = "UPDATE `laboratoire` SET `is_paid` = '0', `payment_day` = NULL WHERE `id` = $labo_id";
      $result = $conn->query($sql_rdv);

      if ($result == TRUE) {
         header("Location: " . $_SERVER['REQUEST_URI']);
      } else {
         echo "Une erreur s'est produite lors de l'enregistrement du rendez-vous.";
      }
      $conn->close();
   }
   ?>

   <section class="cards" id="services">
      <div class="content">
         <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php
            $sql = "SELECT * FROM `laboratoire`";
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
                              <img src="./image/laboratory.png" class="rounded-circle img-fluid" style="width: 100px;" />
                           </div>
                           <h4 class="mb-2"><?php echo $username['nom']; ?></h4>
                           <p class="text-muted mb-4"><?php echo $username['email']; ?><span class="mx-2">|</span> <a
                                 href="#!"><?php echo $row['phone']; ?></a></p>
                           <div class="mb-2 pb-2">
                              <p><strong>Emplacement: </strong><span><?php echo $row['emplacement']; ?></span></p>
                              <p><strong>Horaires: </strong><span><?php echo $row['horaires']; ?></span></p>
                              <form action="" method="post">
                              <input type="hidden" name="laboid" value="<?php echo $laboId ?>">
                              <?php if (isset($row['recu']) && !isset($row['payment_day'])) { ?>
                                    <p><strong>paiement:
                                       </strong><?php echo '<img class="w-100" src="data:image/jpeg;base64,' . base64_encode($row['recu']) . '"/>'; ?>
                                       <button class="btn btn-success my-2" name="addSubs">Validate</button>
                                 <?php
                              }
                              if (isset($row['payment_day'])) {
                                 ?>
                                 <p><strong>paiement:
                                    </strong><?php echo '<img class="w-100" src="data:image/jpeg;base64,' . base64_encode($row['recu']) . '"/>'; ?>
                                    <button class="btn btn-danger my-2" name="removeSubs">Annuler abonnement</button>
                                 <p><strong>date de validation: </strong><span><?php echo $row['payment_day']; ?></span></p>
                                 <?php
                              }
                              ?>
                              </p>
                              </form>
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
                                          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                             data-bs-target="#collapse<?php echo $row['id'] ?>" aria-expanded="false"
                                             aria-controls="collapse<?php echo $row['id'] ?>">
                                             <?php echo $row['testName'] ?>
                                          </button>
                                       </h2>
                                       <div id="collapse<?php echo $row['id'] ?>" class="accordion-collapse collapse"
                                          aria-labelledby="heading<?php echo $row['id'] ?>" data-bs-parent="#testAccordion">
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
                        </div>
                     </div>
                  </div>
                  <?php
               }
            }

            ?>
         </div>
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