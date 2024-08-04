<?php require_once($_SERVER['DOCUMENT_ROOT'].'/lib/database.php'); ?>

<?php session_start(); ?>
<?php if (!isset($_SESSION['id']) || $_SESSION['id'] == ""){ ?>
  <script>
    alert("글 작성 시 로그인이 필요합니다");
  </script>
<?php exit; } ?>

<?php $board_view = BoardView($_REQUEST['idx']);?>
<?php if(!isset($_SESSION['id']) || $_SESSION['id'] != $board_view['writer']){ ?>
<script>
  alert("잘못된 접근입니다");
  history.back();
</script>
<?php exit; }?>

<?php $updateIdx = BoardUpdate($_REQUEST['idx'], $_REQUEST['subject'], $_REQUEST['content'], $_SESSION['id']); ?>

<?php if ($updateIdx){ ?>
  <script>
    alert("수정 완료!");
    location.href="/board/board_view.php?idx=<?=$updateIdx?>";
  </script>
<?php } else { ?>
  <script>
    alert("수정 실패!");
  </script>
<?php } ?>