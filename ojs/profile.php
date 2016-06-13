<?php
  require_once("template/navbar.php");
  require("config/config.php");
?>
<head>
  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" href="css/profile.css">
  <link rel="stylesheet" href="css/github.css">
  <link rel="stylesheet" href="css/tag.css">
  <meta charset="utf-8">
</head>

<?php
  //search-personal-profile

  $query = "SELECT * FROM `user` WHERE `name`='".$_GET["username"]."'";
  $result= mysql_query($query,$link) or die ("資料庫連線異常，請檢察網路設定或聯絡系統管理員");
  $row = mysql_fetch_row($result,MYSQL_ASSOC);

  $username = $_GET["username"];
  $nickname = $row["nickname"];
  $school = $row["school"];
  $location = $row["location"];
  $about = $row["about"];
  $date = $row["joindate"];
  $date = substr($date,0,10);

  //search-personal-star-count
  $query= "SELECT COUNT(username) FROM `star` WHERE `username`='".$username."'";
  $result= mysql_query($query,$link) or die ("資料庫連線異常，請檢察網路設定或聯絡系統管理員");
  $starCount = mysql_fetch_row($result);

  //search-personal-accepted-count
  $query= "SELECT `ac` FROM `user` WHERE `name`='".$username."'";
  //echo $query;
  $result= mysql_query($query,$link) or die ("資料庫連線異常，請檢察網路設定或聯絡系統管理員");
  $acCount = mysql_fetch_row($result);
  //search-personal-try-count;
  $query= "SELECT COUNT(name) FROM `sloveBoard` WHERE `name`='".$username."'";
  $result= mysql_query($query,$link) or die ("資料庫連線異常，請檢察網路設定或聯絡系統管理員");
  $tyCount = mysql_fetch_row($result);
 ?>
<body style="background-color:white;">
  <div id="wrap">
    <section id="Main" class="container clearfix" style="background-color:white;">
      <div class="profile">
          <div class="profile-status">
            <div class="profile-status-attribute">
              <div class="profile-status-image"></div>
            </div>
            <?php echo'<h1 class="profile-status-user">'.$nickname.'</h1>';?>
            <?php echo'<h3 class="profile-status-nickname">'.$_GET["username"].'</h3>';?>
            <div class="profile-status-attribute">
              <div class="profile-status-list">
                <li><span class="glyphicon glyphicon-map-marker icon-margin-right" aria-hidden="true"></span><?php echo"$location";?></li>
                <li><span class="glyphicon glyphicon-education icon-margin-right" aria-hidden="true"></span><?php echo"$school";?></li>
                <li><span class="glyphicon glyphicon-time icon-margin-right" aria-hidden="true"></span>Joined on <?php echo"$date";?></li>
                <hr>
              </div>
            </div>
          </div>
          <div class="profile-work">
            <div class="profile-username">Workshop</div>
            <div class="profile-content">
              <!--persolan quote block-->
                <div class="bq">
                  <?php echo"$about";?>
                  <cite><?php echo"$nickname";?></cite>
                </div>
              <!--persolan block-->
                <div class="problem-recent">
                  <table class="alignCenter problem-recent" style="border:none;width:100%;">
                    <thead>
                      <tr>
                        <th class="alignCenter " style="width:7%">#</th>
                        <th class="alignCenter" style="width:50%">Problem</th>
                        <th class="alignCenter" style="width:15%">Time</th>
                        <th class="alignCenter">Status</th>
                      </tr>
                    </thead>
                    <tbody id="cutsom-personal-List">
                      <?php
                      //check if there are some question have solved by this username.
                      $query = "SELECT COUNT(name) FROM `sloveBoard` WHERE `name`='$username' LIMIT 5";
                      $result= mysql_query($query,$link) or die ("資料庫連線異常，請檢察網路設定或聯絡系統管理員");
                      $recentCount = mysql_fetch_row($result);

                      if($recentCount[0] != 0){
                        //if there are, find and list them.
                        $query = "SELECT * FROM `sloveBoard` WHERE `name`='$username' ORDER BY `psubmit` DESC LIMIT 5";
                        //echo $query;
                        $result= mysql_query($query,$link) or die ("資料庫連線異常，請檢察網路設定或聯絡系統管理員");

                        while($row = mysql_fetch_row($result,MYSQL_ASSOC)){
                          $pid = $row["pid"];
                          $ptitle = $row["ptitle"];
                          $time = $row["psubmit"];
                          $state = $row["pstate"];

                          $tag = "";

                          if($state=="Accepted")
                            $tag = "ac";
                          else if($state=="Pending"){
                            $tag = "pd";
                          }else{
                            $tag = "wa";
                          }


                          $str = '<tr><th class="tElement">'.$pid.'</th>';
                          $str .= '<th class="tElement"><a href="problem.php?pid='.$pid.'">'.$ptitle.'</a></th>';
                          $str .= '<th class="tElement">'.$time.'</th>';
                          $str .= '<th class="tElement '.$tag.'">'.$state.'</th></tr>';
                          echo($str);
                        }
                      }else{
                        $str = '<tr><th class="tElement"><span class="nodata">NA</span></th>';
                        $str .= '<th class="tElement"><span class="nodata">NO DATA</span></th>';
                        $str .= '<th class="tElement"><span class="nodata">NO DATA</span></th>';
                        $str .= '<th class="tElement"><span class="nodata">NO DATA</span></th></tr>';
                        echo($str);
                      }

                       ?>
                    </tbody>
                  </table>
                </div>
                <div class="profile-like">
                  <div class="boxed-group flush">
                    <div class="contrib-column contrib-column-first table-column">
                      <span class="text-muted">Your stars</span>
                      <span class="contrib-number"><a href="star.php?username=<?php echo $username;?>"><?php echo $starCount[0];?> total</a></span>

                    </div>
                    <div class="contrib-column table-column">
                      <span class="text-muted">Your try</span>
                        <span class="contrib-number"><a href="try.php?username=<?php echo $username;?>"><?php echo $tyCount[0];?> problems</a></span>

                    </div>
                    <div class="contrib-column table-column">
                      <span class="text-muted">Your accepted</span>
                        <span class="contrib-number"><a href="accpet.php?username=<?php echo $username;?>"><?php echo $acCount[0];?> problems</a></span>
                        
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
    </section>
  </div>
</body>
<?php
  require_once("template/footer.html");
?>
