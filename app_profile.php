<!DOCTYPE html>
<html>
<head>
    <title>��� �������</title>
    <link rel='stylesheet' type='text/css' href='styles.css'/>
    <link rel='stylesheet' href='bootstrap/css/bootstrap.min.css' type='text/css'>
    <script src="bootstrap/js/bootstrap.min.js"></script>
</head>
<body class="lab2-background">
    <h3 class="h3-lab2">���������� ����� �� �������� �.���</h3>

    <?php
        include ('app_db_settings.php');
        session_start();

        $login = $_SESSION['log'];
        $sql_res = MySQL_query("SELECT * FROM users WHERE login = '$login'");
        $user = MySQL_fetch_array($sql_res);
    ?>

    <div class="panel panel-info" id="form-registration">
        <div class="panel-heading">
            <h3 class="h3-lab2">������ ����� ��������</h3>
        </div>
            <div class="panel-body">
                <div class="input-group" id="data-account">
                    <h4 class="profile-header">�����: </h4>
                    <?php
                     echo '<h4 class="profile-data">'.$user['login'].'</h4>';
                    ?>
                </div>

                <div class="input-group" id="data-account">
                    <h4 class="profile-header">���: </h4>
                    <?php
                    echo '<h4 class="profile-data">'.$user['first_name'].'</h4>';
                    ?>
                </div>

                <div class="input-group" id="data-account">
                    <h4 class="profile-header">��������: </h4>
                    <?php
                    echo '<h4 class="profile-data">'.$user['middle_name'].'</h4>';
                    ?>
                </div>

                <div class="input-group" id="data-account">
                    <h4 class="profile-header">�������: </h4>
                    <?php
                    echo '<h4 class="profile-data">'.$user['last_name'].'</h4>';
                    ?>
                </div>

                <div class="input-group" id="data-account">
                    <h4 class="profile-header">����������� �����: </h4>
                    <?php
                    echo '<h4 class="profile-data">'.$user['email'].'</h4>';
                    ?>
                </div>

                <div class="input-group" id="data-account">
                    <h4 class="profile-header">���� ��������: </h4>
                    <?php
                    echo '<h4 class="profile-data">'.$user['birth_date'].'</h4>';
                    ?>
                </div>

                <div class="input-group" id="data-account">
                    <h4 class="profile-header">���������: </h4>
                    <?php
                        if ($user['category'] == 'coach') {
                            echo '<h4 class="profile-data">������</h4>';
                        }
                        elseif ($user['category'] == 'athlete') {
                            echo '<h4 class="profile-data">���������</h4>';
                        }
                        elseif ($user['category'] == 'manager') {
                            echo '<h4 class="profile-data">�����������</h4>';
                        }
                        elseif ($user['category'] == 'visitor') {
                            echo '<h4 class="profile-data">����������</h4>';
                        }
                        else {
                            echo '<h4 class="profile-data">�������������</h4>';
                        }
                    ?>
                </div>

                <div class="input-group" id="data-account">
                    <h4 class="profile-header">������: </h4>
                    <?php
                    echo '<h4 class="profile-data">'.$user['password'].'</h4>';
                    ?>
                </div>

            </div>
            <div class="panel-footer">
                <div class="row" id="enter">
                    <button type="button" class="btn btn-labeled btn-success" id="button-style" onclick="location.href='./app_main.php'">
                        �� �������
                    </button>
                </div>
            </div>
    </div>

</body>
</html>

