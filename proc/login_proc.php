<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/lib/database.php');

session_start();

// 정규 표현식
$pattern = '/^[a-z0-9_]{5,20}$/';

// 정규 표현식 검사(아이디 확인)
if (!preg_match($pattern, $_POST['id'])) {
?>
<script>
  alert("로그인에 실패했습니다");
  window.history.go(-1);
</script>
<?php
  // 아이디 확인 불능 시 잘못됨
  exit;
} 

$user = UserLogin($_POST['id'],$_POST['pw']);

if ($user){
  $_SESSION['id'] = $user['id'];
  header("location: {$_SERVER['HTTP_REFERER']}");
  exit;
}
?>
<script>
    alert("로그인에 실패했습니다");
    window.history.go(-1);
</script>