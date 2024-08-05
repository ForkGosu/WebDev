<?php require_once($_SERVER['DOCUMENT_ROOT'].'/lib/database.php'); ?>
<?php session_start(); ?>

<?php if(!$_REQUEST['idx']){ ?>
<script>
  alert("잘못된 접근입니다");
  history.back();
</script>
<?php exit; } ?>
<?php
  $isLogin = false;
  if(isset($_SESSION['id']) && $_SESSION['id'] != ""){
    $isLogin = true;
  }
?>


<?php BoardViewCount($_REQUEST['idx']) ?>

<?php $board_view = BoardView($_REQUEST['idx'], "normal");?>
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

<?php 
if (isset($board_view['file_idx'])){
  $file = BoardFileView($board_view['file_idx']); 
}
?>


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
          <blockquote><h3><?= htmlspecialchars($board_view['subject']) ?></h3></blockquote>
          <div class="d-flex mb-4 justify-content-end">
            <div>
              <ul class="list-inline text-muted small mb-0">
                <li class="list-inline-item"><i class="fa fa-user-circle-o"></i> <?= htmlspecialchars($board_view['writer']) ?></li>
                <li class="list-inline-item"><i class="fa fa-clock-o"></i> <?= date('Y-m-d', $board_view['wdate']); ?></li>
                <li class="list-inline-item"><i class="fa fa-eye"></i> <?= $board_view['view'] ?> 회</li>
              </ul>
            </div>
          </div>
          <!-- 내용 -->
          <div class="d-flex m-4 justify-content-start">
            <?= htmlspecialchars($board_view['content']) ?>
          </div>
          <?php if(isset($file)){ ?>
          <li class="list-group-item">
            <small class="text-muted"><i class="fa fa-download"></i></small>
            <a href="/proc/download.php?idx=<?=$file['idx']?>" class="text-dark"><?=$file['name_origin']?></a> <small class="text-muted"><- 파일 다운로드</small>
          </li>
          <?php } ?>
          <!-- 추천 -->
          <?php if($isLogin){ ?>
          <a href="" id="good_button" class="btn btn-outline-primary m-4"><i class="fa fa-thumbs-up"></i> <strong><?=$board_view['like']?></strong></a>
          <?php } else { ?>
          <a href="" id="good_button" class="btn btn-outline-primary m-4 disabled"><i class="fa fa-thumbs-up"></i> <strong><?=$board_view['like']?></strong></a>
          <?php } ?>
          
          <!-- 버튼 -->
          <p class="lead">
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
              <?php if((isset($_SESSION['id']) && $_SESSION['id'] == $board_view['writer']) || $_SESSION['id'] == "admin"){ ?>
                <button class="btn btn-primary" type="button" onClick="location.href='board_update.php?idx=<?=$_REQUEST['idx']?>&board_type=normal'"><i class="fa fa-pencil" aria-hidden="true"></i> 수정하기</button>
                <button class="btn btn-primary" type="button" onClick="location.href='/proc/board_delete_proc.php?idx=<?=$_REQUEST['idx']?>&board_type=normal'"><i class="fa fa-times" aria-hidden="true"></i> 삭제하기</button>
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

<script>
$(document).ready(function() {
$('#good_button').click(function(event) {
  event.preventDefault(); // 링크 클릭 기본 동작 방지

  $.ajax({
    url: '/proc/board_like_proc.php',
    type: 'POST',
    dataType: 'json',
    data: {
      idx: <?=$board_view['idx']?>, // 게시물 idx
    },
    success: function(response) {
      if (response.error) {
        alert(response.error); // 에러 메시지 표시
      } else {
        if (response.result == 1) {
          alert('추천이 완료되었습니다.'); // 결과가 1일 때
          var likeCount = parseInt($('#good_button strong').text(), 10); // 현재 숫자 가져오기
          $('#good_button strong').text(likeCount + 1); // 숫자 +1로 업데이트
          // $('#good_button').addClass('disabled'); // 추천 후 버튼 비활성화
        } else if (response.result == 0) {
          alert('추천을 취소하였습니다.'); // 결과가 0일 때
          var likeCount = parseInt($('#good_button strong').text(), 10); // 현재 숫자 가져오기
          $('#good_button strong').text(likeCount - 1); // 숫자 -1로 업데이트
          // $('#good_button').addClass('disabled'); // 추천 후 버튼 비활성화
        }
      }
    },
    error: function() {
        alert('서버 오류가 발생했습니다.');
    }
  });
});
});
</script>