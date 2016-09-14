<?php
  require_once("template/navbar.php");
  require("config/config.php");
?>

<head>
  <link rel="stylesheet" href="css/main.css">
  <meta charset="utf-8">
  <title>ProblemSet</title>

  <script>

    var fillTable=function(){

      var query = $('#query').val();
      var command = "action=9527";
      if(query){
        command = command + "&&query=";
        command = command + query;
      }
      //alert(command);
      $.ajax({
          url: "action.php",
          data: command,
          type:"POST",
          dataType:'text',

          success: function(list){
            $('#problem-List').html(list);
          },

          error:function(xhr, ajaxOptions, thrownError){
            alert("ERROR");
            alert(xhr.status);
            alert(thrownError);
          }
      });

    }

    fillTable();
  </script>

</head>

<div id="wrap">
  <section id="Main" class="container clearfix border-box">
    <div class="block">
      <div class="searchBlock">
        <div class="input-group">
          <input id="query" type="text" class="form-control" placeholder="Search for the problem title">
          <span class="input-group-btn">
            <button class="btn btn-success" type="button" onclick="fillTable()">Search</button>
          </span>
        </div><!-- /input-group -->
      </div>
        <table class="table table-hover table-bordered table-striped alignCenter problem-table">
          <thead>
            <tr>
              <th class="alignCenter " style="width:7%">#</th>
              <th class="alignCenter" style="width:60%">Problem title</th>
              <th class="alignCenter" style="width:12%">Solved</th>
              <th class="alignCenter">Accepted Rate</th>
            </tr>
          </thead>
          <tbody id="problem-List">

          </tbody>
      </table>
    </div>
  </section>
</div>
<?php
  require_once("template/footer.html");
?>
