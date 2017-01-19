<!DOCTYPE html>
<html>
  <head>
    <title>Заявки</title>
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
        $all_proposal = MySQL_query("SELECT members.id, tournaments.name AS tour_name, tournaments.date_start AS date_start,
                                    concat(users.last_name, ' ', users.first_name, ' ', users.middle_name) AS full_name
                                    FROM ((members
                                    LEFT OUTER JOIN users on members.user_id = users.id)
                                    LEFT OUTER JOIN tournaments on members.tournament_id = tournaments.id)
                                    WHERE members.status = 'consideration'");

          $check_present = mysql_num_rows($all_proposal);
          if ($check_present != 0) {
            echo '<h3 class="tournaments">Непросмотренные заявки</h3>';
            echo '<table align="center" class="table table-bordered" id="table-proposal">
                            <thead>
                                <th class="users-admin">ФИО спортсмена</th> 
                                <th class="users-admin">Наименование турнира</th>
                                <th class="users-admin">Дата начала турнира</th>
                                <th class="users-admin">Решение</th>
                            </thead>';
            while ($proposal = MySQL_fetch_array($all_proposal)) {
                echo " 
                    <tr class='users-admin'> 
                        <td>".$proposal['full_name']."</td>
                        <td>".$proposal['tour_name']."</td>
                        <td>".$proposal['date_start']."</td> 
                        <td>
                            <form method='post'>
                              <button class='btn btn-default'>
                                <a href='app_decision_proposal.php?member_id=".$proposal['id']."&decision=ok_proposal'>Принять заявку</a>
                              </button>
                              <button class='btn btn-default'>
                                  <a href='app_decision_proposal.php?member_id=".$proposal['id']."&decision=no_proposal'>Отклонить заявку</a>
                              </button>
                          </form>
                                </td> 
                    </tr> ";
            }
            echo "</table>";
        }
        else {
            echo '<h3 class="tournaments">Заявок от спортсменов пока нет.</h3>';
        }


    ?>
      

          
  </body>
</html>
