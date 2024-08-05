<?php require_once($_SERVER['DOCUMENT_ROOT'].'/lib/database.php'); ?>
<?php 
  // error_reporting( E_ALL );
  // ini_set( "display_errors", 1 );

  // 현재 게시물
  $page = $_REQUEST['page'];
  if(!$page){
    $page = 1;
  }

  /// -----
  $search_column = $_REQUEST['search_column'];
  if(!$search_column){
    $search_column = "subject";
  }

  $search_word = $_REQUEST['search_word'];
  if(!$search_word){
    $search_word = "";
  }

  $order_column = $_REQUEST['order_column'];
  if(!$order_column){
    $order_column = "wdate";
  }

  $order_sort = $_REQUEST['order_sort'];
  if(!$order_sort){
    $order_sort = "desc";
  }

  
  // 한 페이지에 표시할 게시물 수
  $items_per_page = 10;

  $total_items = GetTotalBoardCount($search_column, $search_word); // 총 게시물 수
  $total_pages = ceil($total_items / $items_per_page); // 총 페이지 수
  
  // 한 번에 표시할 페이지 버튼 수
  $pages_per_group = 10;

  // 현재 페이지 그룹 계산
  $current_group = ceil($page / $pages_per_group);

  // 그룹의 시작 페이지와 끝 페이지 계산
  $start_page = ($current_group - 1) * $pages_per_group + 1;
  $end_page = min($current_group * $pages_per_group, $total_pages);

?>

<?php $board_list = BoardListToSearch($page, $items_per_page, $search_column, $search_word, $order_column, $order_sort); ?>

<!doctype html>
<html lang="ko" class="h-100">

<!-- Head 추가 -->
<?php require_once($_SERVER['DOCUMENT_ROOT'].'/include/head.php'); ?>

<!-- Body 시작 -->
<body class="d-flex h-100 text-center text-white bg-dark">

    <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
        <!-- header 추가 -->
        <?php require_once($_SERVER['DOCUMENT_ROOT'].'/include/header.php'); ?>
        
        <!-- main 시작 -->
        <main class="px-3">
          <!-- 게시판 제목 -->
          <h1>포크 놀이터 게시판</h1>
          <p class="lead">게시판 입니다! 안심하고 즐겨주세요!</p>
          <!-- 검색 창 -->
          <nav class="navbar navbar-expand-lg navbar-light">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <form class="d-flex" id="search_form" action="./board_list.php" method="get">
                <select name="search_column" class="form-select pe-0 me-2" style="width:150px" aria-label="Default select example">
                  <option value="subject" selected>제목</option>
                  <option value="content">내용</option>
                  <option value="writer">작성자</option>
                </select>
                <input name="search_word" class="form-control me-2" style="width:300px" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
              <input name="order_column" type="hidden" value="<?=$order_column?>">
              <input name="order_sort" type="hidden" value="<?=$order_sort?>">
              </form>
            </div>
          </nav>
          <!-- 게시판 리스트 -->
          <table class="table table-sm table-hover">
            <thead>
              <tr>
                <th class="col-md-1">번호</th>
                <th class="col-md-3"><a class="text-decoration-none text-white" href="board_list.php?search_column=<?=$search_column?>&search_word=<?=$search_word?>&order_column=subject&order_sort=<?=$order_sort != "desc" ? "desc" : "asc"?>">제목<?=$order_column == "subject" ? ($order_sort == "desc" ? " ▼ " : " ▲ ") : " - "?></a></th>
                <th class="col-md-1">글쓴이</th>
                <th class="col-md-2"><a class="text-decoration-none text-white" href="board_list.php?search_column=<?=$search_column?>&search_word=<?=$search_word?>&order_column=wdate&order_sort=<?=$order_sort != "desc" ? "desc" : "asc"?>">작성날짜<?=$order_column == "wdate" ? ($order_sort == "desc" ? " ▼ " : " ▲ ") : " - "?></a></th>
                <th class="col-md-1"><a class="text-decoration-none text-white" href="board_list.php?search_column=<?=$search_column?>&search_word=<?=$search_word?>&order_column=view&order_sort=<?=$order_sort != "desc" ? "desc" : "asc"?>">조회<?=$order_column == "view" ? ($order_sort == "desc" ? " ▼ " : " ▲ ") : " - "?></a></th>
              </tr>
            </thead>
            <tbody>
              <?php 
                // 결과 출력 (예제)
                foreach ($board_list as $row) {
              ?>
                <tr onClick="location.href='board_view.php?idx=<?=$row['idx']?>'" style="cursor:pointer;">
                  <td><?= $row['idx'] ?></td>
                  <td><?= htmlspecialchars($row['subject']) ?></td>
                  <td><?= htmlspecialchars($row['writer']) ?></td>
                  <td><?= date('Y-m-d', $row['wdate']); ?></td>
                  <td><?= $row['view'] ?></td>
                </tr>
              <?php
                }
              ?>
            </tbody>
          </table>
          <!-- 버튼 -->
          <p class="lead">
          <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button class="btn btn-primary" type="button" onClick="location.href='board_write.php'">새 글 작성하기</button>
          </div>
          </p>
          <!-- 페이징 -->
          <p class="lead">
          <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
              <li class="page-item <?= $start_page > 1 ? "" : "disabled" ?>">
              <a class="page-link" href="board_list.php?page=<?=$start_page - 1?>" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
              </a>
              </li>
              <?php 
              ?>
              <?php for ($_page = $start_page; $_page <= $end_page; $_page++) { ?>
                <?php if ($_page == $page) { ?>
                  <li class="page-item active"><a class="page-link" aria-current="page"><?=$_page?></a></li>
                <?php } else { ?>
                  <li class="page-item"><a class="page-link" href="board_list.php?page=<?=$_page?>&search_column=<?=$search_column?>&search_word=<?=$search_word?>&order_column=<?=$order_column?>&order_sort=<?=$order_sort?>"><?=$_page?></a></li>
                <?php } ?>
              <?php } ?>
              <li class="page-item <?= $end_page < $total_pages ? "" : "disabled" ?>">
                <a class="page-link" href="board_list.php?page=<?=$end_page + 1?>" aria-label="Next">
                  <span aria-hidden="true">&raquo;</span>
                </a>
              </li>
            </ul>
          </nav>
          </p>
        </main>
        <!-- footer 추가 -->
        <?php require_once($_SERVER['DOCUMENT_ROOT'].'/include/footer.php'); ?>
    </div>
</body>

</html>