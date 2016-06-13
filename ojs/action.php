<?php
session_start();

require("config/config.php");
/**********************************************
    Get the action command from html

    Usage
      switch(_POST["action"])

    Value
      - 0 : login
      - 1 : Register
      - 2 : Logout
      - 3 : Update profile
      - 9527 : list all problem or filter by a query.

**********************************************/

switch ($_POST["action"]) {
  case '0':
      login($link);
    break;
  case '1':
      register($link);
    break;
  case '2':
      logout();
    break;
  case '3':
      updateProfile($link);
    break;
  case '4':
    break;
  case '5':
    break;
  case '6':
    break;
  case '7':
    break;
  case '8':
    staradd($link);
    break;
  case '9527':
    loadProblem($link);
    break;
  default:
    break;
}


function register($db){
  $passMd5 = md5($_POST["password"]);
  $query= "INSERT INTO `user` (`name`,`password`,`email`) VALUES ('".$_POST["name"]."','".$passMd5."','".$_POST["email"]."')";
  $result= mysql_query($query,$db) or die ("該帳號已被使用，請更換帳號名稱");
  echo "註冊成功，前往<a href='login.php'>登入頁面</a>";
}

function login($db){
  $escapeUN = mysql_real_escape_string($_POST["name"]);
  //echo("USERNAME".$escapeUN."<br/>");
  $query= "SELECT * FROM `user` WHERE name = '".$escapeUN."'";
  $result= mysql_query($query,$db) or die ("Error in query: $query.". mysql_error());

  $row = mysql_fetch_row($result,MYSQL_ASSOC);
  $password = $row["password"];
  $priority = $row["priority"];

  if(md5($_POST["password"]) == $password){
    $_SESSION["username"] = $_POST["name"];
    $_SESSION["priority"] = $priority;
    echo("suc");
  }
  else{
    echo("Wrong username or password.<br/>");
  }
}

function logout(){
  echo("登出成功");
  unset($_SESSION["username"]);
  unset($_SESSION["priority"]);
}

function updateProfile($link){

  $query =  "UPDATE `user` SET nickname='".$_POST["name"]."',location='".$_POST["location"]."',school='".$_POST["school"]."',about='".$_POST["about"]."' WHERE name='".$_POST["username"]."'";
  //echo $query;
  $result= mysql_query($query,$link) or die ("資料庫連線異常，請檢察網路設定或聯絡系統管理員");
  echo ("suc");
}


function loadProblem($link){

  //is initial loading or a search
  if(isset($_POST["query"])){
    $query = "SELECT `pid`,`ptitle`,`ac`,`wa`,`plast` FROM `problemSet` WHERE ptitle LIKE '%".$_POST["query"]."%'";
  }else{
    $query = "SELECT `pid`,`ptitle`,`ac`,`wa`,`plast` FROM `problemSet`";
  }

  $result= mysql_query($query,$link) or die ("資料庫連線異常，請檢察網路設定或聯絡系統管理員");

  while($row = mysql_fetch_row($result,MYSQL_ASSOC)){
    $pid = $row["pid"];
    $ptitle = $row["ptitle"];
    $ac = $row["ac"];
    $wa = $row["wa"];
    $submit = $ac+$wa;
    if($wa!=0)
      $ratio = $ac/$submit;
    else {
      if($ac!=0)
        $ratio = 1;
      else
        $ratio = 0;
    }
    $ratio = $ratio*100;
    $ratio = number_format($ratio,2);
    $plast = $row["plast"];

    $str = '<tr><th class="tElement">'.$pid.'</th>';
    $str .= '<th class="tElement"><a href="problem.php?pid='.$pid.'">'.$ptitle.'</a></th>';
    $str .= '<th class="tElement">'.$ac.'</th>';
    $str .= '<th class="tElement">'.$ratio.'</th></tr>';
    echo($str);
  }
}

function staradd($db){
  $pid = $_POST["pid"];
  $username = $_POST["username"];
  $query="SELECT * FROM `star` WHERE username='".$username."' and pid='".$pid."'";
  $result=mysql_query($query,$db);
  $check = 0;
  if($rows=mysql_fetch_array($result,MYSQL_ASSOC)){
      $check = 1;
  }
  if($check == 0){
    $query="INSERT INTO star(pid,username) values('".$pid."','".$username."')";
    $result=mysql_query($query,$db);
    print 'unstar';
  }
  else{
    $query="DELETE FROM `star` WHERE pid = '".$pid."' and username = '".$username."'";
    $result=mysql_query($query,$db);
    print 'star';
  }
}
 ?>
