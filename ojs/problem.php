<?php
  require_once("template/navbar.php");
  require("config/config.php");
?>
<?php
  //load the file content...
  $pid=$_GET["pid"];
  $query="SELECT * FROM `problemSet` WHERE pid='".$pid."'";
  $result=mysql_query($query,$link);
  $rows=mysql_fetch_array($result,MYSQL_ASSOC);

  $title = nl2br($rows["ptitle"]);
  $inputdetail = nl2br($rows["pinputformat"]);
  $outputdetail = nl2br($rows["poutputformat"]);
  $detail = nl2br($rows["pdetail"]);
  $input = nl2br($rows["pinput"]);
  $output = nl2br($rows["poutput"]);
?>
  <head>
    <link rel="stylesheet" href="css/main.css">
    <meta charset="utf-8">
    <script>
    var star=function(){
      $.ajax({
          url: "action.php",
          data: {action:"8",pid:$('#pid').val(),username:$('#username').val()},
          type:"POST",
          dataType:'text',

          success: function(response){
              $('#response-text').html(response);
              $('#response-text').fadeIn("slow");
          },

          error:function(xhr, ajaxOptions, thrownError){
            alert("ERROR");
            alert(xhr.status);
            alert(thrownError);
          }
      });
    }
    </script>
  </head>
  <body style="background-color:#FCFCFC">
  <div id="wrap">
    <section id="Main" class="container clearfix" style="background-color:#FCFCFC">
      <div class="problem">
        <div class="ptitle"><?php echo "<h1>$title</h1>";?>        <?php if(isset($_SESSION["username"])){
                    $username = $_SESSION["username"];
                    print '<input type="hidden" id="pid" value="'.$pid.'"><input type="hidden" id="username" value="'.$username.'">';
                    $query="SELECT * FROM `star` WHERE username='".$username."' and pid='".$pid."'";
                    $result=mysql_query($query,$link);
                    $check = 0;
                    if($rows=mysql_fetch_array($result,MYSQL_ASSOC)){
                        $check = 1;
                    }
                    if($check == 0){
                      print '<div class="alignRight"><a id="response-text"  onclick="star()" class="btn btn-success starbtn">Star</a></div>';
                    }
                    else{
                      print '<div class="alignRight"><a id="response-text"  onclick="star()" class="btn btn-success starbtn">Unstar</a></div>';
                    }
                }?>
        </div>
        <div class="pcontent">
          <h3>Description</h3>
          <p><?php echo "$detail";?></p>
          <h3>Input</h3>
          <p><?php echo "$inputdetail";?></p>
          <h3>Output</h3>
          <p><?php echo "$outputdetail";?></p>
          <h3>Sample Input</h3>
            <div class="codeblock">
              <?php echo "$input";?>
            </div>
          <h3>Sample Output</h3>
            <div class="codeblock">
              <?php echo "$output";?>
            </div>
        </div>

        <div class="submitButton">
          <a type="button" href="submit.php?pid=<?php echo"$pid";?>" class="btn btn-success">Submit your code</a>
        </div>
      </div>
    </section>
  </div>
  </body>
<?php
require_once("template/footer.html");
?>
