<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=4, initial-scale=1.0">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

   <title>Profile</title>
</head>

<body>
   <?php
   include 'header.php';
   include 'connection.php';
   session_start();
   if (isset($_SESSION['user_id'])) {
      $user_id = $_SESSION['user_id'];
      $sql_user = "SELECT * FROM users WHERE id = '$user_id'";
      $result = $conn->query($sql_user);

      if (mysqli_num_rows($result) == 1) {
         $row = mysqli_fetch_assoc($result);
         $name = $row['nom'];
         $email = $row['email'];
         $labo_id = $row['id_labo'];
         $labo_query = "SELECT * FROM laboratoire WHERE id = '$labo_id'";
         $labo_result = $conn->query($labo_query);
         if (mysqli_num_rows($labo_result) == 1) {
            $labo_row = mysqli_fetch_assoc($labo_result);
            $emplacement = $labo_row['emplacement'];
            $phone = $labo_row['phone'];
            $horaires = $labo_row['horaires'];
         } else {
            $labo_name = "Unknown Lab";
         }
      } else {
         header("Location: login.php");
         exit;
      }
      if (isset($_POST["sendTest"]) != null && !empty($_POST["test"])) {
         $test = $_POST['test'];
         $price = $_POST['price'];
         $delay = $_POST['delay'];
         $details = $_POST['details'];
         $currentLabId = $labo_id;

         $sql_test = "INSERT INTO `testtype` (`id_labo`,`testName`, `details`, `price`, `delay`) VALUES ('$currentLabId','$test', '$details', '$price', '$delay');";
         $result = $conn->query($sql_test);
         if ($result == TRUE) {
            header("Location: " . $_SERVER['REQUEST_URI']);
         } else {
            echo "connection failed";
         }
         $conn->close();
      }
      if (isset($_POST['updateTest']) && !empty($_POST["test"])) {
         $testId = $_POST['testId'];
         $test = $_POST['test'];
         $price = $_POST['price'];
         $delay = $_POST['delay'];
         $details = $_POST['details'];
         $currentLabId = $labo_id;


         $update_sql = "UPDATE testtype SET testName = '$test', price = '$price', details = '$details', delay = '$delay' WHERE id = '$testId'";
         if ($conn->query($update_sql) === TRUE) {
            echo "Test updated successfully";
         } else {
            echo "Error updating test: " . $conn->error;
         }
      }
      if (isset($_POST['sendDelete'])) {
         $testId = mysqli_real_escape_string($conn, $_POST['testId']);
         $delete_sql = "DELETE FROM `testtype` WHERE `testtype`.`id` = '$testId';";
         $result = $conn->query($delete_sql);
         if ($result === TRUE) {
            echo "success";
         } else {
            echo "connection failed";
         }
      }
   } else {
      header("Location: login.php");
      exit;
   }

   ?>
   <section style="background-color: #eee;">
      <div class="container py-5 h-100">
         <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-md-12 col-xl-4">

               <div class="card" style="border-radius: 15px;">
                  <div class="card-body text-center">
                     <div class="mt-3 mb-4">
                        <img src="./image/laboratory.png" class="rounded-circle img-fluid" style="width: 100px;" />
                     </div>
                     <h4 class="mb-2"><?php echo $name ?></h4>
                     <p class="text-muted mb-4"><?php echo $email ?> <span class="mx-2">|</span> <a
                           href="#!"><?php echo $phone ?></a></p>
                     <div class="mb-2 pb-2">
                        <p><strong>Emplacement: </strong> <span><?php echo $emplacement ?></span></p>
                        <p><strong>Horaires: </strong> <span><?php echo $horaires ?></span></p>
                     </div>
                     <div class="mb-4">
                        <h4>Tests</h4>
                        <button type="button" class="btn btn-warning btn-sm mt-2 mb-3" data-bs-toggle="modal"
                           data-bs-target="#exampleModal">
                           <i class="fas fa-plus"></i>  Ajouter un test
                        </button>
                        <div class="accordion mt-2" id="testAccordion">
                           <?php
                           $sql_display = "SELECT * FROM `testtype` WHERE id_labo = '$labo_id' ";
                           $result = $conn->query($sql_display);
                           if ($result->num_rows > 0) {
                              while ($row = $result->fetch_assoc()) {
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
                                          <button type="button" class="btn btn-primary btn-sm mt-2 edit-test-btn"
                                             data-bs-toggle="modal" data-bs-target="#exampleModal"
                                             data-test-id="<?php echo $row['id']; ?>"
                                             data-test-name="<?php echo $row['testName']; ?>"
                                             data-test-price="<?php echo $row['price']; ?>"
                                             data-test-details="<?php echo $row['details']; ?>"
                                             data-test-delay="<?php echo $row['delay']; ?>">
                                             <i class="fas fa-edit"></i> Modifier ce test
                                          </button>

                                          <button type="button" class="btn btn-danger btn-sm mt-2 delete-test-btn"
                                             data-test-id="<?php echo $row['id']; ?>" name="sendDelete">
                                             <i class="fas fa-trash"></i> Supprimer ce test
                                          </button>

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

            </div>
         </div>
      </div>
   </section>
   <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel">Ajouter un test</h5>
            </div>
            <form action="" method="post">
               <input type="hidden" name="testId" id="testId" value="">
               <div class="modal-body">
                  <div class="input-group mb-4">
                     <div class="input-group-prepend">
                        <span class="input-group-text" id="">Le nom de test</span>
                     </div>
                     <input type="text" class="form-control" id="testName" name="test">
                  </div>
                  <div class="input-group mb-4">
                     <div class="input-group-prepend">
                        <span class="input-group-text" id="">Prix de test</span>
                     </div>
                     <input type="text" class="form-control" id="testPrice" name="price">
                  </div>
                  <div class="input-group mb-4">
                     <span class="input-group-text" id="">Détails de test</span>
                     <textarea class="form-control" id="testDetails" rows="3" name="details"></textarea>
                  </div>
                  <div class="input-group mb-4">
                     <div class="input-group-prepend">
                        <span class="input-group-text" id="">Délai de test</span>
                     </div>
                     <input type="text" class="form-control" id="testDelay" name="delay">
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary" value="Enregistrer" name="sendTest">Enregistrer</button>
            </form>
         </div>
      </div>
   </div>
   </div>
   </div>
   <script>
      $(document).ready(function () {
         $('.edit-test-btn').on('click', function () {
            var testId = $(this).data('test-id');
            var testName = $(this).data('test-name');
            var testPrice = $(this).data('test-price');
            var testDetails = $(this).data('test-details');
            var testDelay = $(this).data('test-delay');
            console.log(testId);
            $('#exampleModal').find('#testId').val(testId);
            $('#exampleModal').find('.modal-title').text('Modifier le test');
            $('#exampleModal').find('input[name="test"]').val(testName);
            $('#exampleModal').find('input[name="price"]').val(testPrice);
            $('#exampleModal').find('textarea[name="details"]').val(testDetails);
            $('#exampleModal').find('input[name="delay"]').val(testDelay);
            $('#exampleModal').find('.modal-footer button[type="submit"]').text('Modifier test');
            $('#exampleModal').find('.modal-footer button[type="submit"]').attr('name', 'updateTest');
         });
         $('#exampleModal').on('hidden.bs.modal', function () {
            // Clear modal fields
            $(this).find('.modal-title').text('Ajouter un test');
            $(this).find('input[name="test"]').val('');
            $(this).find('input[name="price"]').val('');
            $(this).find('textarea[name="details"]').val('');
            $(this).find('input[name="delay"]').val('');
            $(this).find('.modal-footer button[type="submit"]').text('Enregistrer');
            $(this).find('.modal-footer button[type="submit"]').attr('name', 'sendTest');
         });
         $('.delete-test-btn').on('click', function () {
            var testId = $(this).data('test-id');
            var confirmDelete = confirm("Are you sure you want to delete this test?");
            if (confirmDelete) {
               $.ajax({
                  method: 'POST',
                  url: '<?php echo $_SERVER['PHP_SELF']; ?>', // Send the request to the same page
                  data: {
                     sendDelete: true, // Indicate that this is a delete request
                     testId: testId
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