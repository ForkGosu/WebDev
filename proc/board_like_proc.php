<?php require_once($_SERVER['DOCUMENT_ROOT'].'/lib/database.php'); ?>
<?php session_start(); ?>
<?php if (!isset($_SESSION['id']) || $_SESSION['id'] == ""){ ?>
  <script>
    alert("추천은 로그인이 필요합니다");
    location.href="/";
  </script>
<?php exit; } ?>

<?php $likeIdx = BoardLike($_SESSION['idx'], $_REQUEST['idx']); // request는 board_idx ?>

<?php 
if ($likeIdx) {
  BoardLikeCount($_REQUEST['idx']);
  echo json_encode(['result' => 1]);
} else {
  echo json_encode(['result' => 0]);
}
?>