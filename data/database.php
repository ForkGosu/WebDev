<?php
// 직접 접근하는건 막기
// if($_SERVER['HTTP_REFERER'] == '') exit("잘못된 접근입니다.");

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'admin');
define('DB_PASSWORD', 'student1234');
define('DB_NAME', 'HomePage');

// DB연결 읽어들임
$db_conn = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_NAME);
// 연결한DB utf8mb4로 읽어들임
mysqli_set_charset($db_conn,"utf8mb4");
    
// 인증된 사람인지 확인이 필요
if($db_conn){
    echo "DB Connect OK";
} else {
    echo "DB Connect Fail";
}
function UserLogin($_id, $_pass){
    global $db_conn; // 전역 변수 접근

    // 연결된 DB에서 SQL문을 실행한 뒤 result변수에 넣음
    $sql = "SELECT id FROM user WHERE id='$_id' AND pass='$_pass' LIMIT 1";

    $result = mysqli_query($db_conn, $sql);

    // 결과에 대한 하나의 행을 $row에 넣음
    $row = mysqli_fetch_array($result);
    // 첫번째 행이 보임
    // var_dump($row);

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