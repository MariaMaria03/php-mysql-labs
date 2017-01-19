<!DOCTYPE html>
<html>
  <head>
    <title>Результаты</title>
    <link rel='stylesheet' type='text/css' href='styles.css'/>
    <link rel='stylesheet' href='bootstrap/css/bootstrap.min.css' type='text/css'>
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </head>
  <body class="lab2-background">
        <h3 class="h3-lab2">Спортивная школа по плаванию г.Уфа</h3>

    <?php
        include ('app_db_settings.php');
        session_start();

        if (isset($_SESSION['log'])) {
            $tour_id = $_GET['tour_id'];
            $tour_sql = MySQL_query("SELECT id, referee_id FROM tournaments WHERE id = '$tour_id'");
            $tournament = MySQL_fetch_array($tour_sql);
            $user_log = $_SESSION['log'];
            $user_sql = MySQL_query("SELECT id FROM users WHERE login = '$user_log'");
            $user = MySQL_fetch_array($user_sql);

            if ($tournament['referee_id'] != $user['id']) {
                echo '<h3 class="tournaments">Так как вы не являетесь организатором турнира, вы не можете вносить результаты.</h3>';
            }
            else {
                if (isset($_POST['make_results'])){
                    $winner = $_POST['winner'];
                    $second_place = $_POST['second_place'];
                    $third_place = $_POST['third_place'];
                    if (($winner == $second_place) | ($winner == $third_place) | ($second_place == $third_place)) {
                        echo '<h3 class="tournaments">Выберите разных участников!</h3>';
                        echo $winner;
                        echo $second_place;
                        echo $third_place;
                    }
                    else {
                        $place_result1 = MySQL_query("UPDATE members SET place = 1 WHERE id = '$winner'");
                        $place_result2 = MySQL_query("UPDATE members SET place = 2 WHERE id = '$second_place'");
                        $place_result3 = MySQL_query("UPDATE members SET place = 3 WHERE id = '$third_place'");
                        if (MySQL_affected_rows() != -1)
                        echo '<h3 class="tournaments">Результаты сохранены!</h3>';
                    }
                }
            }
        }
        else {
            echo '<h3 class="tournaments">Авторизуйтесь!</h3>';
        }
    ?>

        <button type="button" class="btn btn-labeled btn-default" id="back-main" onclick="location.href='./app_main.php'">
            Вернуться на главную
        </button>

        <?php
            if ($tournament['referee_id'] == $user['id']) {
                echo '<div class="panel panel-info" id="form-results">
                        <div class="panel-heading">
                            <h3 class="h3-lab2">Внести результаты соревнований</h3>
                        </div>
                        <form method="POST" action="" >
                            <div class="panel-body">
                                <div class="input-group" id="tournament-select">
                                    <div>
                                        <table><tr>
                                                <td class="label-tour">1 место: </td>';
                                            $all_athletes = MySQL_query("SELECT  members.id, concat(users.last_name, ' ', users.first_name, ' ', users.middle_name) AS full_name
                                                                    FROM ((members
                                                                    LEFT OUTER JOIN users on members.user_id = users.id)
                                                                    LEFT OUTER JOIN tournaments on members.tournament_id = tournaments.id)
                                                                    WHERE tournament_id = $tour_id AND members.status = 'confirmed'");

                                            echo '<td><select class="form-control" required autofocus name="winner">
                                                        <option value="" disabled selected>Выберите победителя</option>';
                                            while($athlete = MySQL_fetch_array($all_athletes)) {
                                                echo '<option value="'.$athlete["id"].'">'.$athlete["full_name"].'</option>';
                                            }
                                            echo '</select></td>';
                                        echo '</tr></table>
                                    </div>
                                    <div>
                                        <table><tr>
                                                <td class="label-tour">2 место: </td>';
                                            $all_athletes2 = MySQL_query("SELECT  members.id, concat(users.last_name, ' ', users.first_name, ' ', users.middle_name) AS full_name
                                                                    FROM ((members
                                                                    LEFT OUTER JOIN users on members.user_id = users.id)
                                                                    LEFT OUTER JOIN tournaments on members.tournament_id = tournaments.id)
                                                                    WHERE tournament_id = $tour_id AND members.status = 'confirmed'");

                                            echo '<td><select class="form-control" required autofocus name="second_place">
                                                            <option value="" disabled selected>Выберите призера</option>';
                                            while($athlete = MySQL_fetch_array($all_athletes2)) {
                                                echo '<option value="'.$athlete["id"].'">'.$athlete["full_name"].'</option>';
                                            }
                                            echo '</select></td>
                                        </tr></table>
                                    </div>
                                    <div>
                                        <table><tr>
                                                <td class="label-tour">3 место: </td>';
                                            $all_athletes3 = MySQL_query("SELECT  members.id, concat(users.last_name, ' ', users.first_name, ' ', users.middle_name) AS full_name
                                                                    FROM ((members
                                                                    LEFT OUTER JOIN users on members.user_id = users.id)
                                                                    LEFT OUTER JOIN tournaments on members.tournament_id = tournaments.id)
                                                                    WHERE tournament_id = $tour_id AND members.status = 'confirmed'");

                                            echo '<td><select class="form-control" required autofocus name="third_place">
                                                    <option value="" disabled selected>Выберите призера</option>';
                                            while($athlete = MySQL_fetch_array($all_athletes3)) {
                                                echo '<option value="'.$athlete["id"].'">'.$athlete["full_name"].'</option>';
                                            }
                                            echo '</select></td>';
                                        echo '</tr></table>
                                    </div>
                                </div>
            
                            </div>
                            <div class="panel-footer">
                                <div class="row" id="enter">
                                    <input type="submit" class="btn btn-labeled btn-success" value="Сохранить" name="make_results">
                                </div>
                            </div>
                        </form>
                    </div>';
            }
        ?>
  </body>
</html>
