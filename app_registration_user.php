<!DOCTYPE html>
<html>
  <head>
    <title>Регистрация</title>
    <link rel='stylesheet' type='text/css' href='styles.css'/>
    <link rel='stylesheet' href='bootstrap/css/bootstrap.min.css' type='text/css'>
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </head>
  <body class="lab2-background">
        <h3 class="h3-lab2">Спортивная школа по плаванию г.Уфа</h3>

    <?php
        include ('app_db_settings.php');
        session_start();
        if (isset($_GET['category'])) {
            $category_global = $_GET['category'];
        }
        if (isset($_SESSION['log'])) {
            $current_login_user = $_SESSION['log'];
            $current_user_sql = MySQL_query("SELECT id, concat(last_name, ' ', first_name, ' ', middle_name) AS name_coach
                                         FROM users WHERE login = '$current_login_user'");
            $current_user = MySQL_fetch_array($current_user_sql);
            $current_user_id = $current_user['id'];
        }

        if (isset($_POST['registration_info'])){
            $login = $_POST['login'];
            $password = $_POST['password'];
            $sql_res = MySQL_query("SELECT id FROM users WHERE login='$login'", $link);
            if(mysql_num_rows($sql_res) != 0 ){
                $_SESSION['msg'] = "Пользователь с таким логином уже существует!";
            }

            if(isset($_SESSION['msg'])){
                echo $_SESSION['msg'];
                unset ($_SESSION['msg']);
            }

            $login = $_POST['login'];
            $first_name = $_POST['first_name'];
            $last_name = $_POST['last_name'];
            $password = $_POST['password'];
            if (isset($_POST['middle_name'])) {
                $middle_name = $_POST['middle_name'];
            }
            if (isset($_POST['email'])) {
                $email = $_POST['email'];
            }
            if (isset($_POST['birth_date'])) {
                $birth_date = $_POST['birth_date'];
            }

            $login = stripslashes($login);
            $login = htmlspecialchars($login);
            $password = stripslashes($password);
            $password = htmlspecialchars($password);
            $login = trim($login);
            $password = trim($password);

            if  (isset($category_global)) {
                $category = $_POST['category'];
                $query_create = MySQL_query("INSERT INTO users (login, first_name, middle_name, last_name, email, category, password, birth_date, status_user)
                                         VALUES('$login', '$first_name', '$middle_name', '$last_name', '$email', '$category', '$password', '$birth_date', '3')");

                if (MySQL_affected_rows() != -1) {
                    echo '<h3 class="tournaments">Данные отправлены! Администратор в скором времени рассмотрит вашу
                                                        заявку на регистрацию и свяжется с вами.</h3>';
                }
                else {
                    echo '<h3 class="tournaments">Попробуйте еще раз.</h3>';
                }
            }
            elseif (isset($current_login_user) & $current_login_user == 'admin') {
                $category = $_POST['category'];
                $query_create = MySQL_query("INSERT INTO users (login, first_name, middle_name, last_name, email, category, password, birth_date, status_user)
                                         VALUES('$login', '$first_name', '$middle_name', '$last_name', '$email', '$category', '$password', '$birth_date', '1')");

                if (MySQL_affected_rows() != -1) {
                    echo '<h3 class="tournaments">Пользователь зарегистрирован!</h3>';
                }
                else {
                    echo '<h3 class="tournaments">Попробуйте еще раз.</h3>';
                }
            }
            else {
                $category = '3';
                $query_create = MySQL_query("INSERT INTO users (login, first_name, middle_name, last_name, email,
                                                                category, password, birth_date, status_user, coach_id)
                                         VALUES('$login', '$first_name', '$middle_name', '$last_name', '$email', '$category', '$password', '$birth_date', 1, $current_user_id)");

                if (MySQL_affected_rows() != -1) {
                    echo '<h3 class="tournaments">Спортсмен зарегистрирован!</h3>';
                }
                else {
                    echo '<h3 class="tournaments">Попробуйте еще раз.</h3>';
                }
            }
        }
    ?>

        <div class="panel panel-info" id="form-registration">
            <div class="panel-heading">
                <h3 class="h3-lab2">Регистрация пользователя</h3>
            </div>
            <form method='POST' action='' >
                <div class="panel-body">
                    <div class="input-group" id="registration-style">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                        <input type="text" class="form-control" name="login" placeholder="Пользовательский никнейм" required autofocus />
                    </div>

                    <div class="input-group" id="registration-style">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                        <input type="text" class="form-control" name="first_name" placeholder="Имя" required autofocus />
                    </div>

                    <div class="input-group" id="registration-style">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                        <input type="text" class="form-control" name="last_name" placeholder="Фамилия" required autofocus />
                    </div>

                    <div class="input-group" id="registration-style">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                        <input type="text" class="form-control" name="middle_name" placeholder="Отчество" />
                    </div>

                    <div class="input-group" id="registration-style">
                        <div class="col-sm-4" id="date-birth">
                            <p >Дата рождения: </p>
                        </div>
                        <div class="col-sm-8" id="birth-data">
                            <input type="date" class="form-control" name="birth_date" placeholder="Дата рождения"/>
                        </div>
                    </div>

                    <div class="input-group" id="registration-style">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
                        <input type="text" class="form-control" name="email" placeholder="Электронная почта" />
                    </div>

                    <?php
                        if (isset($category_global)) {
                            echo '<div class="input-group" id="registration-style">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-check"></span></span>
                                <select class="form-control" required autofocus name="category">
                                    <option value="" disabled selected>Выберите категорию</option>
                                    <option value="2">Тренер</option>
                                    <option value="4">Организатор</option>
                                </select>
                            </div>';
                        }
                        elseif (isset($current_login_user)) {
                            if ($current_login_user == 'admin') {
                                echo '<div class="input-group" id="registration-style">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-check"></span></span>
                                    <select class="form-control" required autofocus name="category">
                                        <option value="" disabled selected>Выберите категорию</option>
                                        <option value="2">Тренер</option>
                                        <option value="4">Организатор</option>
                                    </select>
                                </div>';
                            }
                            else {
                                echo '<div class="input-group" id="registration-style">
                                    <div class="col-sm-4" id="date-birth">
                                        <p >Тренер: </p>
                                    </div>
                                    <div class="col-sm-8" id="coach-name">
                                        <p> '.$current_user['name_coach'].'</p>
                                    </div>
                                </div>';
                            }
                        }
                    ?>

                    <div class="input-group" id="registration-style">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                        <input type="password" class="form-control" name="password" placeholder="Пароль" required />
                    </div>

                </div>
                <div class="panel-footer">
                    <div class="row" id="enter">
                        <?php
                            if (isset($category_global)) {
                                echo  '<input type="submit" class="btn btn-labeled btn-success" value="Отправить регистрационные данные" name="registration_info">';
                                echo '<button type="button" class="btn btn-labeled btn-success" id="main-path" onclick="location.href=\'./app_welcome.php\'">
                                        На страницу авторизации
                                    </button>';
                            }
                            elseif (isset($current_login_user) & $current_login_user == 'admin') {
                                echo  '<input type="submit" class="btn btn-labeled btn-success" value="Зарегистрировать" name="registration_info">';
                                echo '<button type="button" class="btn btn-labeled btn-success" id="main-path" onclick="location.href=\'./app_main.php\'">
                                        На главную
                                    </button>';
                            }
                            else {
                                echo  '<input type="submit" class="btn btn-labeled btn-success" value="Зарегистрировать спортсмена" name="registration_info">';
                                echo '<button type="button" class="btn btn-labeled btn-success" id="main-path" onclick="location.href=\'./app_main.php\'">
                                        На главную
                                    </button>';
                            }
                        ?>
                </div>
            </form>
        </div>
  </body>
</html>
