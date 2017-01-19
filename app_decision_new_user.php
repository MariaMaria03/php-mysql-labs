<!DOCTYPE html>
<html>
    <head>
        <title>Подтверждение регистрации</title>
        <link rel='stylesheet' type='text/css' href='styles.css'/>
        <link rel='stylesheet' href='bootstrap/css/bootstrap.min.css' type='text/css'>
        <script src="bootstrap/js/bootstrap.min.js"></script>
    </head>
    <body class="lab2-background">

        <?php
            session_start();
            include ('app_db_settings.php');
            if (isset($_POST['log_out'])) {
                unset($_SESSION['log']);
                echo '<META HTTP-EQUIV="Refresh" content="0; URL=app_welcome.php">';
            }

            echo '<h3 class="h3-lab2">Спортивная школа по плаванию г.Уфа</h3>';
            echo '<form method="post">
                    <button type="submit" name="log_out" value="Выйти" class="btn btn-default" id="log-out">
                        Выйти <span class="glyphicon glyphicon-log-out"></span>
                    </button>
                 </form>';

            if (isset($_SESSION['log'])) {
                $login_user = $_GET['new_login'];
                $user = MySQL_query("SELECT concat(users.last_name, ' ', users.first_name, ' ', users.middle_name) AS full_name 
                                      FROM users WHERE users.login = '$login_user'");
                $data_user = MySQL_fetch_array($user);
                $decision = $_GET['decision']; 

                if ($decision == 'ok_user') {
                    echo '<h5 id="block-user">Вы подтверждаете регистрирацию пользователя: '.$data_user['full_name'].'</h5>';
                    echo "
                     <form method='post'>
                        <div id='block-user'>
                         <button type='submit' name='ok_user'  class='btn btn-default'>
                                Зарегистрировать
                            </button>
                        </div>
                    </form>";
                }
                if ($decision == 'no_user') {
                    echo '<h5 id="block-user">Вы отклоняете регистрацию пользователя '.$data_user['full_name'].'</h5>';
                    echo "
                     <form method='post'>
                        <div id='block-user'>
                            <button type='submit' name='no_user'  class='btn btn-default'>
                                Отклонить региистрацию
                            </button>
                        </div>
                    </form>";
                }

                if (isset($_POST['ok_user'])) {
                    $change_status = MySQL_query("UPDATE users SET status_user = 'confirmed' WHERE login = '$login_user'");
                    if (isset($change_status)) {
                        echo '<h4 id="block-user">Регистрация подтверждена!</h4>';
                    }
                    else {
                        echo '<h3 id="block-user">Регистрация не подтверждена. Что-то пошло не так.</h3>';
                    }
                }

                if (isset($_POST['no_user'])) {
                    $change_status = MySQL_query("UPDATE users SET status_user = 'rejected' WHERE login = '$login_user'");
                    if (isset($change_status)) {
                        echo '<h3 id="block-user">Регистрация отклонена!</h3>';
                    }
                    else {
                        echo '<h3 id="block-user">Регистрация не отклонена. Что-то пошло не так.</h3>';
                    }
                }
            }
            else {
                echo 'У вас недостаточно прав!';
            }

            echo '<button type="button" class="btn btn-default" onclick="location.href=\'./app_main.php\'" style="text-align: center;">
                     Вернуться на главную
                 </button>';
        ?>
    </body>
</html>
