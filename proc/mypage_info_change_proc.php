<?php require_once($_SERVER['DOCUMENT_ROOT'].'/lib/database.php'); ?>

<?php session_start(); ?>
<?php if (!isset($_SESSION['id']) || $_SESSION['id'] == ""){ ?>
  <script>
  alert("잘못된 접근입니다");
  </script>
<?php exit; } ?>

<?php $updateIdx = MypageInfoChange($_REQUEST['name'], $_REQUEST['address'], $_REQUEST['postcode'], $_SESSION['id'], $_REQUEST['pass']); ?>

<?php if ($updateIdx == 0){ ?>
  <script>
    alert("개인정보 수정이 되지않았습니다!");
    location.href="/mypage";
  </script>
<?php } else { ?>
  <script>
    alert("개인정보 수정 완료!");
    location.href="/mypage";
  </script>
<?php } ?>