<?php
error_reporting(E_ALL);
//session_start();
$database_handle=new PDO("mysql:host=localhost;dbname=user",'root','');
$q = $database_handle->prepare("SELECT COUNT(*) FROM user WHERE user = '".$_SESSION['user']."'");
$q->execute();
$data = $q->fetch(PDO::FETCH_ASSOC);
if($data['pass'] !== $_SESSION['pass']) {
	echo 'You are not logged.';
	exit();
	}
?>