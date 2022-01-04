<?php
session_start();
require "database.php";

$salt = "123456789abc";
$login = $_POST['login'];
$password = $_POST['password'];
$errors = [];
$errorOfFields = [];

///////// проверка заполнения полей ////////
if ($login === '') {
    $errors[] = 'login';
    $errorOfFields[] = 'loginEmpty';
}

if ($password === '') {
  $errors[] = 'password';
  $errorOfFields[] = 'passwordEmpty';
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

$password = md5($password . $salt);

///////////  проверка авторизации ////////
$dbjson = new dbjson();
$jsonContent = $dbjson -> readdb();
$userArray = $dbjson -> findArray($jsonContent, $login, ['login', 'password', 'email', 'name']);

if (in_array($login, $userArray) && in_array($password, $userArray)) {
      $loginExists = '1';
////    session
      $_SESSION['user'] = [
        "login" => $userArray['0'],
        "email" => $userArray['2'],
        "name" => $userArray['3'],
      ];

     setcookie("user_name", $userArray['3'], time() +600);

      $response = [
        "status" => true
      ];

      echo json_encode($response);

} else {
      $response = [
        "status" => false,
        "message" => 'Неверный логин или пароль'
      ];

      echo json_encode($response);
}

?>
