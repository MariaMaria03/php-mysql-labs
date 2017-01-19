<!DOCTYPE html>
<html>
  <head>
    <title>����������</title>
    <link rel='stylesheet' type='text/css' href='styles.css'/>
    <link rel='stylesheet' href='bootstrap/css/bootstrap.min.css' type='text/css'>
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </head>
  <body class="lab2-background">
      <?php
          session_start();
          include ('app_db_settings.php');
          $tournament_id = $_GET['tour_id'];

          if (isset($_POST['log_out'])) {
              unset($_SESSION['log']);
              echo '<META HTTP-EQUIV="Refresh" content="0; URL=app_welcome.php">';
          }

      ?>

      <form method='post'>
          <button type="submit" name='log_out' value='�����' class="btn btn-default" id="log-out">
              ����� <span class="glyphicon glyphicon-log-out"></span>
          </button>
      </form>

      <h3 class="h3-lab2">���������� ����� �� �������� �.���</h3>
      <button type="button" class="btn btn-labeled btn-default" id="back-main" onclick="location.href='./app_main.php'">
          ��������� �� �������
      </button>

    <?php
        $tour_sql = MySQL_query("SELECT name FROM tournaments WHERE id = $tournament_id");
        $tour = MySQL_fetch_array($tour_sql);
        echo '<h3 class="tournaments">���������� �������: '.$tour['name'].'</h3>';
        echo '<table align="center" class="table table-bordered" id="table-proposal">
                    <thead>
                        <th class="users-admin">��� ����������</th> 
                        <th class="users-admin">�����</th>
                        <th class="users-admin">������</th>
                    </thead>';
        $all_place = MySQL_query("SELECT members.place, us_athlete.last_name, us_athlete.first_name, us_athlete.middle_name, 
                                                    us_coach.first_name AS coach_first, us_coach.last_name AS coach_last, us_coach.middle_name AS coach_middle
                                    FROM ((members, users us_coach
                                    LEFT OUTER JOIN users us_athlete on members.user_id = us_athlete.id)
                                    LEFT OUTER JOIN tournaments on members.tournament_id = tournaments.id)
                                    WHERE tournaments.status = 'completed' AND members.place IS NOT  NULL AND tournament_id = $tournament_id 
                                          AND us_coach.id = us_athlete.coach_id");
        while ($place = MySQL_fetch_array($all_place)) {
            echo " 
                    <tr class='users-admin'> 
                        <td>".$place['last_name']." ".$place['first_name']." ".$place['middle_name']."</td>
                        <td>".$place['place']."</td>
                        <td>".$place['coach_last']." ".$place['coach_first']." ".$place['coach_middle']."</td>
                    </tr> ";
        }
        echo "</table>";
    ?>
          
  </body>
</html>
