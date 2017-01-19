<!DOCTYPE html>
<html>
    <head>
        <title>Спортивная школа по плаванию</title>
        <link rel='stylesheet' type='text/css' href='styles.css'/>
        <link rel='stylesheet' href='bootstrap/css/bootstrap.min.css' type='text/css'>
        <script src="bootstrap/js/bootstrap.min.js"></script>
    </head>
    <body class="lab2-background">
    
        <?php
            include ('app_db_settings.php');
            session_start();

            if (isset($_SESSION['log'])) {
                $user_log = $_SESSION['log'];
                $user_id_sql = MySQL_query("SELECT id FROM users WHERE login='$user_log'");
                $user_id = MySQL_result($user_id_sql, 0);
            }
            if (isset($_SESSION) && array_key_exists('create_user', $_SESSION)) {
                echo 'Вы зарегистрированы!';
                unset($_SESSION['create_user']);
            }
            if (isset($_POST['log_out'])) {
                unset($_SESSION['log']);
                echo '<META HTTP-EQUIV="Refresh" content="0; URL=app_welcome.php">';
            }

            $today = date("Y-m-d");
            echo $today;
            $date_start_tour = MySQL_query("SELECT date_start, date_end, id FROM tournaments");
            while ($date = MySQL_fetch_array($date_start_tour)) {
                $tour_id = $date['id'];
                if (strtotime($today) > strtotime($date['date_start']) & strtotime($today) < strtotime($date['date_end'])) {
                    $change_status = MySQL_query("UPDATE tournaments SET status = 'go' WHERE id = '$tour_id'");
                }
                elseif (strtotime($today) > strtotime($date['date_end'])) {
                    $change_status = MySQL_query("UPDATE tournaments SET status = 'completed' WHERE id = '$tour_id'");
                }
                else {
                    $change_status = MySQL_query("UPDATE tournaments SET status = 'expected' WHERE id = '$tour_id'");
                }
            }

             echo '<h3 class="h3-lab2">Спортивная школа по плаванию г.Уфа</h3>';

            $category = $_SESSION['category'];
            if (isset($user_log)) {
                echo '<form method="post">
                        <button type="submit" name=\'log_out\' value=\'Выйти\' class="btn btn-default" id="log-out">
                            Выйти <span class="glyphicon glyphicon-log-out"></span>
                        </button>
                    </form>';

                if ($category == 'admin') {
                    echo '<div class="btn-group-vertical" role="group" aria-label="Vertical button group" id="menu-coach">
                        <button type="button" class="btn btn-default" onclick="location.href=\'./app_profile.php\'">
                            Мой профиль
                        </button>
                        <button type="button" class="btn btn-default" onclick="location.href=\'./app_verification_user_data.php\'">
                            Подтвердить регистрацию </br> тренера или организатора';
                            $on_conside = MySQL_query("SELECT id FROM users WHERE status_user = 'consideration'");
                            $count = mysql_num_rows($on_conside);
                            echo ' ('.$count.')';
                        echo '</button>
                            <button type="button" class="btn btn-default" onclick="location.href=\'./app_registration_user.php\'">
                                Зарегистрировать тренера</br> или организатора
                            </button>';
                     echo '</div>';

                    echo '<table align="center" class="table table-bordered" id="table-users">
                        <thead>
                            <th class="users-admin">Логин</th> 
                            <th class="users-admin">ФИО</th>
                            <th class="users-admin">Email</th>
                            <th class="users-admin">Категория</th>
                            <th class="users-admin">Блокирован (дата)</th>
                            <th class="users-admin">Действие</th>
                        </thead>';
                    $query = MySQL_query("SELECT * FROM users WHERE id <> '$user_id' AND status_user = 'confirmed'");
                    while ($data = MySQL_fetch_array($query)) {
                        switch ($data['category']) {
                            case 'athlete':
                                $category = 'Спортсмен';
                                break;
                            case 'coach':
                                $category = 'Тренер';
                                break;
                            case 'manager':
                                $category = 'Организатор';
                                break;
                            case 'visitor':
                                $category = 'Гость (посетитель)';
                                break;
                        }
                        echo " 
                            <tr class='users-admin'> 
                                <td class='rows-users'>".$data['login']."</td>
                                <td>".$data['last_name']." ".$data['first_name']." ".$data['middle_name']."</td>
                                <td>".$data['email']."</td> 
                                <td>".$category."</td> 
                                <td>".$data['block']."</td> 
                                <td>
                                    <button class=\"btn btn-default\">";
                        if ($data['block']) {
                            echo "<a href='app_block_user.php?id=".$data['id']."&action=unblock'>Разблокировать</a>";
                        }
                        else {
                            echo "<a href='app_block_user.php?id=".$data['id']."&action=block'>Заблокировать</a>";
                        }
                        echo "</button>
                                </td> 
                                </tr> ";
                    }
                    echo "</table>";
                }
                elseif ($category == 'coach') {
                    echo '<div class="btn-group-vertical" role="group" aria-label="Vertical button group" id="menu-coach">
                        <button type="button" class="btn btn-default" onclick="location.href=\'./app_athletes.php\'">
                            Посмотреть список </br> всех спортсменов
                        </button>
                        <button type="button" class="btn btn-default" onclick="location.href=\'./app_registration_user.php\'">
                            Зарегистрировать спортсмена
                        </button>
                        <button type="button" class="btn btn-default" onclick="location.href=\'./app_profile.php\'">
                            Мой профиль
                        </button>
                     </div>';

                    echo '<h3 class="tournaments">Турниры</h3>';
                    echo '<table align="center" class="table table-bordered" id="table-tournaments">
                            
                        <thead>
                            <th class="tournaments">Наименование турнира</th> 
                            <th class="tournaments">Дата начала</th>
                            <th class="tournaments">Дата окончания</th>
                            <th class="tournaments">Описание</th>
                            <th class="tournaments">Статус</th>
                            <th class="tournaments">Судья-организатор</th>
                            <th class="tournaments">Результаты</th>
                            <th class="tournaments">Участники</th>
                        </thead>';
                    $query = MySQL_query("SELECT tournaments.id, tournaments.status AS tour_status, tournaments.name, tournaments.date_start, tournaments.date_end,
                                               tournaments.description, tournaments.status,
                                               concat(users.last_name, ' ', users.first_name, ' ', users.middle_name) AS referee  FROM tournaments 
                                        LEFT JOIN users ON users.id = tournaments.referee_id");
                    while ($data = MySQL_fetch_array($query)) {
                        switch ($data['status']) {
                            case 'expected':
                                $status = 'Ожидается';
                                break;
                            case 'go':
                                $status = 'Турнир проходит сейчас';
                                break;
                            case 'completed':
                                $status = 'Турнир завершился';
                                break;
                        }
                        echo " 
                            <tr class='tournaments'> 
                                <td>".$data['name']."</td>
                                <td>".$data['date_start']."</td>
                                <td>".$data['date_end']."</td> 
                                <td>".$data['description']."</td> 
                                <td>".$status."</td> 
                                <td>".$data['referee']."</td>
                                <td>";
                                    if ($data['tour_status'] == 'completed') {
                                        echo "<button class='btn btn-default'>
                                                <a href='app_results.php?tour_id=".$data['id']."'>Посмотреть результаты</a>
                                                </button>";
                                    }
                                    else {
                                        echo '<p class="tournaments">Турнир не начался или сейчас проходит.</p>';
                                    }

                                echo '</td>
                                <td>';
                                    if ($data['tour_status'] == 'completed') {
                                        echo "<button class='btn btn-default'>
                                                            <a href='app_members_tour.php?tour_id=".$data['id']."'>Посмотреть участников</a>
                                              </button>";
                                    }
                                    else {
                                        echo "<button class='btn btn-default'>
                                                            <a href='app_members_tour.php?tour_id=".$data['id']."'>Заявленные участники</a>
                                              </button>";
                                    }
                                echo '</td>
                        </tr>';
                    }
                    echo "</table>";
                }
                elseif ($category == 'manager') {
                    echo '<div class="btn-group-vertical" role="group" aria-label="Vertical button group" id="menu-coach">
                        <button type="button" class="btn btn-default" onclick="location.href=\'./app_proposal.php\'">
                            Посмотреть заявки
                        </button>
                        <button type="button" class="btn btn-default" onclick="location.href=\'./app_new_tournament.php\'">
                            Добавить турнир
                        </button>
                        <button type="button" class="btn btn-default" onclick="location.href=\'./app_profile.php\'">
                            Мой профиль
                        </button>
                     </div>';

                    echo '<h3 class="tournaments">Турниры</h3>';
                    echo '<table align="center" class="table table-bordered" id="table-tournaments">
                            
                        <thead>
                            <th class="tournaments">Наименование турнира</th> 
                            <th class="tournaments">Дата начала</th>
                            <th class="tournaments">Дата окончания</th>
                            <th class="tournaments">Описание</th>
                            <th class="tournaments">Статус</th>
                            <th class="tournaments">Судья-организатор</th>
                            <th class="tournaments">Результаты</th>
                            <th class="tournaments">Участники</th>
                            <th class="tournaments">Внести результаты</th>
                        </thead>';
                    $query = MySQL_query("SELECT tournaments.id, tournaments.status AS tour_status, tournaments.name, tournaments.date_start, tournaments.date_end,
                                               tournaments.description, tournaments.status,
                                               concat(users.last_name, ' ', users.first_name, ' ', users.middle_name) AS referee  FROM tournaments 
                                        LEFT JOIN users ON users.id = tournaments.referee_id");
                    while ($data = MySQL_fetch_array($query)) {
                        switch ($data['status']) {
                            case 'expected':
                                $status = 'Ожидается';
                                break;
                            case 'go':
                                $status = 'Турнир проходит сейчас';
                                break;
                            case 'completed':
                                $status = 'Турнир завершился';
                                break;
                        }
                        echo " 
                            <tr class='tournaments'> 
                                <td>".$data['name']."</td>
                                <td>".$data['date_start']."</td>
                                <td>".$data['date_end']."</td> 
                                <td>".$data['description']."</td> 
                                <td>".$status."</td> 
                                <td>".$data['referee']."</td>
                                <td>";
                        if ($data['tour_status'] == 'completed') {
                            echo "<button class='btn btn-default'>
                                                <a href='app_results.php?tour_id=".$data['id']."'>Посмотреть результаты</a>
                                                </button>";
                        }
                        else {
                            echo '<p class="tournaments">Турнир не начался или сейчас проходит.</p>';
                        }

                        echo '</td>
                                <td>';
                        if ($data['tour_status'] == 'completed') {
                            echo "<button class='btn btn-default'>
                                                            <a href='app_members_tour.php?tour_id=".$data['id']."'>Посмотреть участников</a>
                                              </button>";
                        }
                        else {
                            echo "<button class='btn btn-default'>
                                                            <a href='app_members_tour.php?tour_id=".$data['id']."'>Заявленные участники</a>
                                              </button>";
                        }
                        echo '</td>
                                <td>';
                        $tour_id = $data['id'];
                        $places = MySQL_query("SELECT members.place FROM ((members
                                                    LEFT OUTER JOIN users on members.user_id = users.id)
                                                    LEFT OUTER JOIN tournaments on members.tournament_id = tournaments.id)
                                                    WHERE tournament_id = $tour_id");
                        $empty = true;
                        while ($place = MySQL_fetch_array($places)) {
                            if ($place['place'] != '') {
                                $empty = false;
                                break;
                            }
                        }

                        if ($data['tour_status'] == 'completed' & $empty) {
                            echo "<button class='btn btn-default'>
                                                    <a href='app_make_results.php?user_log=".$user_log."&tour_id=".$data['id']."'>Внести результаты </a>
                                      </button>";
                        }
                        elseif ($data['tour_status'] == 'go' | $data['tour_status'] == 'expected') {
                            echo '';
                        }
                        elseif ($empty == false) {
                            echo '<p class="tournaments">Результаты уже внесены</p>';
                        }

                        '</td>
                        </tr>';
                    }
                    echo "</table>";
                }
                elseif ($category == 'athlete') {
                    echo '<div class="btn-group-vertical" role="group" aria-label="Vertical button group" id="menu-coach">
                        <button type="button" class="btn btn-default" onclick="location.href=\'./app_send_proposal.php\'">
                            Подать заявку
                        </button>
                        <button type="button" class="btn btn-default" onclick="location.href=\'./app_participation_athlete.php\'">
                            Календарь ваших выступлений
                        </button>
                        <button type="button" class="btn btn-default" onclick="location.href=\'./app_profile.php\'">
                            Мой профиль
                        </button>
                     </div>';

                    echo '<h3 class="tournaments">Турниры</h3>';
                    echo '<table align="center" class="table table-bordered" id="table-tournaments">
                            
                        <thead>
                            <th class="tournaments">Наименование турнира</th> 
                            <th class="tournaments">Дата начала</th>
                            <th class="tournaments">Дата окончания</th>
                            <th class="tournaments">Описание</th>
                            <th class="tournaments">Статус</th>
                            <th class="tournaments">Судья-организатор</th>
                            <th class="tournaments">Результаты</th>
                        </thead>';
                    $query = MySQL_query("SELECT tournaments.id, tournaments.status AS tour_status, tournaments.name, tournaments.date_start, tournaments.date_end,
                                               tournaments.description, tournaments.status,
                                               concat(users.last_name, ' ', users.first_name, ' ', users.middle_name) AS referee  FROM tournaments 
                                        LEFT JOIN users ON users.id = tournaments.referee_id");
                    while ($data = MySQL_fetch_array($query)) {
                        switch ($data['status']) {
                            case 'expected':
                                $status = 'Ожидается';
                                break;
                            case 'go':
                                $status = 'Турнир проходит сейчас';
                                break;
                            case 'completed':
                                $status = 'Турнир завершился';
                                break;
                        }
                        echo " 
                            <tr class='tournaments'> 
                                <td>".$data['name']."</td>
                                <td>".$data['date_start']."</td>
                                <td>".$data['date_end']."</td> 
                                <td>".$data['description']."</td> 
                                <td>".$status."</td> 
                                <td>".$data['referee']."</td>
                                <td>";

                                    if ($data['tour_status'] == 'completed') {
                                        echo "<button class='btn btn-default'>
                                                <a href='app_results.php?tour_id=".$data['id']."'>Посмотреть результаты</a>
                                                </button>";
                                    }
                                    else {
                                        echo '<p class="tournaments">Турнир не начался или сейчас проходит.</p>';
                                    }

                                echo '</td></tr>';
                    }
                    echo "</table>";
                }
                elseif ($category == 'visitor') {
                    echo '<div class="btn-group-vertical" role="group" aria-label="Vertical button group" id="menu-coach">
                        <button type="button" class="btn btn-default" onclick="location.href=\'./app_profile.php\'">
                            Мой профиль
                        </button>
                     </div>';

                    echo '<h3 class="tournaments">Турниры</h3>';
                    echo '<table align="center" class="table table-bordered" id="table-tournaments">
                            
                        <thead>
                            <th class="tournaments">Наименование турнира</th> 
                            <th class="tournaments">Дата начала</th>
                            <th class="tournaments">Дата окончания</th>
                            <th class="tournaments">Описание</th>
                            <th class="tournaments">Статус</th>
                            <th class="tournaments">Судья-организатор</th>
                            <th class="tournaments">Результаты</th>
                        </thead>';
                    $query = MySQL_query("SELECT tournaments.id, tournaments.status AS tour_status, tournaments.name, tournaments.date_start, tournaments.date_end,
                                               tournaments.description, tournaments.status,
                                               concat(users.last_name, ' ', users.first_name, ' ', users.middle_name) AS referee  FROM tournaments 
                                        LEFT JOIN users ON users.id = tournaments.referee_id");
                    while ($data = MySQL_fetch_array($query)) {
                        switch ($data['status']) {
                            case 'expected':
                                $status = 'Ожидается';
                                break;
                            case 'go':
                                $status = 'Турнир проходит сейчас';
                                break;
                            case 'completed':
                                $status = 'Турнир завершился';
                                break;
                        }
                        echo " 
                            <tr class='tournaments'> 
                                <td>".$data['name']."</td>
                                <td>".$data['date_start']."</td>
                                <td>".$data['date_end']."</td> 
                                <td>".$data['description']."</td> 
                                <td>".$status."</td> 
                                <td>".$data['referee']."</td>
                                <td>";

                        if ($data['tour_status'] == 'completed') {
                            echo "<button class='btn btn-default'>
                                                <a href='app_results.php?tour_id=".$data['id']."'>Посмотреть результаты</a>
                                                </button>";
                        }
                        else {
                            echo '<p class="tournaments">Турнир не начался или сейчас проходит.</p>';
                        }

                        echo '</td></tr>';
                    }
                    echo "</table>";
                }
            }
            else {
                echo '<h3 id="block-user">Авторизуйтесь!</h3>';
                echo $_SESSION['log'];
                echo $_SESSION['category'];
                echo '<div class="enter-user">
                          <button type="button" class="btn btn-default" id="again-enter" onclick="location.href=\'./app_welcome.php\'">
                                На страницу авторизации
                            </button>
                      </div>';
            }
        ?>
    </body>
</html>
