﻿<?php
error_reporting(E_ALL);
//session_start();
ini_set("include_path",getenv("DOCUMENT_ROOT")."/function");
include "translate.php";
	if(empty($_SESSION['user'])) {
		exit();
	}
$database_handle=new PDO("mysql:host=localhost;dbname=user",'root','');
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="style2.css" rel="stylesheet" type="text/css">
<link href="login-box.css" rel="stylesheet" type="text/css" />
</head>
<body text="white" link="red" vlink="red" alink="red">
<div id="maket">
	<div id="header">
	<a href=<?php print "profile.php?lang=English&" . http_build_query($_GET) ?>><img src="/img/flag-en0.gif"></a>
	<a href=<?php print "profile.php?lang=Ukrainian&" . http_build_query($_GET) ?>><img src="/img/flag_ukr.gif"></a>
	<a href="index.php"><img src="img/f_4b1c3b607c0f6.jpg" width="1000"></a></div>
<div id="left">
<?php
	$q = $database_handle->prepare("SELECT * FROM user WHERE `user` = '$_SESSION[user]'");
	$q->execute();
	$data = $q->fetch(PDO::FETCH_ASSOC);
?>
<p align = center><strong><?php print(translate('MY PROFILE',$_SESSION['language']))?></strong>
<table cellpadding="20">
<tr>
<td>
<?php
	echo '<p><img src="http://'.$_SERVER['HTTP_HOST'].'/img/'.$data['avatar'].'" height="150" width="150"></p>';
?>
</td>
<td>
<p><input type='submit' name='submit' value="<?php print(translate('DELETE PROFILE',$_SESSION['language']))?>" onclick="if(confirm('<?php print(translate('Are you sure you want to delete your account?',$_SESSION['language']))?>'))location.href='profiledel.php';">
<input type='submit' name='submit' value='<?php print(translate('EDIT PROFILE',$_SESSION['language']))?>' onclick="location.href='edituser.php';"></p>
<?php
	echo '<h4><b><p>'. translate('Role User',$_SESSION['language']).': '.$data['role'].'</p></b></h4>';
	echo '<h4><b><p>'. translate('Surname',$_SESSION['language']).': '.$data['username'].'</p></b></h4>';
	echo '<h4><b><p>'. translate('Name',$_SESSION['language']).': '.$data['name'].'</p></b></h4>';
	echo '<h4><b><p>Email: '.$data['email'].'</p></b></h4>';
	echo '<h4><b><p>'. translate('Date of Registration',$_SESSION['language']).': '. date('d M Y H:i:s', $data['datereg']).'</p></b></h4>';
	echo '<h4><b><p>'. translate('Login time',$_SESSION['language']).': '. date('d M Y H:i:s', $data['datelog']).'</p></b></h4>';		
	$q = $database_handle->prepare("SELECT * FROM user WHERE `user` = '$_SESSION[user]'");
	$q->execute();
	$data = $q->fetch(PDO::FETCH_ASSOC);
	if ($data['role'] == 'admin')
	{
?>	
<input type='submit' name='submit' value='<?php print(translate('USERS LIST',$_SESSION['language']))?>' onclick="location.href='admin.php';">
<?php
	}
?>
</td>
</tr>
</table>
</div>
	<div id="content">
<?php if(!empty($_SESSION['user'])) {
	echo '<h3>  '. translate('You logged in login',$_SESSION['language']).' <a href=profile.php>'.$_SESSION['user'].'</a>!</h3>';
?>
<ul id="my_menu">
	<li><a href="index.php"><span><?php print(translate('Home',$_SESSION['language']))?></span></a></li>
	<li><a href="addnews.php"><span><?php print(translate('Add News',$_SESSION['language']))?></span></a></li>
	<li><a href="newsedit.php"><span><?php print(translate('Edit News',$_SESSION['language']))?></span></a></li>
	<li><a href="exit.php"><span><?php print(translate('Exit',$_SESSION['language']))?></span></a></li>
</ul>
<?
	} 
	else { include 'enter.php'; }
?> 
	</div> 
</div>
</body>
</html>