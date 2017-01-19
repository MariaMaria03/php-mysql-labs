<!DOCTYPE html>
<html>
  <head>
    <title>�����������</title>
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
          <button type="submit" name='log_out' value='�����' class="btn btn-default" id="log-out">
              ����� <span class="glyphicon glyphicon-log-out"></span>
          </button>
      </form>

      <h3 class="h3-lab2">���������� ����� �� �������� �.���</h3>
      <button type="button" class="btn btn-labeled btn-default" id="back-main" onclick="location.href='./app_main.php'">
          ��������� �� �������
      </button>

    <?php
        $all_part = MySQL_query("SELECT tournaments.name AS tour_name, members.place, members.status, concat(users.last_name, ' ', users.first_name, ' ', users.middle_name) AS full_name
                                        FROM ((members
                                        LEFT OUTER JOIN users on members.user_id = users.id)
                                        LEFT OUTER JOIN tournaments on members.tournament_id = tournaments.id)
                                        WHERE login = '$user_log'");
        if (mysql_num_rows($all_part) != 0) {
            echo '<h3 class="tournaments">�� ('.$user['full_name'].') ����������� ��� �������� ������ �� ��������� �������:</h3>';
            echo '<table align="center" class="table table-bordered" id="table-proposal">
                    <thead>
                        <th class="users-admin">������������</th>
                        <th class="users-admin">������ ������</th>
                        <th class="users-admin">���������</th>
                    </thead>';

            while ($participation = MySQL_fetch_array($all_part)) {
                switch ($participation['status']) {
                    case 'consideration':
                        $status = '�� ������������';
                        break;
                    case 'confirmed':
                        $status = '�������';
                        break;
                    case 'rejected':
                        $status = '���������';
                        break;
                }
                switch ($participation['place']) {
                    case 1:
                        $place = '1 �����. �����������!';
                        break;
                    case 2:
                        $place = '2 �����, �����������!';
                        break;
                    case 3:
                        $place = '3 �����, �����������!';
                        break;
                    case '':
                        if ($participation['status'] == 'consideration') {
                            $place = '�� ��������� ��������';
                        }
                        elseif ($participation['status'] == 'confirmed') {
                            $place = '�� ��������';
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
            echo '<h4 id="block-user">�� ('.$user['full_name'].') ���� �� ����������� �� � ����� ������� � �� �������� ������.</h4>';
        }
    ?>
  </body>
</html>
