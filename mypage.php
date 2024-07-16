<!doctype html>
<html lang="en" class="h-100">

<!-- Head 추가 -->
<?php require_once($_SERVER['DOCUMENT_ROOT'].'/include/head.php'); ?>

<!-- Body 시작 -->
<body class="d-flex h-100 text-center text-white bg-dark">

    <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
        <!-- header 추가 -->
        <?php require_once($_SERVER['DOCUMENT_ROOT'].'/include/header.php'); ?>
        
        <!-- 배너 사진 -->
        <figure class="figure">
            <img src="/resources/img/banner.png" class="figure-img img-fluid rounded" alt="...">
            <!-- <figcaption class="figure-caption">A caption for the above image.</figcaption> -->
        </figure>
        <!-- 배너 글과 버튼 -->
        <main class="px-3">
            <h1>안심하세요 안전한 놀이터 입니다</h1>
            <p class="lead">해당 사이트는 놀이터입니다</p>
            <p class="lead">
                <a href="#" class="btn btn-lg btn-secondary fw-bold border-white bg-white">더 알아가기</a>
            </p>
        </main>
        <!-- footer 추가 -->
        <?php require_once($_SERVER['DOCUMENT_ROOT'].'/include/footer.php'); ?>
    </div>
</body>

</html>