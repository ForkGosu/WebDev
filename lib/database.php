<?php
// 직접 접근하는건 막기
// if($_SERVER['HTTP_REFERER'] == '') exit("잘못된 접근입니다.");

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'admin');
define('DB_PASSWORD', 'student1234');
define('DB_NAME', 'HomePage');

try {
    // PDO 객체 생성
    $dsn = 'mysql:host=' . DB_SERVER . ';dbname=' . DB_NAME . ';charset=utf8mb4';
    $pdo = new PDO($dsn, DB_USERNAME, DB_PASSWORD);
    // 에러 모드를 예외로 설정
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "DB Connect OK";
} catch (PDOException $e) {
    // die("DB Connect Fail: " . $e->getMessage());
}

function UserLogin($_id, $_pass){
    global $pdo; // 전역 변수 접근

    // Prepared Statement 준비
    $sql = "SELECT * FROM user WHERE id = :id AND pass = :pass LIMIT 1";
    $stmt = $pdo->prepare($sql);

    // 변수 바인딩
    $stmt->bindParam(':id', $_id, PDO::PARAM_STR);
    $stmt->bindParam(':pass', $_pass, PDO::PARAM_STR);

    // SQL문 실행
    $stmt->execute();

    // 결과에 대한 하나의 행을 $row에 넣음
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // 결과에 대한 하나의 row 반환
    return $row;
}

//!!!!!!!!!!!!!!
//! User Data
//!!!!!!!!!!!!!!

function UserSignup($_id, $_pw, $_name, $_postcode, $_address){
    global $pdo; // 전역 변수 접근

    // Prepared Statement 준비
    $sql = "INSERT INTO user (id, pass, name, postcode, address) VALUES (:id, :pass, :name, :postcode, :address)";
    $stmt = $pdo->prepare($sql);


    // 변수 바인딩
    $stmt->bindParam(':id', $_id, PDO::PARAM_STR);
    $stmt->bindParam(':pass', $_pw, PDO::PARAM_STR);
    $stmt->bindParam(':name', $_name, PDO::PARAM_STR);
    $stmt->bindParam(':postcode', $_postcode, PDO::PARAM_STR);
    $stmt->bindParam(':address', $_address, PDO::PARAM_STR);


    // SQL문 실행
    try {
        $stmt->execute();
        return true; // 성공적으로 삽입되면 true 반환
    } catch (PDOException $e) {
        return false; // 삽입 실패 시 false 반환
    }
}

function IsUserIdCheck($_id){
    global $pdo; // 전역 변수 접근

    // Prepared Statement 준비
    $sql = "SELECT id FROM user WHERE id = :id LIMIT 1";
    $stmt = $pdo->prepare($sql);

    // 변수 바인딩
    $stmt->bindParam(':id', $_id, PDO::PARAM_STR);

    // SQL문 실행
    $stmt->execute();

    // 결과에 대한 하나의 행을 $row에 넣음
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // 결과에 대한 하나의 bool 반환
    if($row == "")
        return 0;
    else 
        return 1;
}

//!!!!!!!!!!!!!!
//! Board Data
//!!!!!!!!!!!!!!

function GetTotalBoardCount($_search_column, $_search_word){
    global $pdo; // 전역 변수 접근

    // 허용된 컬럼 이름을 확인
    $allowed_columns = ['subject', 'content', 'writer']; // 검색 가능한 컬럼 리스트
    if (!in_array($_search_column, $allowed_columns)) {
        throw new InvalidArgumentException('Invalid search column');
    }

    // Prepared Statement 준비
    $sql = "SELECT COUNT(*) as total FROM board WHERE isDelete = 0 AND {$_search_column} LIKE :search_word";
    $stmt = $pdo->prepare($sql);

    // 변수 바인딩
    $search_word = '%' . $_search_word . '%';
    $stmt->bindParam(':search_word', $search_word, PDO::PARAM_STR);

    // SQL 문 실행
    $stmt->execute();

    // 결과 가져오기
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // 총 게시물 수 반환
    return $result['total'];
}

