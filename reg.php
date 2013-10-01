<?php
error_reporting(E_ALL);
//session_start();

$database_handle=new PDO("mysql:host=localhost;dbname=user",'root','');
$database_handle->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="style.css" rel="stylesheet" type="text/css">

</head>
<body>
<div id="maket">
<div id="header"></div>
<div id="left">
</div>
<div id="footer" align="center"><font color="red">••InternetDevels••</font></div>
<div id="content">
	<? if (!empty($_POST['login']) AND !empty($_POST['password']) AND !empty($_POST['password2']) AND !empty($_POST['email']) ){
 	$login1 = strip_tags($_POST['login']);
  	$log_sql = $database_handle->prepare("SELECT COUNT(*) FROM user WHERE user = '{$login1}'");
	$log_sql->execute();
	$data_exists = $log_sql->fetchColumn();
	if ($data_exists > 0){
    echo 'Login busy';
    echo '<br>|<a href="registration.php"> Repeat registration </a>|'; 
    exit();
    }
    $email1 = strip_tags($_POST['email']);
	$email_sql = $database_handle->prepare("SELECT COUNT(*) FROM user WHERE email = '{$email1}'");
	$email_sql->execute();
	$data_exists = $email_sql->fetchColumn();
	if ($data_exists > 0){
    echo 'Email busy';
    echo '<br>|<a href="registration.php"> Repeat registration </a>|'; 
    exit();
	}

	  if($_POST['password'] !== $_POST['password2']) {
		echo 'Passwords do not match.';
		echo '|<a href="registration.php"> Repeat registration </a>|';
		exit();
	}
	$login = strip_tags(trim($_POST['login']));
	$password = strip_tags(md5($_POST['password']));
	$email = strip_tags(trim($_POST['email']));
	$avatar = 'user-icon1.jpg';
	$datereg = time();
	$role = 'user';
	$insert = $database_handle->exec("INSERT INTO user (`user`, `pass`, `email`,`avatar`,`datereg`,`role`) VALUES ('$login' , '$password', '$email','$avatar','$datereg', '$role')");
	if($insert) { 
		$_SESSION['user'] = strip_tags($_POST['login']);
		$_SESSION['pass'] = strip_tags($_POST['password']);
		$datelog = time();
		$q = $database_handle->prepare("UPDATE `user` SET `datelog` = '$datelog' WHERE `user` = '$_SESSION[user]'");
		$q->execute();
		echo 'Registration successful.'; 
		exit("<meta http-equiv='refresh' content='0; url= index.php'>");
		}

	}
else {
	echo 'You did not fill in all fields.';
	echo '|<a href="registration.php"> Repeat registration </a>|';
	}
?>
</div>
</div>
</body>
</html>

