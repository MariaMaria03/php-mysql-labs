<!DOCTYPE html>
<html>
    <head>
        <title>Регистрация</title>
        <link rel='stylesheet' type='text/css' href='styles.css'/>
        <script type="text/javascript" src="jquery-1.12.2.js"></script>
        <link rel='stylesheet' href='bootstrap/css/bootstrap.min.css' type='text/css'>
        <script src="bootstrap/js/bootstrap.min.js"></script>
    </head>
    <body class="lab2-background">
    <h3 class="h3-lab2">Спортивная школа по плаванию г.Уфа</h3>
    <?php
    $today=date("d.m.y");
    echo "Сегодня $today";
    ?>
    
    <?php
    
    session_start();
    include ('app_db_settings.php');
    if ($_SESSION['id'] != 0) {
        echo 'Вы зарегистрированы!';
    }
    else {
        echo 'yfdgfgdf';
    }
    ?>
    
    </body>
</html>
