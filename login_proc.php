<?php
  require_once('./data/database.php');
  require_once('./data/session.php');

  $user = UserLogin($_POST['id'],$_POST['pass']);

  if ($user){
    $_SESSION['id'] = $user['id'];
    header("location:index.php");
  } else {
    header("location:login.php");
  }
?>