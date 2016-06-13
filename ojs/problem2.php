<html>
  <head>
    <script>
    var SubmitForm=function(){
      $.ajax({
          url: "action.php",
          data: "action = 8" + "&pid =" + $('#pid').value + "&username" + $('#username').value,
          type:"POST",
          dataType:'text',

          success: function(response){
            alert(response);
            if(response == "Success"){
              $('#response-text').html(response);
              $('#response-text').fadeIn("slow");
            }
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
  <body>
    <?php
      include "config/config.php";
      $pid=$_GET["pid"];
      if(isset($_SESSION["username"])){
          $username = $_SESSION["username"];
          $query="SELECT pid FROM `star` WHERE username='".$username."'";
          $result=mysql_query($query,$link);
          $check = 0;
          while($rows=mysql_fetch_array($result,MYSQL_ASSOC)){
            if($pid = $row["pid"])
              $check = 1;
          }
          if($check == 1)
            print '<div id="response-text" class="feedback">star</div>';
          else
            print '<div id="response-text" class="feedback">unstar</div>';
      }
      else
        $username = 0;
      $query="SELECT ptitle,pdetail,pinput,poutput FROM `problemSet` WHERE pid='".$pid."'";
      $result=mysql_query($query,$link);
      $rows=mysql_fetch_array($result,MYSQL_ASSOC);
      print '<input id = "action" name="action" type = "hidden" value = "8">
          <input id = "username" name = "name" type = "hidden" value = "'.$username.'">
          <input id = "pid" name = "pid" type = "hidden" value = "'.$pid.'">
          <h2 name="ptitle">'.$rows["ptitle"].'</h2>
          <h3> Description</h3>
          <p name="pdetail">'.$rows["pdetail"].'</p>
          <h3> Test input</h3>
          <p name="pinput">'.$rows["pinput"].'</p>
          <h3> Test Output </h3>
          <p name="poutput">'.$rows["poutput"].'</p>';
    ?>
  </body>
</html>
