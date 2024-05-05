<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'admin');
define('DB_PASSWORD', 'student1234');
define('DB_NAME', 'test');

$db_conn = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_NAME);
    
// 인증된 사람인지 확인이 필요
if($db_conn){
    echo "DB Connect OK";
} else {
    echo "DB Connect Fail";
}
// 연결된 DB에서 SQL문을 실행한 뒤 result변수에 넣음
$sql = "select * from test_table;";
$result = mysqli_query($db_conn, $sql);

// 이제 데이터가 오브젝트 객체로 리턴되어서 보임
var_dump($result);

// 결과에 대한 하나의 행을 $row에 넣음
$row = mysqli_fetch_array($result);
// 첫번째 행이 보임
var_dump($row);

// mysqli_fetch_array를 한번 더 하면 하나의 밑에것을 가져옴
$row = mysqli_fetch_array($result);
// 두번째 행이 보임
var_dump($row);

// 이렇게 하면 row의 name에대한 데이터값을 가져옴
echo "Name : " . $row['name'];
?>