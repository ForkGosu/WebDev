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
                <form action="/proc/mypage_info_change_proc.php" id="mypageForm" method="POST" class="text-black-50">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-4" id="mypage_id" name="id" placeholder="ID" value="<?=$mypage_info['id']?>" disabled>
                        <label for="mypage_id">아이디</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-4" id="mypage_name" name="name" placeholder="Name" value="<?=$mypage_info['name']?>">
                        <label for="mypage_name">이름</label>
                    </div>
                    <div class="form-floating mb-3 input-group">
                        <input type="text" class="form-control rounded-4" id="mypage_postcode" name="postcode" placeholder="Postcode" value="<?=$mypage_info['postcode']?>" readonly>
                        <label for="mypage_postcode">우편번호</label>
                        <button class="btn btn-outline-secondary" type="button" onclick="SearchPostcodeMypage()">우편번호 검색</button>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-4" id="mypage_address" name="address" placeholder="Address" value="<?=$mypage_info['address']?>">
                        <label for="mypage_address">주소</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control rounded-4" id="mypage_pw_check" name="pass" placeholder="Password">
                        <label for="mypage_pw_check">현재 비밀번호</label>
                        <span id="mypage_pw_check_about" style="font-size: 0.8rem; font-weight: 900;" class="text-danger"></span>
                    </div>
                    <button class="w-100 mb-2 btn btn-lg rounded-4 btn-primary" type="submit">회원정보 수정</button>
                    <button type="button" class="w-100 mb-2 btn btn-lg rounded-4 btn-success" onclick="location.href='pass_change.php'">
                        비밀번호 수정으로 이동
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
    
    // 카카오 주소 api
    function SearchPostcodeMypage() {
        new daum.Postcode({
            oncomplete: function(data) {
                // 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

                // 각 주소의 노출 규칙에 따라 주소를 조합한다.
                // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
                var addr = ''; // 주소 변수
                var extraAddr = ''; // 참고항목 변수

                //사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
                if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
                    addr = data.roadAddress;
                } else { // 사용자가 지번 주소를 선택했을 경우(J)
                    addr = data.jibunAddress;
                }

                // 사용자가 선택한 주소가 도로명 타입일때 참고항목을 조합한다.
                if(data.userSelectedType === 'R'){
                    // 법정동명이 있을 경우 추가한다. (법정리는 제외)
                    // 법정동의 경우 마지막 문자가 "동/로/가"로 끝난다.
                    if(data.bname !== '' && /[동|로|가]$/g.test(data.bname)){
                        extraAddr += data.bname;
                    }
                    // 건물명이 있고, 공동주택일 경우 추가한다.
                    if(data.buildingName !== '' && data.apartment === 'Y'){
                        extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                    }
                    // 표시할 참고항목이 있을 경우, 괄호까지 추가한 최종 문자열을 만든다.
                    if(extraAddr !== ''){
                        extraAddr = ' (' + extraAddr + ')';
                    }
                    // 조합된 참고항목을 해당 필드에 넣는다.
                    // document.getElementById("sample6_extraAddress").value = extraAddr;
                
                } else {
                    // document.getElementById("sample6_extraAddress").value = '';
                }

                // 우편번호와 주소 정보를 해당 필드에 넣는다.
                document.getElementById('mypage_postcode').value = data.zonecode;
                document.getElementById("mypage_address").value = addr;
                // 커서를 상세주소 필드로 이동한다.
                //document.getElementById("sample6_detailAddress").focus();
            }
        }).open();
    }
    // 회원정보 비밀번호 Check
    $(document).ready(function() {
        $('#mypageForm').on('submit', function(event) {
            // 비밀번호 비교
            if ($('#mypage_pw_check').val() == "") {
                $('#mypage_pw_check_about').addClass('text-danger');
                $('#mypage_pw_check_about').html('회원정보 수정 시 현재 비밀번호 입력이 필요합니다');
                return false;
            }

            this.submit();
            return true
        });
    });
</script>