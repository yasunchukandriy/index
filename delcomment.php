<?php
error_reporting(E_ALL);
//session_start();
$database_handle=new PDO("mysql:host=localhost;dbname=user",'root','');
	$q = $database_handle->prepare("DELETE FROM `comments` WHERE `idcomment` = '$_GET[del]'");
	$q->execute();
	$redicet = $_SERVER['HTTP_REFERER'];
	header ("Location: $redicet");
	// exit("<meta http-equiv='refresh' content='0; url= index.php?id='>");
?>