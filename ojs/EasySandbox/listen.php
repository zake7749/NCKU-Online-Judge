<?php
  //require_once("../template/navbar.php");
  require("../config/config.php");
?>

<?php
function survey($link){
  $query = "SELECT `solveid`,`pid`,`ptitle`,`name`,`code` FROM `sloveBoard` WHERE `pstate`='Pending'";
  $result= mysql_query($query,$link) or die ("資料庫連線異常，請檢察網路設定或聯絡系統管理員".mysql_error());

    while($row = mysql_fetch_row($result,MYSQL_ASSOC)){
      $username = $row["name"];
      $pid = $row["pid"];
      $ptitle = $row["ptitle"];
      $code = $row["code"];
      $solveid = $row["solveid"];

      $codepath = "t/";
      $datapath = "oracle/";
      //write code to the file
      $execfilename = uniqid();

      $codefilepath = $codepath.$execfilename.".c";

      $file = fopen($codefilepath, "w") or die("Unable to open file!");
      fwrite($file, $code);
      fclose($file);

      $command = "g++ -o ".$codepath.$execfilename." ".$codefilepath;
      //echo $command;
      //compile the file
      $compileInfo = shell_exec($command);
      if($compileInfo!=""){
        echo("Compile Error<br/>");
        //Opps , compile error detected.
      }else{
        $query = "SELECT `indata`,`outdata` FROM `problemSet` WHERE `pid`='".$pid."'";
        $result= mysql_query($query,$link) or die ("資料庫連線異常，請檢察網路設定或聯絡系統管理員".mysql_error());
        $testdata = mysql_fetch_row($result,MYSQL_ASSOC);

        // /n vs /r/n
        $testdata["indata"] = str_replace("\r","",$testdata["indata"]);
        $testdata["outdata"] = str_replace("\r","",$testdata["outdata"]);

        //add the string for the limit of EasySandbox.
        //$testdata["outdata"] = "<<entering SECCOMP mode>>\n".$testdata["outdata"];

        $sampledatapath = $datapath.$execfilename;
        //wrtie to sample input file
        $file = fopen($sampledatapath.".in", "w") or die("Unable to open file!");
        fwrite($file, $testdata["indata"]);
        fwrite($file,-1);//this is critical, means EOF
        fclose($file);
        //write to sample output file
        $file = fopen($sampledatapath.".out", "w") or die("Unable to open file!");
        fwrite($file, $testdata["outdata"]);
        fclose($file);

        //time to use EasySandbox
        $command = "./runtest.sh /t/".$execfilename;
        //echo $command;
        $output = shell_exec($command);
        echo $output;

        if(substr_count($output,"passed!")!=0){
          //accepted.
          echo("->SID:$solveid is passed,which is submit by $username<br/>");
          $query = "UPDATE `sloveBoard` SET pstate='Accepted' WHERE `solveid`=".$solveid;
          //echo $query;
          $result= mysql_query($query,$link) or die ("資料庫連線異常，請檢察網路設定或聯絡系統管理員".mysql_error());

          //check this user have solve this or not;
          $query= "SELECT COUNT(name) FROM `sloveBoard` WHERE `name`='".$username."' AND `pstate`='"."Accepted"."' AND `pid`='".$pid."'";
          //echo $query;
          $result= mysql_query($query,$link) or die ("資料庫連線異常，請檢察網路設定或聯絡系統管理員".mysql_error());
          $account = mysql_fetch_row($result);
          echo "<br/>His account is $account[0]";
          if($account[0]==1){
            //add personal's ac
            $query = "SELECT `ac` FROM `user` WHERE `name`='".$username."'";
            $result= mysql_query($query,$link) or die ("資料庫連線異常，請檢察網路設定或聯絡系統管理員".mysql_error());
            $acnum = mysql_fetch_row($result,MYSQL_ASSOC);
            $ac = $acnum['ac']+1;
            $query = "UPDATE `user` SET `ac`='".$ac."' WHERE `name`='".$username."'";
            $result= mysql_query($query,$link) or die ("資料庫連線異常，請檢察網路設定或聯絡系統管理員".mysql_error());

            //add problem's ac
            $query = "SELECT `ac` FROM `problemSet` WHERE `pid`='".$pid."'";
            $result= mysql_query($query,$link) or die ("資料庫連線異常，請檢察網路設定或聯絡系統管理員".mysql_error());
            $acnum = mysql_fetch_row($result,MYSQL_ASSOC);
            $ac = $acnum['ac']+1;
            $query = "UPDATE `problemSet` SET `ac`='".$ac."' WHERE `pid`='".$pid."'";
            $result= mysql_query($query,$link) or die ("資料庫連線異常，請檢察網路設定或聯絡系統管理員".mysql_error());

          }

        }else{
          //failed.
          $query = "UPDATE `sloveBoard` SET `pstate`='Wrong Answer' WHERE `solveid`=".$solveid;
          $result= mysql_query($query,$link) or die ("資料庫連線異常，請檢察網路設定或聯絡系統管理員".mysql_error());

          $query = "SELECT `wa` FROM `user` WHERE `name` = '".$username."'";
          $result= mysql_query($query,$link) or die ("資料庫連線異常，請檢察網路設定或聯絡系統管理員");
          $warow = mysql_fetch_row($result);
          $wa = $warow[0]+1;

          $query = "UPDATE `user` SET `wa`='".$wa."' WHERE `name`='".$username."'";
          $result= mysql_query($query,$link) or die ("資料庫連線異常，請檢察網路設定或聯絡系統管理員".mysql_error());

          //add problem's wa
          $query = "SELECT `wa` FROM `problemSet` WHERE `pid`='".$pid."'";
          $result= mysql_query($query,$link) or die ("資料庫連線異常，請檢察網路設定或聯絡系統管理員".mysql_error());
          $wanum = mysql_fetch_row($result,MYSQL_ASSOC);
          $wa = $wanum['wa']+1;
          $query = "UPDATE `problemSet` SET `wa`='".$wa."' WHERE `pid`='".$pid."'";
          $result= mysql_query($query,$link) or die ("資料庫連線異常，請檢察網路設定或聯絡系統管理員".mysql_error());
        }
      }

    }
}
?>

<head>
  <link rel="stylesheet" href="css/main.css">
  <meta charset="utf-8">
</head>

<div id="wrap">
  <section id="Main" class="container clearfix" style="background-color:#FCFCFC">
    <div class="aboutMe">
      <h1>NCKU判題君 - 初號機</h1>
      <hr>
      <img src="http://41.media.tumblr.com/tumblr_lvrf58vBkL1qibz0jo1_r1_500.png">
    </div>
    <div class="areyouREADY">
      <?php
        while(1){
          survey($link);
          sleep(60);// 等待5s
        }
      ?>
    </div>
  </section>
</div>
<?php
  require_once("../template/footer.html");
?>
