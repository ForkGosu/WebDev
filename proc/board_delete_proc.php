<?php require_once($_SERVER['DOCUMENT_ROOT'].'/lib/database.php'); ?>

<?php session_start(); ?>
<?php if (!isset($_SESSION['id']) || $_SESSION['id'] == ""){ ?>
  <script>
    alert("글 작성 시 로그인이 필요합니다");
  </script>
<?php exit; } ?>

<?php $board_view = BoardView($_REQUEST['idx'], $_REQUEST['board_type']);?>
<?php if((!isset($_SESSION['id']) || $_SESSION['id'] != $board_view['writer']) && $_SESSION['id'] != "admin"){ ?>
<script>
  alert("잘못된 접근입니다");
  history.back();
</script>
<?php exit; }?>

<?php $isDelete = BoardDelete($_REQUEST['idx']); ?>

<?php if ($isDelete){ ?>
  <script>
    alert("삭제 완료!");
    location.href="/board/board_list.php";
  </script>
<?php } else { ?>
  <script>
    alert("삭제 실패!");
  </script>
<?php } ?>