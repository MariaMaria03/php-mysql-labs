<!DOCTYPE html>
<html>
  <head>
    <title>�����������</title>
    <link rel='stylesheet' type='text/css' href='styles.css'/>
    <link rel='stylesheet' href='bootstrap/css/bootstrap.min.css' type='text/css'>
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </head>
  <body class="lab2-background">
        <h3 class="h3-lab2">���������� ����� �� �������� �.���</h3>

    <?php
        include ('app_db_settings.php');
        session_start();

        if (isset($_POST['registration_info'])){
            $login = $_POST['login'];
            $password = $_POST['password'];
            $sql_res = MySQL_query("SELECT id FROM users WHERE login='$login'", $link);
            if(mysql_num_rows($sql_res) != 0 ){
                $_SESSION['msg'] = "������������ � ����� ������� ��� ����������!";
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

            $query_create = MySQL_query("INSERT INTO users (login, first_name, middle_name, last_name, email, category, password, birth_date, status_user)
                                         VALUES('$login', '$first_name', '$middle_name', '$last_name', '$email', '5', '$password', '$birth_date', '1')");
            $id = MySQL_insert_id();
            $sql_res = MySQL_query("SELECT * FROM users WHERE id=$id");
            $new_user = MySQL_fetch_assoc($sql_res);
            $_SESSION['log'] = $new_user['login'];
            $_SESSION['create_user'] = true;
            $_SESSION['category'] = $new_user['category'];
            header("location: ./app_main.php");
        }
    ?>

        <div class="panel panel-info" id="form-registration">
            <div class="panel-heading">
                <h3 class="h3-lab2">����������� ������ ������������</h3>
            </div>
            <form method='POST' action='' >
                <div class="panel-body">
                    <div class="input-group" id="registration-style">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                        <input type="text" class="form-control" name="login" placeholder="���������������� �������" required autofocus />
                    </div>

                    <div class="input-group" id="registration-style">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                        <input type="text" class="form-control" name="first_name" placeholder="���" required autofocus />
                    </div>

                    <div class="input-group" id="registration-style">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                        <input type="text" class="form-control" name="last_name" placeholder="�������" required autofocus />
                    </div>

                    <div class="input-group" id="registration-style">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                        <input type="text" class="form-control" name="middle_name" placeholder="��������" />
                    </div>

                    <div class="input-group" id="registration-style">
                        <div class="col-sm-4" id="date-birth">
                            <p >���� ��������: </p>
                        </div>
                        <div class="col-sm-8" id="birth-data">
                            <input type="date" class="form-control" name="birth_date" placeholder="���� ��������"/>
                        </div>
                    </div>

                    <div class="input-group" id="registration-style">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
                        <input type="text" class="form-control" name="email" placeholder="����������� �����" />
                    </div>

                    <div class="input-group" id="registration-style">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                        <input type="password" class="form-control" name="password" placeholder="������" required />
                    </div>

                </div>
                <div class="panel-footer">
                    <div class="row" id="enter">
                        <input type="submit" class="btn btn-labeled btn-success" value="������������������" name="registration_info">
                        <button type="button" class="btn btn-labeled btn-success" id="button-style" onclick="location.href='./app_welcome.php'">
                            �� �������� �����������
                        </button>
                </div>
            </form>
        </div>
  </body>
</html>
