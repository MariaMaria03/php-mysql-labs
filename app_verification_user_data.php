<!DOCTYPE html>
<html>
  <head>
    <title>������������� �����������</title>
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
          <button type="submit" name='log_out' value='�����' class="btn btn-default" id="log-out">
              ����� <span class="glyphicon glyphicon-log-out"></span>
          </button>
      </form>

      <h3 class="h3-lab2">���������� ����� �� �������� �.���</h3>
      <button type="button" class="btn btn-labeled btn-default" id="back-main" onclick="location.href='./app_main.php'">
          ��������� �� �������
      </button>

    <?php
        $all_new_users = MySQL_query("SELECT login, first_name, last_name, middle_name, birth_date, email, category
                                    FROM users
                                    WHERE users.status_user = 'consideration'");

          $check_present = mysql_num_rows($all_new_users);
          if ($check_present != 0) {
            echo '<h3 class="tournaments">���������������� ��������������� ������</h3>';
            echo '<table align="center" class="table table-bordered" id="table-proposal">
                            <thead>
                                <th class="users-admin">�����</th> 
                                <th class="users-admin">�������</th>
                                <th class="users-admin">���</th>
                                <th class="users-admin">��������</th>
                                <th class="users-admin">���� ��������</th>
                                <th class="users-admin">����������� �����</th>
                                <th class="users-admin">���������</th>
                                <th class="users-admin">�������</th>
                            </thead>';
            while ($user = MySQL_fetch_array($all_new_users)) {
                switch ($user['category']) {
                    case 'coach':
                        $category = '������';
                        break;
                    case 'manager':
                        $category = '�����������';
                        break;
                }
                echo " 
                    <tr class='users-admin'> 
                        <td>".$user['login']."</td>
                        <td>".$user['last_name']."</td>
                        <td>".$user['first_name']."</td>
                        <td>".$user['middle_name']."</td>
                        <td>".$user['birth_date']."</td>
                        <td>".$user['email']."</td> 
                        <td>".$category."</td>
                        <td>
                            <form method='post'>
                              <button class='btn btn-default'>
                                <a href='app_decision_new_user.php?new_login=".$user['login']."&decision=ok_user'>�����������</a>
                              </button>
                              <button class='btn btn-default'>
                                  <a href='app_decision_new_user.php?new_login=".$user['login']."&decision=no_user'>���������</a>
                              </button>
                          </form>
                                </td> 
                    </tr> ";
            }
            echo "</table>";
        }
        else {
            echo '<h3 class="tournaments">��������������� ������ �� �������� � ������������� ���� ���.</h3>';
        }
    ?>
          
  </body>
</html>
