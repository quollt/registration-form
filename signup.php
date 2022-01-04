<?php

session_start();
require "database.php";

$login = htmlspecialchars(trim($_POST['login']));
$password = trim($_POST['password']);
$repassword = trim($_POST['repassword']);
$email = htmlspecialchars(trim($_POST['email']));
$name = htmlspecialchars(trim($_POST['name']));


$loginExists = '';
$emailExists = '';
$errors = [];
$errorOfFields = [];

//////////////// check login & email exists ///
$dbjson = new dbjson();
$jsonContent = $dbjson -> readdb();
$checkLoginExists = $dbjson -> findArray($jsonContent, $login, ['login']);
$checkEmailExists = $dbjson -> findArray($jsonContent, $email, ['email']);

if (in_array($login, $checkLoginExists)) {
  $loginExists = '1';
} else if (in_array($email, $checkEmailExists)){
  $emailExists = '1';
}

/////////// проверка на правитьность заполнения полей////////////

if ($login === '') {
    $errors[] = 'login';
    $errorOfFields[] = 'loginEmpty';
} else if(!preg_match("/^[a-z0-9]{6,20}$/i", $login)) {
    $errors[] = 'login';
    $errorOfFields[] = 'loginInvalid';
    } else if ($loginExists > 0) {
    $errors[] = 'login';
    $errorOfFields[] = 'loginExists';
}

if ($password === '') {
    $errors[] = 'password';
    $errorOfFields[] = 'passwordEmpty';
} else if(!preg_match("/^[a-z0-9]{6,20}$/i", $password)) {
    $errors[] = 'password';
    $errorOfFields[] = 'passwordinvalid';
}

if ($repassword === '') {
    $errors[] = 'repassword';
}

if ($email === '' || (!preg_match("/^([a-z0-9_-]+\.)*[a-z0-9_-]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,6}$/", $email))){
    $errors[] = 'email';
    $errorOfFields[] = 'emailInvalid';
} else if ($emailExists > 0) {
    $errors[] = 'email';
    $errorOfFields[] = 'emailExists';
}

if ($name === '') {
    $errors[] = 'name';
    $errorOfFields[] = 'nameEmpty';
} else if (!preg_match("/^[a-zA-Zа-яА-яёЁ]{2,20}$/i", $name)) {
    $errors[] = 'name';
    $errorOfFields[] = 'nameInvalid';
}


if (!empty($errors)) {
    $response = [
      "status" => false,
      "type" => 1,
      "fields" => $errors,
      "errorOfFields" => $errorOfFields,
    ];
    echo json_encode($response);
    die();
}
////password + salt
if ($password === $repassword) {

      $salt = "123456789abc";
      $user_password = md5($password . $salt);

      $response = [
        "status" => true,
        "message" => "Registration success!",
      ];
      echo json_encode($response);

      //// add user to database ///
      $dbcontent = ['login' => $login, 'password' => $user_password, 'email' => $email, 'name' => $name];

      $dbjson = new dbjson();
      $jsonContent = $dbjson -> readdb();
      $dbjson-> writedb($dbcontent, $jsonContent);

} else {
      $response = [
        "status" => false,
        "message" => 'Пароли не совпадают!',
      ];

      echo json_encode($response);
}

?>
