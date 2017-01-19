<!DOCTYPE html>
<html>
    <head>
        <title>������� ��������������</title>
        <link rel='stylesheet' type='text/css' href='styles.css'/>
        <link rel='stylesheet' href='bootstrap/css/bootstrap.min.css' type='text/css'>
        <script src="bootstrap/js/bootstrap.min.js"></script>
    </head>
    <body class="lab2-background">

        <?php
            session_start();
            if (isset($_POST['log_out'])) {
                unset($_SESSION['log']);
                echo '<META HTTP-EQUIV="Refresh" content="0; URL=app_welcome.php">';
            }

            echo '<h3 class="h3-lab2">���������� ����� �� �������� �.���</h3>';

            echo '<form method="post">
                    <button type="submit" name="log_out" value="�����" class="btn btn-default" id="log-out">
                        ����� <span class="glyphicon glyphicon-log-out"></span>
                    </button>
                 </form>
                 <button type="button" class="btn btn-default" onclick="location.href=\'./app_main.php\'" id="block-user">
                     ��������� �� �������
                 </button>';

            include ('app_db_settings.php');
            if ($_SESSION['category'] == 'admin' && isset($_SESSION['log'])) {
                $user_id = $_GET['id'];
                $user_for_block = MySQL_query("SELECT first_name, last_name, block FROM users WHERE id = '$user_id'");
                $data = MySQL_fetch_array($user_for_block);
                $action = $_GET['action'];

                if ($action == 'block') {
                    $date = date("Y.m.d");
                    $block_user = MySQL_query("UPDATE users SET block = '$date' WHERE id = '$user_id'");
                    if (isset($block_user)) {
                            echo '<h3 id="block-user">������������: '.$data['first_name'].' '.$data['last_name'].' ������������!</h3>';
                        }
                        else {
                            echo '������������  �� ������������. ���-�� ����� �� ���.';
                        }
                }
                else {
                    $unblock_user = MySQL_query("UPDATE users SET block = NULL WHERE id = '$user_id'");
                        if (isset($unblock_user)) {
                            echo '<h3 id="block-user">�� �������������� ������������: '.$data['first_name'].' '.$data['last_name'].'</h3>';
                        }
                        else {
                            echo '������������  �� �������������. ���-�� ����� �� ���.';
                        }
                }
            }
            else {
                echo '� ��� ������������ ����!';
            }
        ?>
    </body>
</html>
