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

      $sql_result = MySQL_query("SELECT first_name, last_name, email, birth_date, us_coach.first_name
                                 FROM users us_athlete, users us_coach
                                 WHERE category = 'athlete' AND us_coach.id = us_athlete.coach_id");

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

    <?php
        $table = "<table>";
        while ($row = MySQL_fetch_array($sql_result))
        {
            $table .= "<tr>";
            $table .= "<td>".$row['last_name']."</td>";
            $table .= "<td>".$row['first_name']."</td>";
            $table .= "<td>".$row['email']."</td>";
            $table .= "</tr>";
        }
        $table .= "</table> ";
        echo $table;
    ?>
      

          
  </body>
</html>
