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
    name: name,
  },
  success (data) {

  if (data.status) {
    document.location.href = 'index.php';

  } else {
      if (data.type === 1) {
        //check fields errors if exists
        data.fields.forEach(function(field){
            $(`input[name="${field}"]`).addClass('error');
          });

        switch (data.type === 1) {
          case ((data.errorOfFields).includes("loginEmpty")):
            $('#errorLogin').html("Enter login").css('color', 'red');
            break;
          case ((data.errorOfFields).includes("loginInvalid")):
            $('#errorLogin').html("Login invalid, use only A-Z 0-9, min 6 max 20 characters").css('color', 'red');
            break;
          case ((data.errorOfFields).includes("loginExists")):
            $('#errorLogin').html("login Exists !").css('color', 'red');
            break;
          case ((data.errorOfFields).includes("passwordEmpty")):
              $('#errorPassword').html("Password is Empty!").css('color', 'red');
              break;
          case ((data.errorOfFields).includes("passwordinvalid")):
              $('#errorPassword').html("Min 6 max 20 only a-z and 0-9").css('color', 'red');
              break;
          case ((data.errorOfFields).includes("emailInvalid")):
              $('#errorEmail').html("Email incorrect").css('color', 'red');
              break;
          case ((data.errorOfFields).includes("emailExists")):
              $('#errorEmail').html("Email already in used").css('color', 'red');
              break;
          case ((data.errorOfFields).includes("nameEmpty")):
              $('#errorName').html("Enter your name").css('color', 'red');
              break;
          case ((data.errorOfFields).includes("nameInvalid")):
              $('#errorName').html("Name is incorrect").css('color', 'red');
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
