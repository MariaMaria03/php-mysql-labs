<!DOCTYPE html>
<html>
  <head>
    <title>Заявка на турнир</title>
    <link rel='stylesheet' type='text/css' href='styles.css'/>
    <link rel='stylesheet' href='bootstrap/css/bootstrap.min.css' type='text/css'>
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </head>
  <body class="lab2-background">
        <h3 class="h3-lab2">Спортивная школа по плаванию г.Уфа</h3>

    <?php
        include ('app_db_settings.php');
        session_start();

        if (isset($_SESSION['log'])) {
            $user_log = $_SESSION['log'];
            $user = MySQL_query("SELECT first_name, last_name, middle_name, id FROM users WHERE login = '$user_log'");
            $data_athlete = MySQL_fetch_array($user);
            $tournaments_sql = MySQL_query("SELECT name, id FROM tournaments WHERE status = 'expected'");

            if (isset($_POST['proposal'])){
                $tournament_id = $_POST['tournament'];
                $user_id = $data_athlete['id'];
                $check = MySQL_query("SELECT * FROM members WHERE user_id = '$user_id' AND tournament_id = '$tournament_id'");
                if (mysql_num_rows($check) == 0) {
                    $proposal = MySQL_query("INSERT INTO members (user_id, tournament_id, status) VALUES ('$user_id', '$tournament_id', 'consideration') ");
                    if (isset($proposal)) {
                        echo '<h3 class="tournaments">Заявка отправлена! Организатор ее рассмотрит, результаты можно
                                                    посмотреть в разделе "Календарь ваших выступлений"</h3>';
                    }
                }
                else {
                    echo '<h3 class="tournaments">Заявка уже была отправлена ранее. Организатор рассмотрит вашу заявку.</h3>';
                }
            }
        }
        else {
            echo '<h3 class="tournaments">Авторизуйтесь!</h3>';
        }
    ?>

        <button type="button" class="btn btn-labeled btn-default" id="back-main" onclick="location.href='./app_main.php'">
            Вернуться на главную
        </button>

        <div class="panel panel-info" id="form-proposal">
            <div class="panel-heading">
                <h3 class="h3-lab2">Подача заявки на турнир</h3>
            </div>
            <form method='POST' action='' >
                <div class="panel-body">
                    <div class="input-group" id="tournament-select">
                        <?php
                            echo '<label>Ваше имя: '.$data_athlete['last_name'].' '.$data_athlete['first_name'].' '.$data_athlete['middle_name'].'
                            </label></br>';
                        ?>
                    </div>
                        <?php
                            echo '<table><tr>
                                    <td class="label-tour">Турнир: </td>';
                                echo '<td><select class="form-control" required autofocus name="tournament">';
                                while($tournament = MySQL_fetch_array($tournaments_sql)) {
                                    echo '<option value="'.$tournament['id'].'">'.$tournament['name'].'</option>';
                                }
                                echo '</select></td>';
                            echo '</tr></table>';
                        ?>
                </div>

                <div class="panel-footer">
                    <div class="row" id="enter">
                        <input type="submit" class="btn btn-labeled btn-success" value="Отправить заявку" name="proposal">
                </div>
            </form>
        </div>
  </body>
</html>
