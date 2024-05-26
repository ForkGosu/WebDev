<?php
  require_once('./data/database.php');
  require_once('./data/session.php');

  $user = UserJoin($_POST['id'], $_POST['pass'], $_POST['name']);

  if ($user){
    $_SESSION['id'] = $user['id'];
    header("location:login.php");
  } else {
    header("location:login.php");
  }
?>