<!DOCTYPE html>
<html>
  <head>
    <title>Личный кабинет</title>
    <link rel='stylesheet' type='text/css' href='styles.css'/>
    <script type="text/javascript" src="jquery-1.12.2.js"></script>
    <link rel='stylesheet' href='bootstrap/css/bootstrap.min.css' type='text/css'>
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </head>
  <body class="lab2-background">
        <button type="button" class="btn btn-default" id="main-button" onclick="location.href='index.htm'">
          На персональную страницу студента
        </button>

        <h3 class="h3-lab2">Спортивная школа по плаванию г.Уфа</h3>
        <?php
          include('data_person.php'); 
          $today=date("d.m.y");
          echo "Сегодня $today";
        ?>


        <div class="panel panel-info" id="form-enter">
            <div class="panel-heading">
                <h3 class="h3-lab2"> Вход в личный кабинет</h3>
            </div>
            <form method='POST' action='authorization.php' >
                <div class="panel-body">
                    <div class="col-xs-3 col-sm-3 col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                            <input type="text" class="form-control" name="login" placeholder="Имя пользователя" required autofocus />
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                            <input type="password" class="form-control" name="password" placeholder="Ваш пароль" required />
                        </div>

                        <a href="#">Регистрация</a>
                    </div>

                </div>
                <div class="panel-footer">
                    <div class="row" id="enter">
                        <input type="submit" class="btn btn-labeled btn-success" value="Войти">
                    </div>
                </div>
            </form>
        </div>

        <?php
            session_start();
            if (!empty($_POST['login']) && !empty($_POST['password']))
            {
                $link = MySQL_connect('informatic.ugatu.ac.ru','sts402','40254');
                //$link = MySQL_connect('localhost','root');
                MySQL_select_db('sts402-9143', $link);
                $login = $_POST['login'];
                $password = $_POST['password'];
                $request = MySQL_query("SELECT login, password FROM users WHERE login='$login' AND password='$password'");
                if (mysql_num_rows($request) != 0) {
                    $result = MySQL_fetch_array($request);
                    $_SESSION['log'] = $result['login'];
                    echo '<META HTTP-EQUIV="Refresh" content="0; URL=admin_page.php">';
                }
                else {
                    echo '<META HTTP-EQUIV="Refresh" content="0; URL=wrong_data.php">';

                }
            }
        ?>

  </body>
</html>
