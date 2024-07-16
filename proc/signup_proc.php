<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/lib/database.php');

session_start();

// 정규 표현식
$pattern = '/^[a-z0-9_]{5,20}$/';

// 정규 표현식 검사(아이디 확인)
if (!preg_match($pattern, $_POST['id'])) {
?>
<script>
  alert("잘못된 입력값으로 인해 회원가입에 실패했습니다");
  window.history.go(-1);
</script>
<?php
  // 아이디 확인 불능 시 잘못됨
  exit;
} 

$is_create = UserSignup($_POST['id'],$_POST['pw'], $_POST['name'], $_POST['postcode'], $_POST['address']);

if ($is_create){ ?>
<script>
  alert("축하합니다 회원가입이 완료되었습니다");
  window.history.go(-1);
</script>
<?php } else { ?>
<script>
  alert("잘못된 입력값으로 인해 회원가입에 실패했습니다");
  window.history.go(-1);
</script>
<?php } ?>