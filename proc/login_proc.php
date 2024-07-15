<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/lib/database.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/lib/session.php');

$user = UserLogin($_POST['id'],$_POST['pass']);

if ($user){
  $_SESSION['id'] = $user['id'];
  header("location:/");
} else {
  header("location:/");
  // header("location:login.php");
}
?>