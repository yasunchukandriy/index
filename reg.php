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
 	$login1 = $_POST['login'];
  	$log_sql = $database_handle->prepare("SELECT COUNT(*) FROM user WHERE user = '{$login1}'");
	$log_sql->execute();
	$data_exists = $log_sql->fetchColumn();
	if ($data_exists > 0){
    echo 'Login busy';
    echo '<br>|<a href="registration.php"> Repeat registration </a>|'; 
    exit();
    }
    $email1 = $_POST['email'];
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
	$login = trim($_POST['login']);
	$password = md5($_POST['password']);
	$email = trim($_POST['email']);
	$avatar = 'user-icon1.jpg';
	$datereg = time();
	$insert = $database_handle->exec("INSERT INTO user (`user`, `pass`, `email`,`avatar`,`datereg`) VALUES ('$login' , '$password', '$email','$avatar','$datereg')");
	if($insert) { 
		$_SESSION['user'] = $_POST['login'];
		$_SESSION['pass'] = $_POST['password'];
		echo 'Registration successful.'; 
		}

	}
else {
	echo 'You did not fill in all fields.';
	echo '|<a href="registration.php"> Repeat registration </a>|';
	echo '<br><a href="index.php">Home</a>';
	}
echo '<br><a href="index.php">Home</a>';
?>
</div>
</div>
</body>
</html>

