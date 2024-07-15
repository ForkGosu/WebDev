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
    echo "DB Connect OK";
} catch (PDOException $e) {
    die("DB Connect Fail: " . $e->getMessage());
}

function UserLogin($_id, $_pass){
    global $pdo; // 전역 변수 접근

    // Prepared Statement 준비
    $sql = "SELECT id FROM user WHERE id = :id AND pass = :pass LIMIT 1";
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

function UserJoin($_id, $_pass, $_name){
    // global $db_conn; // 전역 변수 접근

    // // 연결된 DB에서 SQL문을 실행한 뒤 result변수에 넣음
    // $sql = "SELECT id FROM user WHERE id='$_id' AND pass='$_pass' LIMIT 1";

    // $result = mysqli_query($db_conn, $sql);

    // // 결과에 대한 하나의 행을 $row에 넣음
    // $row = mysqli_fetch_array($result);
    // // 첫번째 행이 보임
    // // var_dump($row);

    // // 결과에 대한 하나의 row 반환
    // return $row;
}
?>