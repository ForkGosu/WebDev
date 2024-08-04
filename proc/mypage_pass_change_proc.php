<?php require_once($_SERVER['DOCUMENT_ROOT'].'/lib/database.php'); ?>

<?php session_start(); ?>
<?php if (!isset($_SESSION['id']) || $_SESSION['id'] == ""){ ?>
  <script>
  alert("잘못된 접근입니다");
  </script>
<?php exit; } ?>

<?php $updateIdx = MypagePassChange($_SESSION['id'], $_REQUEST['pass_change'], $_REQUEST['pass_origin']); ?>

<?php if ($updateIdx == 0){ ?>
  <script>
    alert("비밀번호 수정 실패!");
    location.href="/mypage/pass_change.php";
  </script>
<?php } else { ?>
  <script>
    alert("비밀번호 수정 완료!");
    location.href="/";
  </script>
<?php } ?>