<!DOCTYPE html>
<html>
  <head>
    <title>Выступления</title>
    <link rel='stylesheet' type='text/css' href='styles.css'/>
    <link rel='stylesheet' href='bootstrap/css/bootstrap.min.css' type='text/css'>
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </head>
  <body class="lab2-background">
      <?php
          session_start();
          include ('app_db_settings.php');
          $user_log = $_SESSION['log'];
          $user_sql = MySQL_query("SELECT  concat(users.last_name, ' ', users.first_name, ' ', users.middle_name) AS full_name
                                    FROM users WHERE login = '$user_log'");
          $user = MySQL_fetch_array($user_sql);

          if (isset($_POST['log_out'])) {
              unset($_SESSION['log']);
              echo '<META HTTP-EQUIV="Refresh" content="0; URL=app_welcome.php">';
          }
      ?>

      <form method='post'>
          <button type="submit" name='log_out' value='Выйти' class="btn btn-default" id="log-out">
              Выйти <span class="glyphicon glyphicon-log-out"></span>
          </button>
      </form>

      <h3 class="h3-lab2">Спортивная школа по плаванию г.Уфа</h3>
      <button type="button" class="btn btn-labeled btn-default" id="back-main" onclick="location.href='./app_main.php'">
          Вернуться на главную
      </button>

    <?php
        $all_part = MySQL_query("SELECT tournaments.name AS tour_name, members.place, members.status, concat(users.last_name, ' ', users.first_name, ' ', users.middle_name) AS full_name
                                        FROM ((members
                                        LEFT OUTER JOIN users on members.user_id = users.id)
                                        LEFT OUTER JOIN tournaments on members.tournament_id = tournaments.id)
                                        WHERE login = '$user_log'");
        if (mysql_num_rows($all_part) != 0) {
            echo '<h3 class="tournaments">Вы ('.$user['full_name'].') участвовали или подавали заявки на следующие турниры:</h3>';
            echo '<table align="center" class="table table-bordered" id="table-proposal">
                    <thead>
                        <th class="users-admin">Наименование</th>
                        <th class="users-admin">Статус заявки</th>
                        <th class="users-admin">Результат</th>
                    </thead>';

            while ($participation = MySQL_fetch_array($all_part)) {
                switch ($participation['status']) {
                    case 'consideration':
                        $status = 'На рассмотрении';
                        break;
                    case 'confirmed':
                        $status = 'Принята';
                        break;
                    case 'rejected':
                        $status = 'Отклонена';
                        break;
                }
                switch ($participation['place']) {
                    case 1:
                        $place = '1 место. поздравляем!';
                        break;
                    case 2:
                        $place = '2 место, поздравляем!';
                        break;
                    case 3:
                        $place = '3 место, поздравляем!';
                        break;
                    case '':
                        if ($participation['status'] == 'consideration') {
                            $place = 'Вы возможный участник';
                        }
                        elseif ($participation['status'] == 'confirmed') {
                            $place = 'Вы участник';
                        }
                        else {
                            $place = '';
                        }
                        break;
                }
                echo " 
                    <tr class='users-admin'> 
                        <td>".$participation['tour_name']."</td>
                        <td>".$status."</td>
                        <td>".$place."</td>
                    </tr> ";
            }
            echo "</table>";
        }
        else {
            echo '<h4 id="block-user">Вы ('.$user['full_name'].') пока не участвовали ни в одном турнире и не подавали заявки.</h4>';
        }
    ?>
  </body>
</html>
