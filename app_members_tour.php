<!DOCTYPE html>
<html>
  <head>
    <title>���������</title>
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
        $all_members = MySQL_query("SELECT tournaments.name AS tour_name, members.place, concat(users.last_name, ' ', users.first_name, ' ', users.middle_name) AS full_name
                                        FROM ((members
                                        LEFT OUTER JOIN users on members.user_id = users.id)
                                        LEFT OUTER JOIN tournaments on members.tournament_id = tournaments.id)
                                        WHERE tournament_id = $tournament_id");
        if (mysql_num_rows($all_members) != 0) {
            echo '<h3 class="tournaments">��������� �������</h3>';
            echo '<table align="center" class="table table-bordered" id="table-proposal">
                    <thead>
                        <th class="users-admin">��� ����������</th> 
                    </thead>';

            while ($member = MySQL_fetch_array($all_members)) {
                echo " 
                    <tr class='users-admin'> 
                        <td>".$member['full_name']."</td>
                    </tr> ";
            }
            echo "</table>";
        }
        else {
            echo '<h4 id="block-user">���������� ���� ���.</h4>';
        }
    ?>
  </body>
</html>
