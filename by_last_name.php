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
        <h3 class="h3-lab2">Все спортсмены, отсортированные по фамилии</h3>

        <div class="php-lab2-href">
          <button type="button" class="btn btn-default btn-lg" id="button-style" onclick="location.href='./list_academy.php'">
            Назад, к первоначальному списку
          </button>
        </div>

        <?php
          include('data_person.php');
          $sorting_athlete = $athletes;
          function cmp($a, $b) {
            return strcmp($a["full_name"], $b["full_name"]);
          }
          usort($sorting_athlete, "cmp");
        ?>


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
              foreach ($sorting_athlete as $athlete)

                echo '<tr class="lab2-rows">
                      <td>'.$num++.'</td>
                      <td>'.$athlete['full_name'].'</td>
                      <td>'.$athlete['birth_date'].'</td>
                      <td>'.$athlete['group'].'</td>
                      <td>'.$athlete['sports_rank'].'</td>
                    </tr>'
              ?>
              </tbody>

            </table>
          </div>

        </div>


          
  </body>
</html>
