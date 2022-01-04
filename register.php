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
<header>
</header>
 <body>
     <!-- Форма регистрации -->
     <div>
     <form>
     <label>Login</label><div id="errorLogin" class="errFieldMsg"></div>
     <input type="text" name="login" placeholder="Enter login">

     <label>Password</label><div id="errorPassword" class="errFieldMsg"></div>
     <input type="password" name="password" placeholder="Enter password">

     <label>Confirm password</label><div id="errorRepassword" class="errFieldMsg"></div>
     <input type="password" name="repassword" placeholder="Confirm password">

     <label>Email</label><div id="errorEmail" class="errFieldMsg"></div>
     <input type="text" name="email" placeholder="Enter email">

     <label>Name</label><div id="errorName" class="errFieldMsg"></div>
     <input type="text" name="name" placeholder="Enter name">
     <button type="submit" class="RegisterButton">Зарегистрироваться</button>

      <p>Есть аккаунт? - <a href="index.php">Авторизируйтесь</a></p>
      </form>
      <p class="msg none"></p>
     </div>

<script src="js/jquery-3.6.0.js"></script>
<script src="js/main.js"></script>

</body>
</html>
