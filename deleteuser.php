<?php
session_start();
require "database.php";
$dbjson = new dbjson();
$dbjson-> delete_user($_SESSION['user']['login']);
unset($_SESSION['user']);
?>
 <!doctype html>
 <html lang="en">
 <head>
     <meta charset="UTF-8">
     <link rel="stylesheet" href="css/main.css">
     <title>Profile</title>
 </head>
 <body>
 <div>
  <p>
    <h4>Пользователь удален</h4><br>
    <h3><a href="index.php">главная</a></h3>
  <p><hr>
  </div>
</body>
</html>
