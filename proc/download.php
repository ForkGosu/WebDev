<?php require_once($_SERVER['DOCUMENT_ROOT'].'/lib/database.php'); ?>
<?php
    $file = BoardFileView($_REQUEST['idx']); 

    if(!isset($file)){
        // 존재하지 않은 파일
        exit;
    }
    $file_path = $file['name_save'];
    $file_name = $file['name_origin'];

    if (!file_exists($file_path)) {
        die("File not found.");
    }

    // 파일 다운로드 처리
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . $file_name . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file_path));
    flush(); // 출력 버퍼를 비우고 시스템 명령어를 실행
    readfile($file_path);
    exit;
?>