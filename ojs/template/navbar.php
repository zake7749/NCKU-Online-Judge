
<link rel="stylesheet" href="css/bootstrap-theme.min.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/navbar.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<meta charset="utf-8">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

<script>
var SubmitForm=function(){
  //alert("IN");
  $.ajax({
      url: "action.php",
      data:"action=2",
      type:"POST",
      dataType:'text',
      success: function(response){
          //alert(response);
          document.location.href="problemSet.php";
      },
      error:function(xhr, ajaxOptions, thrownError){
        alert("ERROR");
        alert(xhr.status);
        alert(thrownError);
      }
  });
}
</script>

<?php

function echoActiveClassIfRequestMatches($requestUri){
    $current_file_name = basename($_SERVER['REQUEST_URI'], ".php");

    if ($current_file_name == $requestUri)
        echo 'class="active"';
}

function activeSign($requestUri){
    $current_file_name = basename($_SERVER['REQUEST_URI'], ".php");

    if ($current_file_name == $requestUri)
        return 'active';
}
?>


<body>
  <nav class="light-green navbar fixed-raidus">
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand" href="#">NCKUOJ</a>
      </div>
      <div>
        <ul class="nav navbar-nav" aria-label="Left Align">
          <li <?=echoActiveClassIfRequestMatches("news")?>><a href="#"><span class="glyphicon glyphicon-bullhorn fixed-margin" aria-hidden="true"></span>News</a></li>
          <li <?=echoActiveClassIfRequestMatches("problemSet")?>><a href="problemSet.php"><span class="glyphicon glyphicon-book fixed-margin" aria-hidden="true"></span>Problemset</a></li>
          <li <?=echoActiveClassIfRequestMatches("live")?>><a href="live.php"><span class="glyphicon glyphicon-blackboard fixed-margin" aria-hidden="true"></span>Live</a></li>
          <li <?=echoActiveClassIfRequestMatches("rank")?>><a href="rank.php"><span class="glyphicon glyphicon-fire fixed-margin" aria-hidden="true"></span>Rank</a></li>
        <?php
          session_start();
          if(isset($_SESSION["username"]) && $_SESSION["priority"] > 1){
          $str='<li><a href="problemAdd.php"><span class="glyphicon glyphicon-edit fixed-margin" aria-hidden="true"></span>Add Problem</a></li>';
          echo($str);
        }?>
        </ul>
        <ul class="nav navbar-nav navbar-right fixed-margin-list">
<?php
  
  if(isset($_SESSION["username"])){
  $str='
    <li>
      <div class="dropdown">
        <div class="btn btn-default dropdown-toggle" style="margin-top:6px;" type="button" id="userOption" data-toggle="dropdown" aria-expanded="true">
          <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
          <span class="caret"></span>
        </div>
        <ul class="dropdown-menu menu" aria-labelledby="userOption">
          <li class="dropdown-header">Signed in as '.$_SESSION["username"].'</li>
          <li role="separator" class="divider"></li>
          <li><a href="profile.php?username='.$_SESSION["username"].'">Your profile</a></li>
          <li><a href="update.php">Edit profile</a></li>
          <li><a href="star.php?username='.$_SESSION["username"].'">Your stars</a></li>
          <li role="separator" class="divider"></li>
          <li><a href="#" onclick="SubmitForm()">Sign out</a></li>
        </ul>
      </div>
    </li>';
    echo($str);

  }else{
    $signIn = activeSign("register");
    $login = activeSign("login");
    $signStr = '<li class="navbar-right '.$signIn.'"><a href="register.php"><span class="glyphicon glyphicon-pencil fixed-margin" aria-hidden="true"></span>Sign in</a></li>';
    $loginStr = '<li class="navbar-right '.$login.'"><a href="login.php"><span class="glyphicon glyphicon-lamp fixed-margin" aria-hidden="true"></span>Login</a></li>';
    echo($signStr);
    echo($loginStr);
  }
?>
        </ul>
      </div>
    </div>
  </nav>
</body>
