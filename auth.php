<?php
// session_start();
error_reporting(E_ALL);
$database_handle=new PDO("mysql:host=localhost;dbname=user",'root','');
	if(!empty($_POST['login']) AND !empty($_POST['password'])) {
	$login = trim($_POST['login']);
	$pass = md5($_POST['password']);
	$q = $database_handle->prepare("SELECT * FROM user WHERE user = '$login'");
	$q->execute();
	$data = $q->fetch(PDO::FETCH_ASSOC);
	
	if($data['pass'] !== $pass) 
	{ 
		echo '<br><a href="index.php">Repeat authorization</a><br>';
		exit('The entered data is no correct.');
	} 
	$_SESSION['user'] = $data['user'];
	$_SESSION['pass'] = $data['pass'];
	header("Location: http://".$_SERVER['HTTP_HOST']."/index.php");
	echo 'You logged in login '.$_SESSION['user'].'
	<a href = "exit.php">| Exit |</a>';
	echo '|<a href="addnews.php"> Add news </a>|';
		} 
	else {
	echo 'You did not fill the field.';
	echo '<br><a href="index.php">Repeat authorization</a>';
		 }
?> 

