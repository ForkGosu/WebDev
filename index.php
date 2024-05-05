<?php
    if($_GET['login_id'] == ""){
        header("location:login.php");
        exit; // 밑의 html과 php코드가 노출되지 않게 하기 위함
    }
?>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="./copy.css">
    </head>
    <body>

    <header class="header" role="banner">
        <div class="header_inner">
            <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>" class="logo">
            </a>
        </div>
    </header>
    <div id="container" class="container">
    </body>
</html>