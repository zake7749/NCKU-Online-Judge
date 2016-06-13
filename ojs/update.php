<?php
  require_once("template/navbar.php");
  require("config/config.php");
?>
<head>
  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" href="css/profile.css">
  <link rel="stylesheet" href="css/github.css">
  <meta charset="utf-8">
</head>

<script>
  function SubmitThis(){
    $.ajax({
        url: "action.php",
        data: $('#user-information').serialize(),
        type:"POST",
        dataType:'text',

        success: function(response){
          //alert(response);
          if(response == "suc"){
            $('#response-text').html("Your profile has updated.");
          }else{
            $('#response-text').html(response);
            $('#response-text').fadeIn("slow");
          }
        },

        error:function(xhr, ajaxOptions, thrownError){
          //alert("ERROR");
          alert(xhr.status);
          alert(thrownError);
        }
    });
  }
</script>
<?php
  if(!isset($_SESSION["username"])){
    header("location:problemSet.php");
  }
  //select the original value from database;
  $username = $_SESSION["username"];

  $query = "SELECT * FROM `user` WHERE `name`='".$username."'";
  $result= mysql_query($query,$link) or die ("資料庫連線異常，請檢察網路設定或聯絡系統管理員");
  $row = mysql_fetch_row($result,MYSQL_ASSOC);

  $nickname = $row["nickname"];
  $school = $row["school"];
  $location = $row["location"];
  $about = $row["about"];
?>
<div id="wrap">
  <section id="Main" class="container clearfix">
    <div class="profile alignCenter" >

        <div class="profile-edit">
          <div class="profile-info">Edit your profile</div>
          <div class="profile-content">
            <div class="form-container">
              <form id="user-information" method="post" style="margin-top:10px;">
                <input type="hidden" name="action" value="3">
                <input type="hidden" name="username" value="<?php echo $username;?>">
                <div class="form-group">
                  <label for="name">Name</label>
                  <input type="text" class="form-control" id="name" name="name" placeholder="請輸入暱稱" value="<?php echo $nickname ;?>">
                </div>
                <div class="form-group">
                  <label for="school">School</label>
                  <input type="text" class="form-control" id="school" name="school" placeholder="請輸入學校" value="<?php echo $school;?>">
                </div>
                <div class="form-group">
                  <label for="location">Location</label>
                  <input type="text" class="form-control" id="location" name="location" placeholder="請輸入所在地區" value="<?php echo $location;?>">
                </div>
                <div class="form-group">
                  <label for="about">About</label>
                  <input type="text" class="form-control" id="about" name="about" placeholder="和大家聊聊你自己吧~" value="<?php echo $about;?>">
                </div>
                <a type="text" class="btn btn-info" style="float:right;" onclick="SubmitThis()">提交</a>
                <div class="feedback" id="response-text"></div>
              </form>
            </div>
          </div>
          <div id="response-text"></div>
      </div>

    </div>
  </section>
</div>
<?php
  require_once("template/footer.html");
?>
