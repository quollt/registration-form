<?php
session_start();

$salt = "123456789abc";
$login = $_POST['login'];
$password = $_POST['password'];
$errors = [];
$errorOfFields = [];
$readjsonArray = [];

/// проверка заполнения полей ///
if ($login === '') {
    $errors[] = 'login';
    $errorOfFields[] = 'loginEmpty';
} else {
  $errorOfFields = array_diff($errorOfFields, ["loginEmpty"]);
}

if ($password === '') {
  $errors[] = 'password';
  $errorOfFields[] = 'passwordEmpty';
} else {
  $errorOfFields = array_diff($errorOfFields, ["passwordEmpty"]);
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

///   поиск в json ///
/////////////////////////////////
if(file_exists('db.json')){
  $readjson = file_get_contents('db.json');
  $readjsonArray = json_decode($readjson, true);
}

////   функция поиска в массиве ////
function findArray ($array, $findValue, $executeKeys){
  $result = array();

  foreach ($array as $key => $value) {
    if (is_array($array[$key])) {
      $second_result = findArray ($array[$key], $findValue, $executeKeys);
      $result = array_merge($result, $second_result);
      continue;
    }
    if ($value === $findValue) {
      foreach ($executeKeys as $val){
        $result[] = $array[$val];
      }
    }
  }
   return $result;
}

$checkuser_json = findArray($readjsonArray, $login, ['login', 'password', 'email', 'name']);

if (in_array($login, $checkuser_json) && in_array($password, $checkuser_json)) {
  $loginExists = '1';


  $_SESSION['user'] = [
    "login" => $checkuser_json['0'],
    "email" => $checkuser_json['2'],
    "name" => $checkuser_json['3'],
  ];

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
