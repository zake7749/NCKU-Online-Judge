<?php
  require_once("template/navbar.php");
  require("config/config.php");
?>

<head>
  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" href="css/tag.css">
  <meta charset="utf-8">
</head>

<div id="wrap">
  <section id="Main" class="container clearfix border-box">
    <div class="block">

        <h2 class="headline-hr tryh"><?php echo $_GET["username"];?>'s try list</h1>

        <table class="table table-hover table-bordered table-striped alignCenter problem-table">
          <thead>
            <tr>
              <th class="alignCenter " style="width:7%">#</th>
              <th class="alignCenter" style="width:50%">Problem title</th>
              <th class="alignCenter" style="width:20%">State</th>
              <th class="alignCenter">Submit time</th>
            </tr>
          </thead>
          <tbody id="problem-List">
  <?php

  $query = "SELECT `pid`,`ptitle`,`psubmit`,`pstate` FROM `sloveBoard` WHERE name='".$_GET["username"]."'";
  $result= mysql_query($query,$link) or die ("資料庫連線異常，請檢察網路設定或聯絡系統管理員");

  while($row = mysql_fetch_row($result,MYSQL_ASSOC)){
    $pid = $row["pid"];
    $ptitle = $row["ptitle"];
    $pstate = $row["pstate"];
    $plast = $row["psubmit"];

    $tag = "";

    if($pstate=="Accepted")
      $tag = "tag actag";
    else if($pstate=="Pending"){
      $tag = "tag pd";
    }else{
      $tag = "tag watag";
    }

    $str = '<tr><th class="tElement">'.$pid.'</th>';
    $str .= '<th class="tElement"><a href="problem.php?pid='.$pid.'">'.$ptitle.'</a></th>';
    $str .= '<th class="tElement '.$tag.'">'.$pstate.'</th>';
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
