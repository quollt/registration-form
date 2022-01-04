<?php
     session_start();
     if ($_SESSION['user']) {
        header('Location: profile.php');
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
  <!-- форма авторизации -->
<div>
  <form>
          <label>Login</label><div id="errorLogin" class="errFieldMsg"></div>
          <input type="text" name="login" placeholder="Enter login">
          <label>Пароль</label><div id="errorPassword" class="errFieldMsg"></div>
          <input type="password" name="password" placeholder="Enter password">
          <button class="loginButton" type="submit">Войти</button>
          <p>У вас нет аккаунта? - <a href="register.php">Зарегистрируйтесь</a></p>
  </form>
          <p class="msg none"></p>
</div>
<script src="js/jquery-3.6.0.js"></script>
<script src="js/main.js"></script>
</body>
</html>
