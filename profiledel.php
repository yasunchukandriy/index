<?php
error_reporting(E_ALL);
//session_start();
$database_handle=new PDO("mysql:host=localhost;dbname=user",'root','');
	$q = $database_handle->prepare("DELETE FROM `user` WHERE `user` = '$_SESSION[user]'");
	$q->execute();
	exit("<meta http-equiv='refresh' content='0; url= exit.php'>");
?>
