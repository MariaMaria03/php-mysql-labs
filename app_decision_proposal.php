<!DOCTYPE html>
<html>
    <head>
        <title>������</title>
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

            echo '<h3 class="h3-lab2">���������� ����� �� �������� �.���</h3>';
            echo '<form method="post">
                    <button type="submit" name="log_out" value="�����" class="btn btn-default" id="log-out">
                        ����� <span class="glyphicon glyphicon-log-out"></span>
                    </button>
                 </form>';

            if (isset($_SESSION['log'])) {
                $member_id = $_GET['member_id'];
                $member = MySQL_query("SELECT tournaments.name AS tour_name, 
                                      concat(users.last_name, ' ', users.first_name, ' ', users.middle_name) AS full_name 
                                      FROM ((members
                                        LEFT OUTER JOIN users on members.user_id = users.id)
                                        LEFT OUTER JOIN tournaments on members.tournament_id = tournaments.id) WHERE members.id = '$member_id'");
                $data_member = MySQL_fetch_array($member);
                $decision = $_GET['decision']; 

                if ($decision == 'ok_proposal') {
                    echo '<h5 id="block-user">�� ������������� ������ �� ������ " '.$data_member['tour_name'].'" �� ���������� '.$data_member['full_name'].'.</h5>';
                    echo "
                     <form method='post'>
                        <div id='block-user'>
                         <button type='submit' name='ok_proposal'  class='btn btn-default'>
                                ������ ���������� � ������ ����������
                            </button>
                        </div>
                    </form>";
                }
                if ($decision == 'no_proposal') {
                    echo '<h5 id="block-user">�� ���������� ������ �� ������ " '.$data_member['tour_name'].'" �� ���������� '.$data_member['full_name'].'.</h5>';
                    echo "
                     <form method='post'>
                        <div id='block-user'>
                            <button type='submit' name='no_proposal'  class='btn btn-default'>
                                ��������� ������
                            </button>
                        </div>
                    </form>";
                }

                if (isset($_POST['ok_proposal'])) {
                    $change_status = MySQL_query("UPDATE members SET status = 'confirmed' WHERE id = '$member_id'");
                    if (isset($change_status)) {
                        echo '<h4 id="block-user">������ ������������!</h4>';
                    }
                    else {
                        echo '<h3 id="block-user">������ �� ������������. ���-�� ����� �� ���.</h3>';
                    }
                }

                if (isset($_POST['no_proposal'])) {
                    $change_status = MySQL_query("UPDATE members SET status = 'rejected' WHERE id = '$member_id'");
                    if (isset($change_status)) {
                        echo '<h3 id="block-user">������ ���������!</h3>';
                    }
                    else {
                        echo '<h3 id="block-user">������ �� ���������. ���-�� ����� �� ���.</h3>';
                    }
                }
            }
            else {
                echo '� ��� ������������ ����!';
            }

            echo '<button type="button" class="btn btn-default" onclick="location.href=\'./app_main.php\'" style="text-align: center;">
                     ��������� �� �������
                 </button>';
        ?>
    </body>
</html>
