<?php
session_start();
session_destroy();
setcookie("user_name", null, time() -600);
header('Location: index.php');
 ?>
