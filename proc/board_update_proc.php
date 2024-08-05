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

<?php
  if(isset($_FILES["fileUpload"])){
    if($_FILES['fileUpload']['error'] === UPLOAD_ERR_NO_FILE){
      $file_idx = $_REQUEST['file_idx'];
    } else {
      $uploadDir = "../uploads/"; // 업로드 디렉토리 경로

      $maxFileSize = 5 * 1024 * 1024; // 5MB
    
      // 업로드된 파일의 정보를 가져옵니다.
      $fileName = $_FILES["fileUpload"]["name"];
      $fileTmpName = $_FILES["fileUpload"]["tmp_name"];
      $fileSize = $_FILES["fileUpload"]["size"];
    
      // 파일 확장자를 체크하고 허용되는 확장자를 지정합니다.
      $allowedExtensions = ["jpg", "jpeg", "png", "gif"];
      $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    
      if (in_array($fileExtension, $allowedExtensions)) {
        // 파일 크기를 체크하고 원하는 크기로 제한합니다.
        if ($fileSize <= $maxFileSize) {
          // 새로운 파일 이름을 생성합니다.(알아내지 못하게 하기 위함)
          $newFileName = uniqid() . "." . $fileExtension;
          $uploadPath = $uploadDir . $newFileName;
    
          // 임시 파일의 경로를 UTF-8로 변환합니다.
          $utf8TmpFileName = mb_convert_encoding($fileTmpName, 'UTF-8', 'auto');
    
          // 파일을 이동시킵니다.
          if (move_uploaded_file($utf8TmpFileName, $uploadPath)) {
            echo "파일 업로드 성공: " . $newFileName;
          } else {
            echo "파일 업로드 실패.";
          }
        } else {
          echo "파일 크기가 너무 큽니다. 최대 파일 크기는 " . ($maxFileSize / (1024 * 1024)) . "MB입니다.";
        }
      } else {
        echo "지원하지 않는 파일 형식입니다. jpg, jpeg, png, gif 파일만 허용됩니다.";
      }
      $file_idx = BoardFileUpload($fileName, $uploadPath);
    }
  }
?>

<?php $updateIdx = BoardUpdate($_REQUEST['idx'], $_REQUEST['subject'], $_REQUEST['content'], $_SESSION['id'], $file_idx); ?>

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