

    <?php
      require_once("template/navbar.php");
      require("config/config.php");
    ?>
    <head>
      <title>Add a problem</title>
      <link rel="stylesheet" href="css/main.css">
      <meta charset="utf-8">
    </head>

    <div id="wrap">
      <section id="Main" class="container clearfix ">
        <div>
<!----------------------------------------------------------------------------------->
          <?php
            if(!isset($_SESSION["priority"])){
              echo "<h1>Please login first</h1>";
              header("Location: problemSet.php");
            }
            if($_SESSION["priority"] > 1){
              if(isset($_GET["check"])){
                $sql="INSERT INTO problemSet(ptitle,pdetail,pinput,poutput,indata,outdata) values ('".$_GET["pname"]."','".mysql_real_escape_string($_GET["ptitle"])."','".$_GET["pinput"]."','".$_GET["poutput"]."','".$_GET["indata"]."','".$_GET["outdata"]."')";
                mysql_query($sql,$link) or die(mysql_error());
                $sql="UPDATE `problemSet`
                SET pinputformat='".mysql_real_escape_string($_GET["pinputformat"])."',poutputformat='".mysql_real_escape_string($_GET["poutputformat"])."' WHERE `ptitle`='".$_GET["pname"]."'";
                //echo($sql);
                mysql_query($sql,$link) or die(mysql_error());
              }
            }else{
              echo "<h1>Permission denied</h1>";
              header("Location: problemSet.php");
            }
           ?>

            <body align="center">
              <form class="addTable" action = "problemAdd.php" method = "get">
                <textarea class="form-control" name="pname" cols="55" rows="2" placeholder="請填入問題名稱"></textarea>
                <h3>Description:</h3>
                <textarea class="form-control" name="ptitle" cols="55" rows="5" placeholder="請填入問題細節"></textarea>
                <h3>Input</h3>
                <textarea class="form-control" name="pinputformat" cols="55" rows="3" placeholder="請填入輸入格式說明"></textarea>
                <h3>Output:</h3>
                <textarea class="form-control" name="poutputformat" cols="55" rows="3" placeholder="請填入輸出格式說明"></textarea>
                <h3>Sample Input:</h3>
                <textarea class="form-control" name="pinput" cols="55" rows="3" placeholder="請填入測試輸入"></textarea>
                <h3>Sample Output:</h3>
                <textarea class="form-control" name="poutput" cols="55" rows="3" placeholder="請填入測試輸出"></textarea>
                <h3>Test Input</h3>
                <textarea class="form-control" name="indata" cols="55" rows="3" placeholder="請填入正式測資"></textarea>
                <h3>Test Output</h3>
                <textarea class="form-control" name="outdata" cols="55" rows="3" placeholder="請填入正式測資之解答"></textarea>
                <input name="check" type="hidden" value="1">
                <div class="alignRight" style="padding:15px 0">
                  <input class="btn btn-primary alignRight" type="submit" value="確認送出">
                </div>
              </form>
<!----------------------------------------------------------------------------------->
        </div>
      </section>
    </div>
    <?php
      require_once("template/footer.html");
    ?>
