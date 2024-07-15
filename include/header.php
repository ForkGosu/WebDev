<?php
    // 현재 파일명을 가져오기
    $current_page = basename($_SERVER['PHP_SELF']);
?>

<header class="mb-auto">
    <div>
        <h3 class="float-md-start mb-0">포크 놀이터</h3>
        <!-- Button trigger modal -->
        <button type="button" class="float-md-start btn btn-primary mx-3" data-bs-toggle="modal" data-bs-target="#modalLogin">
        로그인
        </button>
        <nav class="nav nav-masthead justify-content-center float-md-end">
            <a class="nav-link <?php echo ($current_page == 'index.php') ? 'active' : ''; ?>" aria-current="page" href="/index.php">메인</a>
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
                <form action="/proc/login_proc.php" method="POST">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-4" id="login_id" placeholder="UserId">
                        <label for="login_id">아이디</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control rounded-4" id="login_pw" placeholder="Password">
                        <label for="login_pw">비밀번호</label>
                    </div>
                    <button class="w-100 mb-2 btn btn-lg rounded-4 btn-success" type="submit">로그인</button>
                    <button type="button" class="w-100 mb-2 btn btn-lg rounded-4 btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalSignin">
                    계정 만들기
                    </button>
                    <hr class="my-4">
                </form>
            </div>
        </div>
    </div>
</div>

<!-- 회원가입 Modal -->
<div class="modal fade" id="modalSignin" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticSignin" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content bg-light rounded-5 shadow text-black-50">
            <div class="modal-header p-5 pb-4 border-bottom-0">
                <h2 class="fw-bold mb-0">회원가입</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-5 pt-0">
                <form action="/proc/signin_proc.php" method="POST">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-4" id="signin_id" placeholder="UserId">
                        <label for="signin_id">아이디</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control rounded-4" id="signin_pw" placeholder="Password">
                        <label for="signin_pw">비밀번호</label>
                    </div>
                    <button class="w-100 mb-2 btn btn-lg rounded-4 btn-primary" type="submit">회원가입</button>
                    <hr class="my-4">
                </form>
            </div>
        </div>
    </div>
</div>