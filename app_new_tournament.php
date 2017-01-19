<!DOCTYPE html>
<html>
  <head>
    <title>Новый турнир</title>
    <link rel='stylesheet' type='text/css' href='styles.css'/>
    <link rel='stylesheet' href='bootstrap/css/bootstrap.min.css' type='text/css'>
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </head>
  <body class="lab2-background">
        <h3 class="h3-lab2">Спортивная школа по плаванию г.Уфа</h3>

    <?php
        include ('app_db_settings.php');
        session_start();

        if ($_SESSION['log']) {
            $all_referee = MySQL_query("SELECT last_name, first_name, middle_name, id FROM users WHERE category = 'manager'");
        }

        if (isset($_POST['add_new_tournament'])){
            $name_tour = $_POST['name_tour'];

            $sql_res = MySQL_query("SELECT id FROM tournaments WHERE name = '$name_tour'");
            if(mysql_num_rows($sql_res) != 0 ){
                echo '<h3 class="tournaments">Турнир уже существует!</h3>';
            }
            else {
                $today = date("Y-m-d");
                $date_start = $_POST['date_start'];
                $date_end = $_POST['date_end'];
                if (strtotime($today) > strtotime($date_start) | strtotime($date_start) > strtotime($date_end)) {
                    echo '<h3 class="tournaments">Поставьте верную дату начала турнира!</h3>';
                }
                else {
                    $referee_id = $_POST['referee_id'];
                    $description = '';
                    if (isset($_POST['description'])) {
                        $description = $_POST['description'];
                    }

                    $tournament_create = MySQL_query("INSERT INTO tournaments (name, date_start, date_end, description, status, referee_id)
                                         VALUES('$name_tour', '$date_start', '$date_end', '$description', 'expected', '$referee_id')");
                    if (isset($tournament_create)) {
                        echo '<h3 class="tournaments">Турнир создан!</h3>';
                    }
                }
            }

        }
    ?>

        <div class="panel panel-success" id="form-new-tour">
            <div class="panel-heading">
                <h3 class="h3-lab2">Добавление нового турнира</h3>
            </div>
            <form method='POST' action='' >
                <div class="panel-body">
                    <div class="input-group" id="tournament-style">
                        <input type="text" class="form-control" name="name_tour" placeholder="Наименование" required autofocus />
                    </div>

                    <div class="input-group" id="tournament-style">
                        <input type="date" class="form-control" name="date_start" placeholder="Дата начала" required autofocus />
                    </div>

                    <div class="input-group" id="tournament-style">
                        <input type="date" class="form-control" name="date_end" placeholder="Дата окончания" required autofocus />
                    </div>

                    <div class="input-group" id="tournament-style">
                        <input type="text" class="form-control" name="description" placeholder="Описание"/>
                    </div>

                    <div class="input-group" id="tournament-style">
                        <?php
                            echo '<select class="form-control" required autofocus name="referee_id">
                                    <option value="" disabled selected>Выберите судью-организатора турнира</option>';
                            while($referee = MySQL_fetch_array($all_referee)) {
                                echo '<option value="'.$referee['id'].'">'.$referee['last_name'].' '.$referee['first_name'].' '.$referee['middle_name'].'</option>';
                            }
                            echo '</select>';
                        ?>
                    </div>

                </div>
                <div class="panel-footer">
                    <div class="row" id="enter">
                        <input type="submit" class="btn btn-labeled btn-default" value="Добавить турнир в календарь турниров" name="add_new_tournament">
                        <button type="button" class="btn btn-labeled btn-default" id="button-style" onclick="location.href='./app_main.php'">
                            На главную
                        </button>
                </div>
            </form>
        </div>

  </body>
</html>
