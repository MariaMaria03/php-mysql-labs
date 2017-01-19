<!DOCTYPE html>
<html>
  <head>
    <title>������������ ������ �2</title>
    <link rel='stylesheet' type='text/css' href='styles.css'/>
    <script type="text/javascript" src="jquery-1.12.2.js"></script>
    <link rel='stylesheet' href='bootstrap/css/bootstrap.min.css' type='text/css'>
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </head>
  <body class="lab2-background">
        <h3 class="h3-lab2">���������� ����� �� �������� �.���, ������ � �������</h3>

        <div class="php-lab2-href">
          <button type="button" class="btn btn-default btn-lg" id="button-style" onclick="location.href='./list_academy.php'">
            �����, � ��������������� ������
          </button>
        </div>

        <?php
          include('data_person.php');
          $group1 = array();
          $group2 = array();
          $group3 = array();
          $group4 = array();

          $num = 1;
        foreach ($athletes as $athlete)
          switch ($athlete['group']) {
            case '��-4':
               array_push($group1, $athlete);
               break;
            case '���-1':
                array_push($group2, $athlete);
                break;
            case '���-3':
              array_push($group3, $athlete);
              break;
            case '��-4':
              array_push($group4, $athlete);
              break;
          }
            ?>


        <div class="panel panel-info" id="lab2-size-panel">
          <div class="panel-heading">
            <h3 class="info-group">������ ��-4: ���������������� (��������� ������� �������) </h3>
          </div>
          <div class="panel-body">
            <table class="table" id="table-academy">
              <tbody>
              <?php
              echo '<h3 class="h3-current">������: '.$coachs[0].'</h3>';
              echo '<tr class="header-table-lab2"> 
                      <td>'.$athletes_headers[0].'</td>
                      <td> '.$athletes_headers[1].'</td>
                      <td>'.$athletes_headers[3].'</td>
                    </tr>';
              $num = 1;
              foreach ($group1 as $member)

                echo '<tr class="lab2-rows">
                        <td>'.$member['full_name'].'</td>
                        <td>'.$member['birth_date'].'</td>
                        <td>'.$member['sports_rank'].'</td>
                      </tr>'
              ?>
              </tbody>

            </table>
            </div>
        </div>


        <div class="panel panel-info" id="lab2-size-panel">
          <div class="panel-heading">
            <h3 class="info-group">������ ���-1: ������� ���������������� </h3>
          </div>
            <div class="panel-body">
              <table class="table" id="table-academy">
                <tbody>
                <?php
                echo '<h3 class="h3-current">������:'.$coachs[1].'</h3>';
                echo '<tr class="header-table-lab2">
                          <td >'.$athletes_headers[0].'</td>
                          <td> '.$athletes_headers[1].'</td>
                          <td>'.$athletes_headers[3].'</td>
                        </tr>';
                $num = 1;

                foreach ($group2 as $member)

                  echo '<tr class="lab2-rows">
                          <td>'.$member['full_name'].'</td>
                          <td>'.$member['birth_date'].'</td>
                          <td>'.$member['sports_rank'].'</td>
                        </tr>';
                ?>
                </tbody>

              </table>
            </div>
          </div>


        <div class="panel panel-info" id="lab2-size-panel">
          <div class="panel-heading">
            <h3 class="info-group">������ ���-3: ������� ���������������� </h3>
          </div>
            <div class="panel-body">
              <table class="table" id="table-academy">
                <tbody>
                <?php
                echo '<h3 class="h3-current">������:'.$coachs[2].'</h3>';
                echo '<tr class="header-table-lab2">
                          <td >'.$athletes_headers[0].'</td>
                          <td> '.$athletes_headers[1].'</td>
                          <td>'.$athletes_headers[3].'</td>
                        </tr>';
                $num = 1;
                foreach ($group3 as $member)

                  echo '<tr class="lab2-rows">
                          <td>'.$member['full_name'].'</td>
                          <td>'.$member['birth_date'].'</td>
                          <td>'.$member['sports_rank'].'</td>
                        </tr>'
                ?>
                </tbody>

              </table>
            </div>
          </div>


        <div class="panel panel-info" id="lab2-size-panel">
          <div class="panel-heading">
            <h3 class="info-group">������ ��-4: ������� </h3>
          </div>
            <div class="panel-body">
              <table class="table" id="table-academy">
                <tbody>
                <?php
                echo '<h3 class="h3-current">������:'.$coachs[3].'</h3>';
                echo '<tr class="header-table-lab2">
                          <td >'.$athletes_headers[0].'</td>
                          <td> '.$athletes_headers[1].'</td>
                          <td>'.$athletes_headers[3].'</td>
                        </tr>';
                $num = 1;
                foreach ($group4 as $member)

                  echo '<tr class="lab2-rows">
                          <td>'.$member['full_name'].'</td>
                          <td>'.$member['birth_date'].'</td>
                          <td>'.$member['sports_rank'].'</td>
                        </tr>'
                ?>
                </tbody>

              </table>
            </div>
          </div>


          
  </body>
</html>
