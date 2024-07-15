<?php
  require_once('./data/session.php');
?>
<html>

<head>
    <title>로그인 페이지</title>
    <link rel="stylesheet" href="/resources/css/login.css">
    <script src="/resources/js/login.js" defer></script>
</head>

<body>
<div class="wrapper">
  <div class="container">
    <div class="sign-up-container">
      <form action="./join_proc.php" method="POST">
        <h1>회원가입</h1>
        <div class="social-links">
          <!-- <div>
            <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
          </div>
          <div>
            <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
          </div>
          <div>
            <a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
          </div> -->
        </div>
        <span>회원가입을 위해 이름, 아이디, 비밀번호 입력</span>
        <input type="text" name="name" placeholder="이름">
        <input type="text" name="id" placeholder="아이디">
        <input type="password" name="pass" placeholder="비밀번호">
        <button class="form_btn">회원가입</button>
      </form>
    </div>
    <div class="sign-in-container">
      <form action="./login_proc.php" method="POST">
        <h1>로그인</h1>
        <div class="social-links">
          <!-- <div>
            <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
          </div>
          <div>
            <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
          </div>
          <div>
            <a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
          </div> -->
        </div>
        <span>로그인을 위해 아이디, 비밀번호 입력</span>
        <input type="text" name="id" placeholder="아이디">
        <input type="password" name="pass" placeholder="비밀번호">
        <button class="form_btn">로그인</button>
      </form>
    </div>
    <div class="overlay-container">
      <div class="overlay-left">
        <h1>환영합니다!</h1>
        <p>완전 환영합니다!</p>
        <button id="signIn" class="overlay_btn">< 로그인으로</button>
      </div>
      <div class="overlay-right">
        <h1>안녕하세요!</h1>
        <p>완전 안녕하세요!</p>
        <button id="signUp" class="overlay_btn">회원가입으로 ></button>
      </div>
    </div>
  </div>
</div>
</body>

</html>