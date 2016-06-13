<?php
  require_once("template/navbar.php");
  require("config/config.php");
?>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="css/formBoard.css">
  <link rel="stylesheet" href="css/main.css">
</head>

<script>
  var SubmitForm=function(){
    $.ajax({
        url: "action.php",
        data: $('#user-information').serialize(),
        type:"POST",
        dataType:'text',

        success: function(response){
          //alert(response);
          if(response == "Success"){
            document.location.href="index.php";
          }else{
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

  var checkName=function(){
    if($("#name").val()==""){
      $('#name').parent().addClass("has-error");
      $('#nameFeedback').html("帳號欄不可為空");
			$('#nameFeedback').fadeIn("slow");
      return false;
    }else{
      $('#name').parent().removeClass("has-error");
      $('#name').parent().addClass("has-success");
      $('#nameFeedback').fadeOut();
      return true;
    }
  }

  var checkPassword=function(){
    if($("#pw").val()==""){
      $('#pw').parent().addClass("has-error");
      $('#pwFeedback').html("密碼欄不可為空");
      $('#pwFeedback').fadeIn("slow");
      return false;
    }else{
      $('#pw').parent().removeClass("has-error");
      $('#pw').parent().addClass("has-success");
      $('#pwFeedback').fadeOut();
      return true;
    }
  }

  var checkPasswordRepeat=function(){
    if($("#pw").val()!=$("#pwr").val()){
      $('#pwr').parent().addClass("has-error");
      $('#pwrFeedback').html("輸入的密碼不一致");
      $('#pwrFeedback').fadeIn("slow");
      return false;
    }else{
      $('#pwr').parent().removeClass("has-error");
      $('#pwr').parent().addClass("has-success");
      $('#pwrFeedback').fadeOut();
      return true;
    }
  }

  var checkEmail=function(){
    if($("#ea").val()==""){
      $('#ea').parent().addClass("has-error");
      $('#emailFeedback').html("E-mail欄不可為空");
      $('#emailFeedback').fadeIn("slow");
      return false;
    }else{
      $('#ea').parent().removeClass("has-error");
      $('#ea').parent().addClass("has-success");
      $('#emailFeedback').fadeOut();
      return true;
    }
  }

  var SubmitCheck=function(){
    if(checkName()&&checkPassword()&&checkPasswordRepeat()&&checkEmail()){
      SubmitForm();
    }else{
      /*
      alert(checkName());
      alert(checkPassword());
      alert(checkPasswordRepeat());
      alert(checkEmail());
      */
    }
  }

</script>
<div id="wrap">
  <section id="Main" class="container border-box">
    <div class="form-container">
      <h2 class="form-title">用戶註冊</h2>
      <form id="user-information" method="post">
        <input type="hidden" name="action" value="1">
        <div class="form-group">
          <label for="exampleInputEmail1">用戶名稱</label>
          <input type="text" class="form-control" id="name" name="name" placeholder="請輸入帳號名稱" onkeyup="checkName()">
          <div class="feedback" id="nameFeedback"></div>
        </div>
        <div class="form-group">
          <label for="exampleInputPassword1">用戶密碼</label>
          <input type="password" class="form-control" id="pw" name="password" placeholder="請輸入密碼" onkeyup="checkPassword()">
          <div class="feedback" id="pwFeedback"></div>
        </div>
        <div class="form-group">
          <label for="exampleInputPassword1">密碼確認</label>
          <input type="password" class="form-control" id="pwr" placeholder="請重複輸入密碼" onkeyup="checkPasswordRepeat()">
          <div class="feedback" id="pwrFeedback"></div>
        </div>
        <div class="form-group">
          <label for="exampleInputPassword1">E-Mail</label>
          <input type="text" class="form-control" id="ea" name="email" placeholder="請輸入E-Mail地址" onkeyup="checkEmail()">
          <div class="feedback" id="emailFeedback"></div>
        </div>
        <div class="feedback" id="response-text"></div>
        <button type="button" class="btn btn-info" style="float:right;" onclick="SubmitCheck()">提交</button>
      </form>
    </div>
  </section>
</div>
<?php
  require_once("template/footer.html");
?>
