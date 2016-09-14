<?php
  require_once("template/navbar.php");
  require("config/config.php");
?>

<head>
  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" href="css/tag.css">
  <meta charset="utf-8">
  <title>Live list</title>
</head>
<div id="wrap" >
  <section id="Main" class="container clearfix border-box">
    <div class="block">
        <table class="table table-striped alignCenter problem-table">
          <thead>
            <tr>
              <th class="alignCenter" style="width:18%">Name</th>
              <th class="alignCenter" style="width:40%">Probloem title</th>
              <th class="alignCenter" style="width:20%">State</th>
              <th class="alignCenter">Submit time</th>
            </tr>
          </thead>
          <tbody id="problem-List">
  <?php

  $query = "SELECT `pid`,`ptitle`,`name`,`psubmit`,`pstate` FROM `sloveBoard`  ORDER BY `psubmit` DESC LIMIT 0,15";
  $result= mysql_query($query,$link) or die ("資料庫連線異常，請檢察網路設定或聯絡系統管理員");

  while($row = mysql_fetch_row($result,MYSQL_ASSOC)){
    $name = $row["name"];
    $pid = $row["pid"];
    $ptitle = $row["ptitle"];
    $psubmit = $row["psubmit"];
    $pstate = $row["pstate"];

    $tag = "";

    if($pstate=="Accepted")
      $tag = "cirtag actag";
    else if($pstate=="Pending"){
      $tag = "cirtag pdtag";
    }else{
      $tag = "cirtag watag";
    }

    $str = '<tr><th class="tElement"><a href="profile.php?username='.$name.'">'.$name.'</a></th>';
    $str .= '<th class="tElement"><a href="problem.php?pid='.$pid.'">'.$ptitle.'</a></th>';
    $str .= '<th class="tElement"><span class="'.$tag.'">'.$pstate.'</span></th>';
    $str .= '<th class="tElement">'.$psubmit.'</th></tr>';
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
