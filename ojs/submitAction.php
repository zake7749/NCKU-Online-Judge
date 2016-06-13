<?php
  require_once("template/navbar.php");
  require("config/config.php");
?>
<head>
  <link rel="stylesheet" href="css/main.css">
  <meta charset="utf-8">
</head>

<?php

  $username = $_SESSION["username"];
  $ptitle = $_POST["ptitle"];
  $pid = $_POST["pid"];
  $code = $_POST["code"];
  $code = mysql_real_escape_string($code);
/*
  //check if reaccept or not
  $query= "SELECT COUNT(name) FROM `sloveBoard` WHERE `name`='".$username."' AND `pstate`='"."Accepted"."'";
  $result= mysql_query($query,$link) or die ("資料庫連線異常,當次提交並未送出,請檢察網路設定或聯絡系統管理員");
  $count = mysql_fetch_row($result,MYSQL_ASSOC);
  //if the user have not try this problem, try++;
  if($count[0] == 0){
    $query = "SELECT"
  }
*/


  $query = "INSERT INTO `sloveBoard` (`pid`,`ptitle`,`code`,`name`,`pstate`)
  VALUES ('".$pid."','".$ptitle."','".$code."','".$username."','Pending');";
  //echo $query;
  $result= mysql_query($query,$link) or die ("資料庫連線異常,當次提交並未送出,請檢察網路設定或聯絡系統管理員");
 ?>

<div id="wrap">
  <section id="Main" class="container clearfix" style="background-color:#FCFCFC">
    <div>
      <h2 style="color: #85B716  ;font-family:webTE;">Your submit succeeded</h2>
      <hr>
      <div class="problem">
        <div class="submitCard">
          <div style="text-align:center;">
          /**********************************************/<br/>
          <div class="info"># Information of this submit</div>
          /**********************************************/<br/><br/>
          </div>
          <li><span style="color:#0086B3;">Sumbit</span>-<span style="color:#0086B3;">ID</span>:<?php echo " ".$pid;?></li>
          <li><span style="color:#0086B3;">Sumbit</span>-<span style="color:#0086B3;">Problem</span>:<?php echo " ".$ptitle;?></li>
          <li><span style="color:#0086B3;">Sumbit</span>-<span style="color:#0086B3;">User</span>:<?php echo " ".$username;?></li>
          <li><span style="color:#0086B3;">Sumbit</span>-<span style="color:#0086B3;">State</span>: PENDING</li>
          <br/>
          Go to either <a href="try.php?username=<?php echo $_SESSION['username']?>">"your try"</a> or <a href="live.php">"liveboard"</a> to check the latest state;
        </div>
      </div>
    </div>
  </section>
</div>
<?php
  require_once("template/footer.html");
?>
