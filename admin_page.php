<!DOCTYPE html>
<html>
  <head>
    <title>Личный кабинет</title>
    <link rel='stylesheet' type='text/css' href='styles.css'/>
    <script type="text/javascript" src="jquery-1.12.2.js"></script>
    <link rel='stylesheet' href='bootstrap/css/bootstrap.min.css' type='text/css'>
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </head>
  <body class="lab2-background">
      <?php
      session_start();
      $today=date("d.m.y");
      echo "Сегодня $today";
      ?>
      <button type="button" class="btn btn-default" id="main-button" onclick="location.href='index.htm'">
          На персональную страницу студента
      </button>
  
      <h3 class="success-enter">Вы вошли как <?php echo $_SESSION['log']?>.</h3>


      <form method='post'>
          <div class="row" id="enter">
              <input type="submit" name='log_out' value='Выйти' class="btn btn-default">
          </div>
      </form>

      <?php
          if (isset($_POST['log_out'])) {
              unset($_SESSION['log']);
              echo '<META HTTP-EQUIV="Refresh" content="0; URL=authorization.php">';
          }
      ?>

      <h3 class="header-athletes">Все спортсмены школы</h3>
      <?php
          $link = MySQL_connect('informatic.ugatu.ac.ru','sts402','40254');
          MySQL_select_db('sts402-9143', $link);
          $query = "SELECT full_name FROM athletes";
          $result=MySQL_query($query);
          $out='<table style="text-align: center; margin: auto">
                     <tr>
                     <td style="font-weight: 600">Фамилия И.О.</td>
                     </tr>';
          While($row=MySQL_fetch_array($result)) {
              $out.='<tr>';
              $out.='<td>';
              $out.=' '.$row['full_name'];
              $out.'</td>';
              $out.='</tr>';
          }
          $out.='</table>';
          print $out
      ?>



          
  </body>
</html>
