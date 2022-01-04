<?php
     session_start();
     //session
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
 <body>
<div><p><h2>Hello&nbsp;<? echo $_COOKIE['user_name'];?></h2><p><hr>
  <p>
    <h4>Логин: <?=$_SESSION['user']['login'] ?> </h4><br>
    <h4>Email: <?=$_SESSION['user']['email'] ?> </h4><br>
    <h4>Имя: <?=$_SESSION['user']['name'] ?> </h4><br><hr>
    <a href="logout.php">Выйти</a>
  <p><a href="deleteuser.php">Удалить аккаунт</a></p>
</div>
</body>
</html>
