<!DOCTYPE html>
<html>
<head>
    <title>���������� ����� �� ��������</title>
    <link rel='stylesheet' type='text/css' href='styles.css'/>
    <script type="text/javascript" src="jquery-1.12.2.js"></script>
    <link rel='stylesheet' href='bootstrap/css/bootstrap.min.css' type='text/css'>
    <script src="bootstrap/js/bootstrap.min.js"></script>
</head>
<body class="lab2-background">
<h3 class="h3-lab2">���������� ����� �� �������� �.���</h3>
    <?php
        $today=date("d.m.y");
        echo "������� $today";
    ?>

    <?php
        session_start();

        if (isset($_SESSION) && array_key_exists('create_user', $_SESSION)) {
            echo '�� ����������������!';
        }

        if (isset($_POST['log_out'])) {
            unset($_SESSION['log']);
            echo '<META HTTP-EQUIV="Refresh" content="0; URL=app_welcome.php">';
        }
    ?>

    <form method='post'>
        <div class="row" id="enter">
            <input type="submit" name='log_out' value='�����' class="btn btn-default">
        </div>
    </form>


    <p>������������� ���� </p><a href="app_profile.php">�������</a>

</body>
</html>
