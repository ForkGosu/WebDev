<?php session_start(); ?>
<?php if (!isset($_SESSION['id']) || $_SESSION['id'] == ""){ ?>
  <script>
    alert("글 작성 시 로그인이 필요합니다");
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
          <form action="/proc/board_write_proc.php" id="boardForm" method="POST" enctype="multipart/form-data">
            <blockquote><h3>새 글 작성하기</h3></blockquote>
            <!-- 제목 -->
            <input class="board_subject" name="subject" type="text" placeholder="제목">
            <!-- 내용 -->
            <textarea class="board_content" name="content" placeholder="내용"></textarea>
            <!-- 파일 삽입 -->
            <div class="mb-3">
              <label for="formFile" class="form-label">파일 업로드는 최대 5MB까지 가능 합니다</label>
              <input class="form-control" type="file" name="fileUpload" id="formFile">
            </div>
            <!-- 버튼 -->
            <p class="lead">
              <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button class="btn btn-primary" type="submit"><i class="fa fa-pencil" aria-hidden="true"></i> 작성완료</button>
                <button class="btn btn-primary" type="button"><i class="fa fa-times" aria-hidden="true"></i> 취소</button>
              </div>
            </p>
          </form>
        </main>
        <!-- footer 추가 -->
        <?php require_once($_SERVER['DOCUMENT_ROOT'].'/include/footer.php'); ?>
    </div>
</body>

</html>