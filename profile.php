<?php
error_reporting(E_ALL);
//session_start();
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
<style>
   body {
    background-image: url(img/45.jpg); 
    background-color: #c7b39b;
   }
  </style>
</head>
<body text="white" link="red" vlink="#cecece" alink="#ff0000">
<div id="maket">
<div id="header"><img src="img/f_4b1c3b607c0f6.jpg" width="1000"></div>
<div id="left">
<?php

	$q = $database_handle->prepare("SELECT * FROM user WHERE `user` = '$_SESSION[user]'");
	$q->execute();
	$data = $q->fetch(PDO::FETCH_ASSOC);
?>
	<p align = center><strong>MY PROFILE</strong>
	<table cellpadding="20">
	<tr>
	<td>
<?php
	echo '<p><img src="http://'.$_SERVER['HTTP_HOST'].'/img/'.$data['avatar'].'" height="150" width="150"></p>';
?>
	</td>
	<td>
	<p><input type='submit' name='submit' value='DELETE PROFILE' onclick="if(confirm('Are you sure you want to delete your account?'))location.href='profiledel.php';">
<?php
	if (!$data['role'] == '')
	{
?>
	<input type='submit' name='submit' value='EDIT PROFILE' onclick="location.href='edituser.php';">
<?php
}
?>
	</p>
<?php
	echo '<h4><b><p>Role User: '.$data['role'].'</p></b></h4>';
	echo '<h4><b><p>Surname: '.$data['username'].'</p></b></h4>';
	echo '<h4><b><p>Name: '.$data['name'].'</p></b></h4>';
	echo '<h4><b><p>Email: '.$data['email'].'</p></b></h4>';
	echo '<h4><b><p>Date of Registration: '. date('d M Y H:i:s', $data['datereg']).'</p></b></h4>';
	echo '<h4><b><p>Login time: '. date('d M Y H:i:s', $data['datelog']).'</p></b></h4>';		
	$q = $database_handle->prepare("SELECT * FROM user WHERE `user` = '$_SESSION[user]'");
	$q->execute();
	$data = $q->fetch(PDO::FETCH_ASSOC);
	if ($data['role'] == 'admin')
	{
?>	
<input type='submit' name='submit' value='USERS LIST' onclick="location.href='admin.php';">
<?php
	}


?>
	
	</td>
	</tr>
	</table>


</div>

<div id="content">
		<?php if(!empty($_SESSION['user'])) {
		echo '<h3>  You logged in login '.$_SESSION['user'].'!</h3>';
		?>

<ul id="my_menu">
	<li><a href="index.php"><span>Home</span></a></li>
	<li><a href="addnews.php"><span>Add News</span></a></li>
	<li><a href="newsedit.php"><span>Edit News</span></a></li>
	<li><a href="exit.php"><span>Exit</span></a></li>
</ul>
		<?
		} 
		else {
		include 'enter.php';
		}
?> 
</div>

</div>
</body>
</html>