<script>
document.addEventListener('DOMContentLoaded', function () {
    // 비밀번호를 입력받는 prompt를 표시
    var password = prompt("비밀번호를 입력하세요:");

    if (password !== null) {
        // 입력받은 비밀번호를 hidden input의 value로 설정
        document.getElementById('pass').value = password;
        
        // 폼을 자동으로 제출
        document.getElementById('boardForm').submit();
    } else {
        alert("비밀번호 입력이 취소되었습니다.");
    }
});
</script>


<form action="/board_inquiry/board_view.php" id="boardForm" method="POST">
  <input name="idx" type="hidden" value="<?=$_REQUEST['idx']?>">
  <input name="board_type" type="hidden" value="inquiry">
  <input name="pass" id="pass" type="hidden">
</form>
