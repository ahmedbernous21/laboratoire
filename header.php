<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
   <link rel="stylesheet" href="css\index.css">
</head>
<header>
   <a href="./" class="logo">LabsCo</a>
   <nav class="navigation">
    <?php
    session_start();
    $current_page = $_SERVER['REQUEST_URI'];
    $home_page = '/lab/';
    $is_home_page = ($current_page === $home_page);
    if (isset($_SESSION['name'])) {
      if ($is_home_page) {
         echo '<a href="#services">Laboratories</a>';
         echo '<a href="./rendezVous.php">Dashboard</a>';
     } else {
         echo '<a href="./">Laboratories</a>';
         echo '<a href="./">Mes tests</a>';
     }
      echo '<a href="./logout.php">logout</a>';
    } else {
      if ($is_home_page) {
         echo '<a href="#services">Laboratories</a>';
         echo '<a href="./randezVous.php">Dashboard</a>';
     } else {
         echo '<a href="./">Laboratories</a>';
         echo '<a href="./">Dashboard</a>';
     }   
        echo '<a href="./login.php">login</a>';
    }
    ?>
</nav>
</header>