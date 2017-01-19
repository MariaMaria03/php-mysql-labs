<!DOCTYPE html>
<html>
  <head>
    <title>Лабораторная работа №2</title>
    <link rel='stylesheet' type='text/css' href='styles.css'/>
    <script type="text/javascript" src="jquery-1.12.2.js"></script>
    <link rel='stylesheet' href='bootstrap/css/bootstrap.min.css' type='text/css'>
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </head>
  <body class="lab2-background">
        <button type="button" class="btn btn-default" id="main-button" onclick="location.href='index.htm'">
          На персональную страницу студента
        </button>

        <h3 class="h3-lab2">Спортивная школа по плаванию г.Уфа</h3>
        <?php
          include('data_person.php'); 
          $today=date("d.m.y");
          echo "Сегодня $today";
        ?>

         <div>
            <div class="php-lab2-href">
                <button type="button" class="btn btn-default btn-lg" id="button-style" onclick="location.href='./by_groups.php'">
                    Сортировка по группам
                </button>
            </div>
            <div class="php-lab2-href">
                <button type="button" class="btn btn-default btn-lg" id="button-style" onclick="location.href='./by_last_name.php'">
                    Сортировка по фамилии
                </button>
            </div>
         </div>

          <div class="panel panel-info" id="lab2-size-panel">
            <div class="panel-heading">
              <p class="panel-title" id="header-self">Все спортсмены школы</p>
            </div>
            <div class="panel-body">
              <table class="table" id="table-academy">
                <tbody>
                <?php
                  echo '<tr class="header-table-lab2">
                      <td>№</td>
                      <td >'.$athletes_headers[0].'</td>
                      <td> '.$athletes_headers[1].'</td>
                      <td>'.$athletes_headers[2].'</td>
                      <td>'.$athletes_headers[3].'</td>
                    </tr>';
                  $num = 1;
                  foreach ($athletes as $athlet)
                   
                    echo '<tr class="lab2-rows">
                      <td>'.$num++.'</td>
                      <td>'.$athlet['full_name'].'</td>
                      <td>'.$athlet['birth_date'].'</td>
                      <td>'.$athlet['group'].'</td>
                      <td>'.$athlet['sports_rank'].'</td>
                    </tr>'
                    ?>
                </tbody>
          
              </table>
            </div>

          </div>

          
  </body>
</html>
