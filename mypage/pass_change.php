<?php require_once($_SERVER['DOCUMENT_ROOT'].'/lib/database.php'); ?>
<?php session_start(); ?>
<?php if(!isset($_SESSION['id'])){ ?>
<script>
  alert("잘못된 접근입니다");
  location.href="/";
</script>
<?php exit; }?>

<?php $mypage_info = MypageInfo($_SESSION['id']);?>



<!doctype html>
<html lang="en" class="h-100">

<!-- Head 추가 -->
<?php require_once($_SERVER['DOCUMENT_ROOT'].'/include/head.php'); ?>

<!-- Body 시작 -->
<body class="d-flex h-100 text-center text-white bg-dark">

    <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
        <!-- header 추가 -->
        <?php require_once($_SERVER['DOCUMENT_ROOT'].'/include/header.php'); ?>

        <main class="px-3">
          <!-- 마이페이지 제목 -->
          <h1>마이페이지</h1>
          <h1>___</h1>
            <!-- 폼 -->
                <form action="/proc/mypage_pass_change_proc.php" id="mypageForm" method="POST" class="text-black-50">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-4" id="mypage_id" name="id" placeholder="ID" value="<?=$mypage_info['id']?>" disabled>
                        <label for="mypage_id">아이디</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control rounded-4" id="mypage_pw_origin" name="pass_origin" placeholder="Password">
                        <label for="mypage_pw_origin">현재 비밀번호</label>
                        <span id="mypage_pw_origin_about" style="font-size: 0.8rem; font-weight: 900;" class="text-danger"></span>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control rounded-4" id="mypage_pw" name="pass_change" placeholder="Password">
                        <label for="mypage_pw">바꿀 비밀번호</label>
                        <span id="mypage_pw_about" style="font-size: 0.8rem; font-weight: 900;" class="text-danger"></span>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control rounded-4" id="mypage_pw_check" placeholder="Password">
                        <label for="mypage_pw_check">바꿀 비밀번호 확인</label>
                        <span id="mypage_pw_check_about" style="font-size: 0.8rem; font-weight: 900;" class="text-danger"></span>
                    </div>
                    <button class="w-100 mb-2 btn btn-lg rounded-4 btn-primary" type="submit" onclick="">비밀번호 수정</button>
                    <button type="button" class="w-100 mb-2 btn btn-lg rounded-4 btn-success" onclick="location.href='.'">
                        회원정보 수정으로 이동
                    </button>
                    <hr class="my-4">
                </form>
        </main>
        <!-- footer 추가 -->
        <?php require_once($_SERVER['DOCUMENT_ROOT'].'/include/footer.php'); ?>
    </div>
</body>

</html>
<script>
    // 회원가입 비밀번호 확인
    $(document).ready(function() {
        $('#mypage_pw').focusout(function() {
            const inputValue = $('#mypage_pw').val();
            const regex = /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$ %^&*-]).{8,16}$/

            $('#mypage_pw').removeClass('border-success');
            $('#mypage_pw_about').removeClass('text-success');
            $('#mypage_pw').removeClass('border-danger');
            $('#mypage_pw_about').removeClass('text-danger');

            // 8 ~ 16자의 영문 대/소문자, 숫자, 특수문자를 모두 사용해 주세요.
            if (!regex.test(inputValue)) {
                $('#mypage_pw').addClass('border-danger');
                $('#mypage_pw_about').addClass('text-danger');
                $('#mypage_pw_about').html('8 ~ 16자의 영문 대/소문자, 숫자, 특수문자를 하나씩 사용해 주세요');
            } else {
                $('#mypage_pw').addClass('border-success');
                $('#mypage_pw_about').addClass('text-success');
                $('#mypage_pw_about').html('사용 가능한 비밀번호 입니다');
            }

            $('#mypage_pw_check').removeClass('border-success');
            $('#mypage_pw_check_about').removeClass('text-success');
            $('#mypage_pw_check').removeClass('border-danger');
            $('#mypage_pw_check_about').removeClass('text-danger');

            // 비밀번호 비교
            if ($('#mypage_pw_check').val() == "" || $('#mypage_pw_check').val() != $('#mypage_pw').val()) {
                $('#mypage_pw_check').addClass('border-danger');
                $('#mypage_pw_check_about').addClass('text-danger');
                $('#mypage_pw_check_about').html('비밀번호가 서로 다릅니다');
            } else {
                $('#mypage_pw_check').addClass('border-success');
                $('#mypage_pw_check_about').addClass('text-success');
                $('#mypage_pw_check_about').html('비밀번호 일치가 확인 되었습니다');
            }
        });
    });
    
    // 회원가입 비밀번호 Check 확인
    $(document).ready(function() {
        $('#mypage_pw_check').focusout(function() {
            $('#mypage_pw_check').removeClass('border-success');
            $('#mypage_pw_check_about').removeClass('text-success');
            $('#mypage_pw_check').removeClass('border-danger');
            $('#mypage_pw_check_about').removeClass('text-danger');

            // 비밀번호 비교
            if ($('#mypage_pw_check').val() == "" || $('#mypage_pw_check').val() != $('#mypage_pw').val()) {
                $('#mypage_pw_check').addClass('border-danger');
                $('#mypage_pw_check_about').addClass('text-danger');
                $('#mypage_pw_check_about').html('비밀번호가 서로 다릅니다');
            } else {
                $('#mypage_pw_check').addClass('border-success');
                $('#mypage_pw_check_about').addClass('text-success');
                $('#mypage_pw_check_about').html('비밀번호 일치가 확인 되었습니다');
            }
        });
    });
    
    // 회원가입 시 폼 확인
    $(document).ready(function() {
        $('#mypageForm').on('submit', function(event) {
            // 비밀번호 비교
            if ($('#mypage_pw_check').val() == "") {
                $('#mypage_pw_check_about').addClass('text-danger');
                $('#mypage_pw_check_about').html('회원정보 수정 시 현재 비밀번호 입력이 필요합니다');
                return false;
            }
            
            if(!$('#mypage_pw_about').hasClass('text-success')){
                alert("변경할 비밀번호를 확인해주세요");
                return false;
            }

            if(!$('#mypage_pw_check_about').hasClass('text-success')){
                alert("변경할 비밀번호 확인을 확인해주세요");
                return false;
            }

            this.submit();
            return true
        });
    });

</script>