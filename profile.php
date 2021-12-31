<?php
     session_start();
     if (!$_SESSION['user']) {
        header('Location: index.php');
      }

 ?>
 <!doctype html>
 <html lang="en">
 <head>
     <meta charset="UTF-8">
     <link rel="stylesheet" href="css/main.css">
     <title>Profile</title>
 </head>
<header>
</header>
 <body>
<div><p><h3>Hello&nbsp;<? echo ($_SESSION['user']['name']);?></h3><p>

  <p>
    <h4><?=$_SESSION['user']['login'] ?> </h4><br>
    <h4><?=$_SESSION['user']['email'] ?> </h4><br>
    <h4><?=$_SESSION['user']['name'] ?> </h4><br>

    <h3><a href="logout.php">EXIT</a></h3>

  <p>


</div>
</body>
</html>
