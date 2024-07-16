<?php
    // 현재 파일명을 가져와서 우측 상단 메뉴 확인용
    $current_page = basename($_SERVER['PHP_SELF']);
?>

<header class="mb-auto">
    <div>
        <h3 class="float-md-start mb-0">포크 놀이터</h3>
        <?php if($_SESSION['id'] == ""){ ?>
            <!-- Button trigger modal -->
            <button type="button" class="float-md-start btn btn-primary btn-sm mx-3 mt-1" role="button" data-bs-toggle="modal" data-bs-target="#modalLogin">
            로그인
            </button>
        <?php } else { ?>
            <!-- Example single danger button -->
            <div class="btn-group float-md-start mx-3 my-1">
                <a type="button" class="text-decoration-none text-light fs-5 dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <?php echo $_SESSION['id']; ?>
                </a>
                <ul class="dropdown-menu dropdown-menu-dark">
                    <li><a class="dropdown-item" href="/mypage.php">마이 페이지</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="/proc/logout_proc.php">로그아웃</a></li>
                </ul>
            </div>
        <?php } ?>
        <nav class="nav nav-masthead justify-content-center float-md-end">
            <a class="nav-link <?php echo ($current_page == 'index.php') ? 'active' : ''; ?>" aria-current="page" href="/">메인</a>
            <a class="nav-link <?php echo ($current_page == 'board.php') ? 'active' : ''; ?>" href="/board.php">게시판</a>
            <a class="nav-link <?php echo ($current_page == 'game.php') ? 'active' : ''; ?>" href="/game.php">게임</a>
        </nav>
    </div>
</header>

<!-- 로그인 Modal -->
<div class="modal fade" id="modalLogin" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticLogin" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content bg-light rounded-5 shadow text-black-50">
            <div class="modal-header p-5 pb-4 border-bottom-0">
                <h2 class="fw-bold mb-0">로그인</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-5 pt-0">
                <form action="/proc/login_proc.php" id="loginForm" method="POST">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-4" id="login_id" name="id" placeholder="ID">
                        <label for="login_id">아이디</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control rounded-4" id="login_pw" name="pw" placeholder="Password">
                        <label for="login_pw">비밀번호</label>
                    </div>
                    <button class="w-100 mb-2 btn btn-lg rounded-4 btn-success" type="submit">로그인</button>
                    <button type="button" class="w-100 mb-2 btn btn-lg rounded-4 btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalsignup">
                        계정 만들기
                    </button>
                    <hr class="my-4">
                </form>
            </div>
        </div>
    </div>
</div>

<!-- 회원가입 Modal -->
<div class="modal fade" id="modalsignup" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticsignup" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content bg-light rounded-5 shadow text-black-50">
            <div class="modal-header p-5 pb-4 border-bottom-0">
                <h2 class="fw-bold mb-0">회원가입</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-5 pt-0">
                <form action="/proc/signup_proc.php" id="signupForm" method="POST">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-4" id="signup_id" name="id" placeholder="ID">
                        <label for="signup_id">아이디</label>
                        <span id="signup_id_about" style="font-size: 0.8rem; font-weight: 900;"></span>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control rounded-4" id="signup_pw" name="pw" placeholder="Password">
                        <label for="signup_pw">비밀번호</label>
                        <span id="signup_pw_about" style="font-size: 0.8rem; font-weight: 900;"></span>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control rounded-4" id="signup_pw_check" placeholder="Password">
                        <label for="signup_pw_check">비밀번호 확인</label>
                        <span id="signup_pw_check_about" style="font-size: 0.8rem; font-weight: 900;"></span>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-4" id="signup_name" name="name" placeholder="Name">
                        <label for="signup_name">이름</label>
                    </div>
                    <div class="form-floating mb-3 input-group">
                        <input type="text" class="form-control rounded-4" id="signup_postcode" name="postcode" placeholder="Postcode" readonly>
                        <label for="signup_postcode">우편번호</label>
                        <button class="btn btn-outline-secondary" type="button" onclick="SearchPostcode()">우편번호 검색</button>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-4" id="signup_address" name="address" placeholder="Address">
                        <label for="signup_address">주소</label>
                    </div>
                    <button class="w-100 mb-2 btn btn-lg rounded-4 btn-primary" type="submit" onclick="">회원가입</button>
                    <button type="button" class="w-100 mb-2 btn btn-lg rounded-4 btn-outline-success" data-bs-toggle="modal" data-bs-target="#modalLogin">
                        로그인으로 이동
                    </button>
                    <hr class="my-4">
                </form>
            </div>
        </div>
    </div>
</div>

