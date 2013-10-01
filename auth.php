<?php
// session_start();
error_reporting(E_ALL);
$database_handle=new PDO("mysql:host=localhost;dbname=user",'root','');
	if(!empty($_POST['login']) AND !empty($_POST['password'])) {
	$login = strip_tags(trim($_POST['login']));
	$pass = strip_tags(md5($_POST['password']));
	$datelog = time();
	$q = $database_handle->prepare("SELECT * FROM user WHERE user = '$login'");
	$q->execute();
	$data = $q->fetch(PDO::FETCH_ASSOC);
	if ($data['role'] == 'blocked'){
		echo '<br><a href="index.php">Repeat authorization</a><br>';
		exit('<h3><font color="red">Your account is blocked!</font></h3>');
	}
	if($data['pass'] !== $pass) 
	{ 
		echo '<br><a href="index.php">Repeat authorization</a><br>';
		exit('The entered data is no correct.');
	} 
	$_SESSION['user'] = $data['user'];
	$_SESSION['pass'] = $data['pass'];
	$q = $database_handle->prepare("UPDATE `user` SET `datelog` = '$datelog' WHERE `user` = '$_SESSION[user]'");
	$q->execute();
	exit("<meta http-equiv='refresh' content='0; url= index.php'>");
		} 
	else {
	echo 'You did not fill the field.';
	echo '<br><a href="index.php">Repeat authorization</a>';
		 }
?> 

