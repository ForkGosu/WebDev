<?php require_once($_SERVER['DOCUMENT_ROOT'].'/lib/database.php'); ?>
<?php if(!$_REQUEST['idx']){ ?>
<script>
  alert("잘못된 접근입니다");
  history.back();
</script>
<?php exit; } ?>

<?php BoardViewCount($_REQUEST['idx']) ?>

<?php $board_view = BoardView($_REQUEST['idx']);?>
<?php if(!$board_view){ ?>
<script>
  alert("잘못된 접근입니다");
  history.back();
</script>
<?php exit; } ?>

<?php if($board_view['isDelete'] == 1){ ?>
<script>
  alert("잘못된 접근입니다");
  history.back();
</script>
<?php exit; } ?>



<!doctype html>
<html lang="ko" class="h-100">

<!-- Head 추가 -->
<?php require_once($_SERVER['DOCUMENT_ROOT'].'/include/head.php'); ?>

<!-- Body 시작 -->
<body class="d-flex h-100 text-center text-white bg-dark">

    <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
        <!-- header 추가 -->
        <?php require_once($_SERVER['DOCUMENT_ROOT'].'/include/header.php'); ?>
        
        <!-- main 시작 -->
        <main class="px-3">
          <!-- 제목 -->
          <blockquote><h3><?=$board_view['subject']?></h3></blockquote>
          <div class="d-flex mb-4 justify-content-end">
            <div>
              <ul class="list-inline text-muted small mb-0">
                <li class="list-inline-item"><i class="fa fa-user-circle-o"></i> <?= $board_view['writer'] ?></li>
                <li class="list-inline-item"><i class="fa fa-clock-o"></i> <?= date('Y-m-d', $board_view['wdate']); ?></li>
                <li class="list-inline-item"><i class="fa fa-eye"></i> <?= $board_view['view'] ?> 회</li>
              </ul>
            </div>
          </div>
          <!-- 내용 -->
          <div class="d-flex m-4 justify-content-start">
            <?= $board_view['content'] ?>
          </div>
          <!-- 버튼 -->
          <p class="lead">
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
              <?php if(isset($_SESSION['id']) && $_SESSION['id'] == $board_view['writer']){ ?>
                <button class="btn btn-primary" type="button" onClick="location.href='board_update.php?idx=<?=$_REQUEST['idx']?>'"><i class="fa fa-pencil" aria-hidden="true"></i> 수정하기</button>
                <button class="btn btn-primary" type="button" onClick="location.href='/proc/board_delete_proc.php?idx=<?=$_REQUEST['idx']?>'"><i class="fa fa-times" aria-hidden="true"></i> 삭제하기</button>
              <?php } ?>
              <button class="btn btn-primary" type="button" onClick="location.href='board_list.php'"><i class="fa fa-list" aria-hidden="true"></i> 목록으로</button>
            </div>
          </p>
        </main>
        <!-- footer 추가 -->
        <?php require_once($_SERVER['DOCUMENT_ROOT'].'/include/footer.php'); ?>
    </div>
</body>

</html>