<!-- 로그인 및 회원가입 Modal에 대한 Ajax -->
<script>

    // 회원가입 아이디 중복 체크
    $(document).ready(function() {
        $('#signup_id').focusout(function() {
            const inputValue = $('#signup_id').val();
            const regex = /^[a-z0-9_]{5,20}$/;

            $('#signup_id').removeClass('border-success');
            $('#signup_id_about').removeClass('text-success');
            $('#signup_id').removeClass('border-danger');
            $('#signup_id_about').removeClass('text-danger');

            // 5 ~ 20자의 영문 소문자, 숫자와 언더바(_)이외의 것을 사용 했을 때
            if (!regex.test(inputValue)) {
                $('#signup_id').addClass('border-danger');
                $('#signup_id_about').addClass('text-danger');
                $('#signup_id_about').html('5 ~ 20자의 영문 소문자, 숫자와 언더바(_)만 사용 가능합니다.');
            } else {
                $.ajax({
                    url: '/proc/idcheck_proc.php', // Example API endpoint
                    method: 'POST',
                    data: { id: inputValue },
                    success: function(response) {
                        if (response == 1) {
                            // 아이디 중복 O
                            $('#signup_id').addClass('border-danger');
                            $('#signup_id_about').addClass('text-danger');
                            $('#signup_id_about').html($('#signup_id').val()+'은 이미 다른사람이 사용중입니다.');
                        } else if(response == 0) {
                            // 아이디 중복 X
                            $('#signup_id').addClass('border-success');
                            $('#signup_id_about').addClass('text-success');
                            $('#signup_id_about').html($('#signup_id').val()+'은 사용 가능합니다.');
                        }
                    },
                });
            }
        });
    });

    // 회원가입 비밀번호 확인
    $(document).ready(function() {
        $('#signup_pw').focusout(function() {
            const inputValue = $('#signup_pw').val();
            const regex = /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$ %^&*-]).{8,16}$/

            $('#signup_pw').removeClass('border-success');
            $('#signup_pw_about').removeClass('text-success');
            $('#signup_pw').removeClass('border-danger');
            $('#signup_pw_about').removeClass('text-danger');

            // 8 ~ 16자의 영문 대/소문자, 숫자, 특수문자를 모두 사용해 주세요.
            if (!regex.test(inputValue)) {
                $('#signup_pw').addClass('border-danger');
                $('#signup_pw_about').addClass('text-danger');
                $('#signup_pw_about').html('8 ~ 16자의 영문 대/소문자, 숫자, 특수문자를 하나씩 사용해 주세요');
            } else {
                $('#signup_pw').addClass('border-success');
                $('#signup_pw_about').addClass('text-success');
                $('#signup_pw_about').html('사용 가능한 비밀번호 입니다');
            }

            // 비밀번호 비교
            if ($('#signup_pw_check').val() == "" || $('#signup_pw_check').val() != $('#signup_pw').val()) {
                $('#signup_pw_check').addClass('border-danger');
                $('#signup_pw_check_about').addClass('text-danger');
                $('#signup_pw_check_about').html('비밀번호가 서로 다릅니다');
            } else {
                $('#signup_pw_check').addClass('border-success');
                $('#signup_pw_check_about').addClass('text-success');
                $('#signup_pw_check_about').html('비밀번호 일치가 확인 되었습니다');
            }
        });
    });
    
    // 회원가입 비밀번호 Check 확인
    $(document).ready(function() {
        $('#signup_pw_check').focusout(function() {
            $('#signup_pw_check').removeClass('border-success');
            $('#signup_pw_check_about').removeClass('text-success');
            $('#signup_pw_check').removeClass('border-danger');
            $('#signup_pw_check_about').removeClass('text-danger');

            // 비밀번호 비교
            if ($('#signup_pw_check').val() == "" || $('#signup_pw_check').val() != $('#signup_pw').val()) {
                $('#signup_pw_check').addClass('border-danger');
                $('#signup_pw_check_about').addClass('text-danger');
                $('#signup_pw_check_about').html('비밀번호가 서로 다릅니다');
            } else {
                $('#signup_pw_check').addClass('border-success');
                $('#signup_pw_check_about').addClass('text-success');
                $('#signup_pw_check_about').html('비밀번호 일치가 확인 되었습니다');
            }
        });
    });

    // 카카오 주소 api
    function SearchPostcode() {
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
                document.getElementById('signup_postcode').value = data.zonecode;
                document.getElementById("signup_address").value = addr;
                // 커서를 상세주소 필드로 이동한다.
                //document.getElementById("sample6_detailAddress").focus();
            }
        }).open();
    }

    // 회원가입 시 폼 확인
    $(document).ready(function() {
        $('#signupForm').on('submit', function(event) {
            const hasClass = $('#signup_id_about').hasClass('text-success');
            if(!$('#signup_id_about').hasClass('text-success')){
                alert("아이디를 확인해주세요");
                return false;
            }

            if(!$('#signup_pw_about').hasClass('text-success')){
                alert("비밀번호를 확인해주세요");
                return false;
            }

            if(!$('#signup_pw_check_about').hasClass('text-success')){
                alert("비밀번호 확인을 확인해주세요");
                return false;
            }

            this.submit();
            return true
        });
    });



</script>