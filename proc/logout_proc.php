<?php
session_start();
session_destroy(); // 세션 초기화해서 로그아웃
?>
<script>
    alert("성공적으로 로그아웃 하였습니다");
    // window.history.go(-1);
    location.href="/";
</script>