<?php
  require_once("template/navbar.php");
  require("config/config.php");
?>

<head>
  <link rel="stylesheet" href="css/main.css">
  <title>Star list</title>
  <meta charset="utf-8">
</head>

<div id="wrap">
  <section id="Main" class="container clearfix border-box">
    <div class="block">

      <h2 class="headline-hr starh"><?php echo $_GET["username"];?>'s Star</h1>

        <table class="table table-hover table-bordered table-striped alignCenter problem-table">
          <thead>
            <tr>
              <th class="alignCenter " style="width:7%">#</th>
              <th class="alignCenter" style="width:50%">Problem title</th>
              <th class="alignCenter" style="width:20%">Accepted Rate</th>
              <th class="alignCenter">Last submit</th>
            </tr>
          </thead>
          <tbody id="problem-List">
  <?php

  $query0 = "SELECT `pid` FROM `star` WHERE username='".$_GET["username"]."'";
  $result0= mysql_query($query0,$link) or die ("資料庫連線異常，請檢察網路設定或聯絡系統管理員");

  while($row0 = mysql_fetch_row($result0,MYSQL_ASSOC)){
    $query = "SELECT `ptitle`,`ac`,`wa`,`plast` FROM `problemSet` WHERE pid='".$row0["pid"]."'";
    $result= mysql_query($query,$link) or die ("資料庫連線異常，請檢察網路設定或聯絡系統管理員");
    $row = mysql_fetch_row($result,MYSQL_ASSOC);

    $ptitle = $row["ptitle"];
    $ac = $row["ac"];
    $wa = $row["wa"];
    $ratio = $ac."/".$wa;
    $plast = $row["plast"];

    $str = '<tr><th class="tElement">'.$row0["pid"].'</th>';
    $str .= '<th class="tElement"><a href="problem.php?pid='.$row0["pid"].'">'.$ptitle.'</a></th>';
    $str .= '<th class="tElement">'.$ratio.'</th>';
    $str .= '<th class="tElement">'.$plast.'</th></tr>';
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
