<?php
session_start();
session_destroy();
?>
<script>
    alert("성공적으로 로그아웃 하였습니다");
    window.history.go(-1);
</script>