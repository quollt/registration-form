<?php

session_start();

$login = htmlspecialchars(trim($_POST['login']));
$password = trim($_POST['password']);
$repassword = trim($_POST['repassword']);
$email = htmlspecialchars(trim($_POST['email']));
$name = htmlspecialchars(trim($_POST['name']));


$loginExists = '';
$emailExists = '';
$errors = [];
$errorOfFields = [];
$readjsonArray = [];

///   поиск в json //////////
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
////////////////

$checklogin_json = findArray($readjsonArray, $login, ['login']);
$checkemail_json = findArray($readjsonArray, $email, ['email']);

if (in_array($login, $checklogin_json)) {
  $loginExists = '1';
} else if (in_array($email, $checkemail_json)){
  $emailExists = '1';
}

/////////// проверка на правитьность заполнения ////////////
/////////////     check login//////////////
if ($login === '') {
    $errors[] = 'login';
    $errorOfFields[] = 'loginEmpty';
    $errorOfFields = array_diff($errorOfFields, ["loginInvalid"]);
    $errorOfFields = array_diff($errorOfFields, ["loginExists"]);
  } else if(!preg_match("/^[a-z0-9]{6,20}$/i", $login)) {
    $errors[] = 'login';
    $errorOfFields[] = 'loginInvalid';
    $errorOfFields = array_diff($errorOfFields, ["loginEmpty"]);
    $errorOfFields = array_diff($errorOfFields, ["loginExists"]);
    } else if ($loginExists > 0) {
    $errors[] = 'login';
    $errorOfFields[] = 'loginExists';
    $errorOfFields = array_diff($errorOfFields, ["loginEmpty"]);
    $errorOfFields = array_diff($errorOfFields, ["loginInvalid"]);
  } else {
    $errorOfFields = array_diff($errorOfFields, ["loginEmpty"]);
    $errorOfFields = array_diff($errorOfFields, ["loginInvalid"]);
    $errorOfFields = array_diff($errorOfFields, ["loginExists"]);
    }
/////////////     check password//////////////

if ($password === '') {
  $errors[] = 'password';
  $errorOfFields[] = 'passwordEmpty';
  $errorOfFields = array_diff($errorOfFields, ["passwordinvalid"]);
} else if(!preg_match("/^[a-z0-9]{6,20}$/i", $password)) {
  $errors[] = 'password';
  $errorOfFields[] = 'passwordinvalid';
  $errorOfFields = array_diff($errorOfFields, ["passwordEmpty"]);
} else {
  $errorOfFields = array_diff($errorOfFields, ["passwordEmpty"]);
  $errorOfFields = array_diff($errorOfFields, ["passwordinvalid"]);
  }

  if ($repassword === '') {
    $errors[] = 'repassword';
  }

////////////////     check email /////////////////

if ($email === '' || (!preg_match("/^([a-z0-9_-]+\.)*[a-z0-9_-]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,6}$/", $email))){
  $errors[] = 'email';
  $errorOfFields[] = 'emailInvalid';
  $errorOfFields = array_diff($errorOfFields, ["emailExists"]);
} else if ($emailExists > 0) {
  $errors[] = 'email';
  $errorOfFields[] = 'emailExists';
  $errorOfFields = array_diff($errorOfFields, ["emailInvalid"]);
} else {
  $errorOfFields = array_diff($errorOfFields, ["emailInvalid"]);
  $errorOfFields = array_diff($errorOfFields, ["emailExists"]);
}

///////////////////////////       check name //////////////////////

if ($name === '') {
  $errors[] = 'name';
  $errorOfFields[] = 'nameEmpty';
  $errorOfFields = array_diff($errorOfFields, ["nameInvalid"]);
} else if (!preg_match("/^[a-zA-Zа-яА-яёЁ]{2,20}$/i", $name)) {
  $errors[] = 'name';
  $errorOfFields[] = 'nameInvalid';
  $errorOfFields = array_diff($errorOfFields, ["nameEmpty"]);
} else {
  $errorOfFields = array_diff($errorOfFields, ["nameInvalid"]);
  $errorOfFields = array_diff($errorOfFields, ["nameEmpty"]);
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
//password + salt

if ($password === $repassword) {

$salt = "123456789abc";
$user_password = md5($password . $salt);

$response = [
  "status" => true,
  "message" => "Registration success!",
];
echo json_encode($response);

///////////////////  добавление пользователя в JSON DB //////////////////////

$dbcontent = ['login' => $login, 'password' => $user_password, 'email' => $email, 'name' => $name];

//read file
$jsonArray = [];
  if(file_exists('db.json')){
    $json = file_get_contents('db.json');
   $jsonArray = json_decode($json, true);
  }
//write file
if ($dbcontent) {
  $jsonArray[] = $dbcontent;
file_put_contents('db.json', json_encode($jsonArray, JSON_FORCE_OBJECT));
}


} else {
  $response = [
    "status" => false,
    "message" => 'Пароли не совпадают!',
  ];

  echo json_encode($response);
}

?>
