<?php
  require_once("template/navbar.php");
  require("config/config.php");
?>
<head>
  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" href="css/formBoard.css">
  <meta charset="utf-8">
</head>

<?php

if(!isset($_SESSION["username"])){
  echo "<h1>Please login first.</h1>";
  exit;
}

if($_GET["pid"]!=""){
  $pid = $_GET["pid"];

  /*********************************
    select the given problme info
  **********************************/

  $query = "SELECT `ptitle` FROM `problemSet` WHERE `pid` = ".$pid;
  //echo $query;
  $result= mysql_query($query,$link) or die ("資料庫連線異常，請檢察網路設定或聯絡系統管理員");
  $row = mysql_fetch_row($result,MYSQL_ASSOC);
  $ptitle = $row["ptitle"];
  if($ptitle==""){
    echo "<h1>There is no such problem.</h1>";
    exit;
  }
}else{
  echo "<h1>There is no such problem.</h1>";
  exit;
}
 ?>

  <div id="wrap">
    <section id="Main" class="container clearfix border-box">
      <div>
        <h2>Submit to <a href="problem.php?pid=<?php echo $pid; ?>"><?php echo "$ptitle"; ?></a></h2>
        <hr>
        <form action="submitAction.php" method="post">
          <input name="pid" type="hidden" value="<?php echo $pid;?>">
          <input name="ptitle" type="hidden" value="<?php echo $ptitle;?>">
          <textarea class="form-control" name="code" cols="55" rows="3" autofocus="true" placeholder="請填入解答程式碼"></textarea>
          <input type="submit" class="btn btn-info" style="float:right;margin-top:10px;" value="Submit">
        </form>
      </div>
    </section>
  </div>
<?php
  require_once("template/footer.html");
?>
