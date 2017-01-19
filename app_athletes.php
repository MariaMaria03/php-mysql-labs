<!DOCTYPE html>
<html>
  <head>
    <title>Все спортсмены</title>
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
        echo '<h3 class="tournaments">Все спортсмены</h3>';
        echo '<table align="center" class="table table-bordered" id="table-users">
                            <thead>
                                <th class="users-admin">Фамилия</th> 
                                <th class="users-admin">Имя</th>
                                <th class="users-admin">Отчество</th>
                                <th class="users-admin">Электронная почта</th>
                                <th class="users-admin">Дата рождения</th>
                                <th class="users-admin">Тренер</th>
                            </thead>';
        $all_athletes = MySQL_query("SELECT us_athlete.first_name, us_athlete.last_name, us_athlete.middle_name, us_athlete.email, us_athlete.birth_date,
                                      us_coach.last_name AS coach_last, us_coach.first_name AS coach_first, us_coach.middle_name AS coach_middle
                                     FROM users us_athlete, users us_coach
                                     WHERE us_athlete.category = 'athlete' AND us_coach.id = us_athlete.coach_id");
        while ($athlete = MySQL_fetch_array($all_athletes)) {
            echo " 
                                <tr class='users-admin'> 
                                    <td class='rows-users'>".$athlete['last_name']."</td>
                                    <td>".$athlete['first_name']."</td>
                                    <td>".$athlete['middle_name']."</td> 
                                    <td>".$athlete['email']."</td> 
                                    <td>".$athlete['birth_date']."</td>
                                    <td>".$athlete['coach_last']."  ".$athlete['coach_first']."  ".$athlete['coach_middle']."</td> 
                                    </tr> ";
        }
        echo "</table>";
    ?>
      

          
  </body>
</html>
