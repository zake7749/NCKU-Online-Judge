<?php
  require_once("template/navbar.php");
  require("config/config.php");
?>

<head>
  <title>Rank</title>
  <link rel="stylesheet" href="css/main.css">
  <meta charset="utf-8">
</head>

<div id="wrap">
  <section id="Main" class="container clearfix border-box">
    <div class="block">
        <table class="table table-hover table-bordered table-striped alignCenter problem-table">
          <thead>
            <tr>
              <th class="alignCenter " style="width:7%">#</th>
              <th class="alignCenter" style="width:10%">Name</th>
              <th class="alignCenter" style="width:50%">Nick name</th>
              <th class="alignCenter" style="width:12%">Accepted</th>
              <th class="alignCenter" style="width:12%">Submit</th>
              <th class="alignCenter" style="width:7%">Ratio</th>
            </tr>
          </thead>
          <tbody id="problem-List">
  <?php

  $query = "SELECT `name`,`ac`,`wa`,`nickname` FROM `user` ORDER BY `user`.`ac` DESC";
  $result= mysql_query($query,$link) or die ("資料庫連線異常，請檢察網路設定或聯絡系統管理員");

  $count = 0;
  while($row = mysql_fetch_row($result,MYSQL_ASSOC)){
    $name = $row["name"];
    $ac = $row["ac"];
    $nick = $row["nickname"];
    $wa = $row["wa"];
    $submit = $ac + $wa;
    if($submit != 0)
      $ratio = $ac / $submit * 100;
    else
      $ratio = 0;
    if($nick == NULL)
      $nick = $name;

    $ratio = number_format($ratio,2);
    $count = $count + 1;
    $str = '<tr><th class="tElement">'.$count.'</th>';
    $str .= '<th class="tElement"><a href="profile.php?username='.$name.'">'.$name.'</a></th>';
    $str .= '<th class="tElement">'.$nick.'</th>';
    $str .= '<th class="tElement"><a href="accpet.php?username='.$name.'">'.$ac.'</a></th>';
    $str .= '<th class="tElement"><a href="try.php?username='.$name.'">'.$submit.'</a></th>';
    $str .= '<th class="tElement">'.$ratio.'%</th></tr>';
    echo($str);
  }


  ?>
          </tbody>
      </table>
    </div>
  </section>
</div>
<?php
  require_once("template/footer.html");
?>
