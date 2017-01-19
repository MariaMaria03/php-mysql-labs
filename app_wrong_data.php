<!DOCTYPE html>
<html>
  <head>
    <title>Личный кабинет</title>
    <link rel='stylesheet' type='text/css' href='styles.css'/>
    <link rel='stylesheet' href='bootstrap/css/bootstrap.min.css' type='text/css'>
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </head>
  <body class="lab2-background">
      <div class="alert alert-danger" role="alert" id="wrong-data">
          <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
          Логин или пароль введены неверно. Авторизация не пройдена.
          </br>
          <div class="enter-user">
              <button type="button" class="btn btn-default btn-lg" id="again-enter" onclick="location.href='./app_welcome.php'">
                  Попробовать еще раз
              </button>
          </div>

      </div>

  </body>
</html>