function BoardList($_page, $_items_per_page){
    global $pdo; // 전역 변수 접근
    
    // 페이지 번호에 따른 오프셋 계산
    $offset = ($_page - 1) * $_items_per_page;

    // Prepared Statement 준비
    $sql = "SELECT * FROM board WHERE isDelete = 0 LIMIT :limit OFFSET :offset";
    $stmt = $pdo->prepare($sql);

    // 변수 바인딩
    $stmt->bindParam(':limit', $_items_per_page, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);

    // SQL 문 실행
    $stmt->execute();
    
    // 결과 가져오기
    $board_list = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 결과에 대한 값 반환
    return $board_list;
}

function BoardListToSearch($_page, $_items_per_page, $_search_column, $_search_word, $_order_column, $_order_sort){
    global $pdo; // 전역 변수 접근
    
    // 페이지 번호에 따른 오프셋 계산
    $offset = ($_page - 1) * $_items_per_page;

    // 허용된 컬럼 이름을 확인
    $allowed_columns = ['subject', 'content', 'writer']; // 검색 가능한 컬럼 리스트
    if (!in_array($_search_column, $allowed_columns)) {
        throw new InvalidArgumentException('Invalid search column');
    }
    
    // 허용된 컬럼 이름을 확인
    $allowed_order_columns = ['wdate', 'subject', 'view']; // 검색 가능한 컬럼 리스트
    if (!in_array($_order_column, $allowed_order_columns)) {
        throw new InvalidArgumentException('Invalid search order column');
    }

    // 허용된 컬럼 이름을 확인
    $allowed_order_sorts = ['desc', 'asc']; // 검색 가능한 컬럼 리스트
    if (!in_array($_order_sort, $allowed_order_sorts)) {
        throw new InvalidArgumentException('Invalid search order column');
    }

    // Prepared Statement 준비
    $sql = "SELECT * FROM board WHERE isDelete = 0 AND {$_search_column} LIKE :search_word ORDER BY {$_order_column} {$_order_sort} LIMIT :limit OFFSET :offset";
    $stmt = $pdo->prepare($sql);

    // 변수 바인딩
    $search_word = '%' . $_search_word . '%';
    $stmt->bindParam(':search_word', $search_word, PDO::PARAM_STR);

    $stmt->bindValue(':limit', $_items_per_page, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

    // SQL 문 실행
    try {
        $stmt->execute();
        // 결과 가져오기
        $board_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // 결과에 대한 값 반환
        return $board_list;
    } catch (PDOException $e) {
        // 오류 메시지 출력
        // echo "Error: " . $e->getMessage();
        return false;
    }
}

function BoardView($_idx){
    global $pdo; // 전역 변수 접근

    // Prepared Statement 준비
    $sql = "SELECT * FROM board WHERE idx = :idx LIMIT 1";
    $stmt = $pdo->prepare($sql);

    // 변수 바인딩
    $stmt->bindParam(':idx', $_idx, PDO::PARAM_INT);

    // SQL 문 실행
    $stmt->execute();
    
    // 결과 가져오기
    $board_view = $stmt->fetch(PDO::FETCH_ASSOC);

    // 결과에 대한 값 반환
    return $board_view;
}

function BoardWrite($_subject, $_content, $_writer, $_file_idx){
    global $pdo; // 전역 변수 접근

    // Prepared Statement 준비
    $sql = "INSERT INTO board (subject, content, wdate, writer, file_idx) VALUES (:subject, :content, unix_timestamp(), :writer, :file_idx)";
    $stmt = $pdo->prepare($sql);


    // 변수 바인딩
    $stmt->bindParam(':subject', $_subject, PDO::PARAM_STR);
    $stmt->bindParam(':content', $_content, PDO::PARAM_STR);
    $stmt->bindParam(':writer', $_writer, PDO::PARAM_STR);
    $stmt->bindParam(':file_idx', $_file_idx, PDO::PARAM_INT);


    // SQL문 실행
    try {
        $stmt->execute();
        // 삽입된 마지막 행의 ID 가져오기
        $lastInsertId = $pdo->lastInsertId();
        return $lastInsertId; // 성공적으로 삽입되면 true 반환
    } catch (PDOException $e) {
        return false; // 삽입 실패 시 false 반환
    }
}

function BoardUpdate($_idx, $_subject, $_content, $_writer, $_file_idx){
    global $pdo; // 전역 변수 접근

    // Prepared Statement 준비
    $sql = "UPDATE board SET subject = :subject, content = :content, file_idx = :file_idx WHERE idx = :idx";
    $stmt = $pdo->prepare($sql);

    // 변수 바인딩
    $stmt->bindParam(':subject', $_subject, PDO::PARAM_STR);
    $stmt->bindParam(':content', $_content, PDO::PARAM_STR);
    $stmt->bindParam(':file_idx', $_file_idx, PDO::PARAM_INT);
    $stmt->bindParam(':idx', $_idx, PDO::PARAM_INT);

    // SQL문 실행
    try {
        $stmt->execute();
        return $_idx; // 성공적으로 업데이트된 행 수 반환
    } catch (PDOException $e) {
        return false; // 업데이트 실패 시 false 반환
    }
}

function BoardDelete($_idx){
    global $pdo; // 전역 변수 접근

    // Prepared Statement 준비
    $sql = "UPDATE board SET isDelete = 1 WHERE idx = :idx";
    $stmt = $pdo->prepare($sql);

    // 변수 바인딩
    $stmt->bindParam(':idx', $_idx, PDO::PARAM_INT);

    // SQL문 실행
    try {
        $stmt->execute();
        return true; // 성공적으로 삭제된 행 수 반환
    } catch (PDOException $e) {
        return false; // 삭제 실패 시 false 반환
    }
}
function BoardViewCount($_idx) {
    global $pdo; // 전역 변수 접근

    // Prepared Statement 준비
    $sql = "UPDATE board SET view = view + 1 WHERE idx = :idx";
    $stmt = $pdo->prepare($sql);

    // 변수 바인딩
    $stmt->bindParam(':idx', $_idx, PDO::PARAM_INT);

    // SQL문 실행
    try {
        $stmt->execute();
        return $stmt->rowCount(); // 성공적으로 업데이트된 행 수 반환
    } catch (PDOException $e) {
        // 오류 메시지를 출력
        // echo "Error: " . $e->getMessage();
        return false; // 업데이트 실패 시 false 반환
    }
}

function BoardFileView($_file_idx) {
    global $pdo; // 전역 변수 접근

    // Prepared Statement 준비
    $sql = "SELECT * FROM file_upload WHERE idx = :idx LIMIT 1";
    $stmt = $pdo->prepare($sql);

    // 변수 바인딩
    $stmt->bindParam(':idx', $_file_idx, PDO::PARAM_INT);

    // SQL 문 실행
    $stmt->execute();
    
    // 결과 가져오기
    $file_view = $stmt->fetch(PDO::FETCH_ASSOC);

    // 결과에 대한 값 반환
    return $file_view;
}
function BoardFileUpload($_file_origin, $_file_save) {
    global $pdo; // 전역 변수 접근

    // Prepared Statement 준비
    $sql = "INSERT INTO file_upload (name_origin, name_save) VALUES (:name_origin, :name_save)";
    $stmt = $pdo->prepare($sql);


    // 변수 바인딩
    $stmt->bindParam(':name_origin', $_file_origin, PDO::PARAM_STR);
    $stmt->bindParam(':name_save', $_file_save, PDO::PARAM_STR);


    // SQL문 실행
    try {
        $stmt->execute();
        // 삽입된 마지막 행의 ID 가져오기
        $lastInsertId = $pdo->lastInsertId();
        return $lastInsertId; // 성공적으로 삽입되면 true 반환
    } catch (PDOException $e) {
        return false; // 삽입 실패 시 false 반환
    }
}

function BoardLike($_user_idx, $_board_idx) {
    global $pdo; // 전역 변수 접근

    // Prepared Statement 준비
    $sql = "INSERT INTO board_like (user_idx, board_idx) VALUES (:user_idx, :board_idx)";
    $stmt = $pdo->prepare($sql);


    // 변수 바인딩
    $stmt->bindParam(':user_idx', $_user_idx, PDO::PARAM_INT);
    $stmt->bindParam(':board_idx', $_board_idx, PDO::PARAM_INT);


    // SQL문 실행
    try {
        $stmt->execute();
        // 삽입된 마지막 행의 ID 가져오기
        $lastInsertId = $pdo->lastInsertId();
        return $lastInsertId; // 성공적으로 삽입되면 true 반환
    } catch (PDOException $e) {
        return false; // 삽입 실패 시 false 반환
    }
}

function BoardLikeCount($_idx) {
    global $pdo; // 전역 변수 접근

    // Prepared Statement 준비
    $sql = "UPDATE board SET `like` = `like` + 1 WHERE idx = :idx";
    $stmt = $pdo->prepare($sql);

    // 변수 바인딩
    $stmt->bindParam(':idx', $_idx, PDO::PARAM_INT);

    // SQL문 실행
    try {
        $stmt->execute();
        return $stmt->rowCount(); // 성공적으로 업데이트된 행 수 반환
    } catch (PDOException $e) {
        // 오류 메시지를 출력
        // echo "Error: " . $e->getMessage();
        return false; // 업데이트 실패 시 false 반환
    }
}

//!!!!!!!!!!!!!!
//! Mypage Date
//!!!!!!!!!!!!!!
function MypageInfo($_id){
    global $pdo; // 전역 변수 접근

    // Prepared Statement 준비
    $sql = "SELECT * FROM user WHERE id = :id LIMIT 1";
    $stmt = $pdo->prepare($sql);

    // 변수 바인딩
    $stmt->bindParam(':id', $_id, PDO::PARAM_STR);

    // SQL 문 실행
    $stmt->execute();
    
    // 결과 가져오기
    $mypage_info = $stmt->fetch(PDO::FETCH_ASSOC);

    // 결과에 대한 값 반환
    return $mypage_info;
}

function MypageInfoChange($_name, $_address, $_postcode, $_id, $_pass){
    global $pdo; // 전역 변수 접근

    // Prepared Statement 준비
    $sql = "UPDATE user SET name = :name, address = :address, postcode = :postcode WHERE id = :id AND pass = :pass";
    $stmt = $pdo->prepare($sql);

    // 변수 바인딩
    $stmt->bindParam(':name', $_name, PDO::PARAM_STR);
    $stmt->bindParam(':address', $_address, PDO::PARAM_STR);
    $stmt->bindParam(':postcode', $_postcode, PDO::PARAM_STR);
    $stmt->bindParam(':id', $_id, PDO::PARAM_STR);
    $stmt->bindParam(':pass', $_pass, PDO::PARAM_STR);
    // SQL문 실행
    try {
        $stmt->execute();
        return $stmt->rowCount(); // 성공적으로 업데이트된 행 수 반환
    } catch (PDOException $e) {
        return false; // 업데이트 실패 시 false 반환
    }
}

function MypagePassChange($_id, $_pass_change, $_pass_origin){
    global $pdo; // 전역 변수 접근

    // Prepared Statement 준비
    $sql = "UPDATE user SET pass = :new_pass WHERE id = :id AND pass = :old_pass";
    $stmt = $pdo->prepare($sql);

    // 변수 바인딩
    $stmt->bindParam(':new_pass', $_pass_change, PDO::PARAM_STR);
    $stmt->bindParam(':id', $_id, PDO::PARAM_STR);
    $stmt->bindParam(':old_pass', $_pass_origin, PDO::PARAM_STR);

    // SQL문 실행
    try {
        $stmt->execute();
        return $stmt->rowCount(); // 성공적으로 업데이트된 행 수 반환
    } catch (PDOException $e) {
        return false; // 업데이트 실패 시 false 반환
    }
}

?>

