<?php require_once($_SERVER['DOCUMENT_ROOT'].'/lib/database.php'); ?>

<?php session_start(); ?>
<?php if (!isset($_SESSION['id']) || $_SESSION['id'] == ""){ ?>
  <script>
    alert("글 작성 시 로그인이 필요합니다");
  </script>
<?php exit; } ?>

<?php $writeIdx = BoardWrite($_REQUEST['subject'], $_REQUEST['content'], $_SESSION['id']); ?>

<?php if ($writeIdx){ ?>
  <script>
    alert("작성 완료!");
    location.href="/board/board_view.php?idx=<?=$writeIdx?>";
  </script>
<?php } else { ?>
  <script>
    alert("작성 실패!");
  </script>
<?php } ?>