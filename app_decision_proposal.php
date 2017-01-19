<!DOCTYPE html>
<html>
    <head>
        <title>Заявка</title>
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

            echo '<h3 class="h3-lab2">Спортивная школа по плаванию г.Уфа</h3>';
            echo '<form method="post">
                    <button type="submit" name="log_out" value="Выйти" class="btn btn-default" id="log-out">
                        Выйти <span class="glyphicon glyphicon-log-out"></span>
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
                    echo '<h5 id="block-user">Вы подтверждаете заявку на турнир " '.$data_member['tour_name'].'" от спортсмена '.$data_member['full_name'].'.</h5>';
                    echo "
                     <form method='post'>
                        <div id='block-user'>
                         <button type='submit' name='ok_proposal'  class='btn btn-default'>
                                Внести спортсмена в список участников
                            </button>
                        </div>
                    </form>";
                }
                if ($decision == 'no_proposal') {
                    echo '<h5 id="block-user">Вы отклоняете заявку на турнир " '.$data_member['tour_name'].'" от спортсмена '.$data_member['full_name'].'.</h5>';
                    echo "
                     <form method='post'>
                        <div id='block-user'>
                            <button type='submit' name='no_proposal'  class='btn btn-default'>
                                Отклонить заявку
                            </button>
                        </div>
                    </form>";
                }

                if (isset($_POST['ok_proposal'])) {
                    $change_status = MySQL_query("UPDATE members SET status = 'confirmed' WHERE id = '$member_id'");
                    if (isset($change_status)) {
                        echo '<h4 id="block-user">Заявка подтверждена!</h4>';
                    }
                    else {
                        echo '<h3 id="block-user">Заявка не подтверждена. Что-то пошло не так.</h3>';
                    }
                }

                if (isset($_POST['no_proposal'])) {
                    $change_status = MySQL_query("UPDATE members SET status = 'rejected' WHERE id = '$member_id'");
                    if (isset($change_status)) {
                        echo '<h3 id="block-user">Заявка отклонена!</h3>';
                    }
                    else {
                        echo '<h3 id="block-user">Заявка не отклонена. Что-то пошло не так.</h3>';
                    }
                }
            }
            else {
                echo 'У вас недостаточно прав!';
            }

            echo '<button type="button" class="btn btn-default" onclick="location.href=\'./app_main.php\'" style="text-align: center;">
                     Вернуться на главную
                 </button>';
        ?>
    </body>
</html>
