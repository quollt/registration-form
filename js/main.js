///////////////////////////////////////////////             авторизация
$('.loginButton').click(function(e){

 e.preventDefault();

    $(`input`).removeClass('error');
    $('.errFieldMsg').html('').css('color', 'red');

  let login = $('input[name="login"]').val();
  let password = $('input[name="password"]').val();

$.ajax({
  url: 'signin.php',
  type: 'POST',
  dataType: 'json',
  data: {
    login: login,
    password: password
  },
success (data) {


  if (data.status == true) {
    document.location.href = 'profile.php';
  } else {
      if (data.type === 1) {
        //check fields errors if exists
          data.fields.forEach(function(field){
            $(`input[name="${field}"]`).addClass('error');
        });
        switch (data.type === 1) {
          case ((data.errorOfFields).includes("loginEmpty")):
            $('#errorLogin').html("Введите логин").css('color', 'red');
            break;
          case ((data.errorOfFields).includes("passwordEmpty")):
            $('#errorPassword').html("Введите пароль").css('color', 'red');
            break;
          default:
            $('.errFieldMsg').html('').css('color', 'red');
            }

      }

      $('.msg').removeClass('none').text(data.message);
    }

  }
});
});

//////////////////////////////////////////////              регистрация

$('.RegisterButton').click(function(e){

 e.preventDefault();

    $(`input`).removeClass('error');
    $('.errFieldMsg').html('').css('color', 'red');

  let login = $('input[name="login"]').val();
  let password = $('input[name="password"]').val();
  let repassword = $('input[name="repassword"]').val();
  let email = $('input[name="email"]').val();
  let name = $('input[name="name"]').val();

$.ajax({
  url: 'signup.php',
  type: 'POST',
  dataType: 'json',
  data: {
    login: login,
    password: password,
    repassword: repassword,
    email: email,
    name: name
    },
  success (data) {

  if (data.status == true) {
    document.location.href = 'index.php';

  } else {
      if (data.type === 1) {
        //check fields errors if exists
        data.fields.forEach(function(field){
            $(`input[name="${field}"]`).addClass('error');
          });

        switch (data.type === 1) {
          case ((data.errorOfFields).includes("loginEmpty")):
            $('#errorLogin').html("Введите логин").css('color', 'red');
            break;
          case ((data.errorOfFields).includes("loginInvalid")):
            $('#errorLogin').html("Неверный логин, используйте A-Z, 0-9, минимум 6 максимум 20 знаков").css('color', 'red');
            break;
          case ((data.errorOfFields).includes("loginExists")):
            $('#errorLogin').html("Такой логин уже существует").css('color', 'red');
            break;
          case ((data.errorOfFields).includes("passwordEmpty")):
              $('#errorPassword').html("Введите пароль").css('color', 'red');
              break;
          case ((data.errorOfFields).includes("passwordinvalid")):
              $('#errorPassword').html("Используйте A-Z, 0-9, минимум 6 максимум 20 знаков").css('color', 'red');
              break;
          case ((data.errorOfFields).includes("emailInvalid")):
              $('#errorEmail').html("Неверный Email").css('color', 'red');
              break;
          case ((data.errorOfFields).includes("emailExists")):
              $('#errorEmail').html("Такой Email уже используется").css('color', 'red');
              break;
          case ((data.errorOfFields).includes("nameEmpty")):
              $('#errorName').html("Введите имя").css('color', 'red');
              break;
          case ((data.errorOfFields).includes("nameInvalid")):
              $('#errorName').html("Некорректное имя, используйте A-Z, А-Я").css('color', 'red');
              break;
          default:
            $('.errFieldMsg').html('').css('color', 'red');
          }

      }



     $('.msg').removeClass('none').text(data.message);
    }
//  alert("success");
  }
});
});
