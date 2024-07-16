<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/lib/database.php');
session_start();

echo IsUserIdCheck($_POST['id']);
?>