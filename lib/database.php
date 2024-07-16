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

function UserSignup($id, $pw, $name, $postcode, $address){
    global $pdo; // 전역 변수 접근

    // Prepared Statement 준비
    $sql = "INSERT INTO user (id, pass, name, postcode, address) VALUES (:id, :pass, :name, :postcode, :address)";
    $stmt = $pdo->prepare($sql);


    // 변수 바인딩
    $stmt->bindParam(':id', $id, PDO::PARAM_STR);
    $stmt->bindParam(':pass', $pw, PDO::PARAM_STR);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':postcode', $postcode, PDO::PARAM_STR);
    $stmt->bindParam(':address', $address, PDO::PARAM_STR);


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
?>