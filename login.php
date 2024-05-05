<?php
    require_once('login_func.php');
?>
<html>

<head>
    <title>로그인 페이지</title>
    <link rel="stylesheet" href="./css/login.css">
    <script src="./js/login.js" defer></script>
</head>

<body>
<div class="wrapper">
  <div class="container">
    <div class="sign-in-container">
        <form method="POST" action="">
        <h1>Sign In</h1>
        <div class="social-links">
          <div>
            <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
          </div>
          <div>
            <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
          </div>
          <div>
            <a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
          </div>
        </div>
        <span>위의 버튼은 간지 입니다</span>
        <input type="text" name="UserId" placeholder="아이디를 입력하세요">
        <input type="password" name="Password" placeholder="비밀번호를 입력하세요">
        <button name="Submit" value="Login" type="submit" class="form_btn">로그인</button>
      </form>
    </div>
    <div class="overlay-container">
      <div class="overlay-left">
        <h1>Welcome Back</h1>
        <p>To keep connected with us please login with your personal info</p>
        <button id="signIn" class="overlay_btn">Sign In</button>
      </div>
      <div class="overlay-right">
        <p>임시 로그인 페이지 입니다.</p><p> 당장 로그인해 주세요.</p>
      </div>
    </div>
  </div>
    <?php
    if(isset($_POST['Submit'])){
      $login_res=login1($_POST['userId'], $_POST['Password']);
      
      if($login_res) {
        header("location:index.php?login_id=".$login_res);
        exit;
      } else { ?>
        <div class="error-message">
          <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <strong>Warning!</strong> Incrrect information.
          </div>
        </div>
    <?php } } ?>
</div>
</body>

</html>