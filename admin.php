<?php
error_reporting(E_ALL);
// session_start();
	if(empty($_SESSION['user'])) {
		exit();
		}
	$database_handle=new PDO("mysql:host=localhost;dbname=user",'root','');
	$q = $database_handle->prepare("SELECT * FROM user WHERE `user` = '$_SESSION[user]'");
	$q->execute();
	$role = $q->fetch(PDO::FETCH_ASSOC);
	if ($role['role'] == 'user' OR $role['role'] == 'editor')
	{
		print('You do not have access!!');
		exit('<p><a href="index.php">Go back</a></p>');
	}
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
<p align = center><strong>USERS LIST</strong>
<table cellpadding="20">
<tr>
<td>
<?php 
	$q = $database_handle->prepare("SELECT * FROM user ORDER BY ID");
	$q->execute();
	while($data = $q->fetch(PDO::FETCH_ASSOC)) {	
	echo '<h4><b>Login: '.$data['user'].'</b></h4>';
	echo '<p><img src="http://'.$_SERVER['HTTP_HOST'].'/img/'.$data['avatar'].'" height="150" width="150"></p>';
	?>
<input type='submit' name='submit' value='DELETE USER' onclick="if(confirm('Are you sure you want to delete this user?'))location.href='admin.php?del=<?php print $data['id']; ?>'">
<input type='submit' name='submit' value='EDIT USER' onclick="location.href='adminedit.php?edit=<?php print $data['id']; ?>'">
<?php
	}
	if(!empty($_GET['del'])) {
	$q = $database_handle->prepare("DELETE FROM user WHERE id = '$_GET[del]'");
	$q->execute();
	}
	if(!empty($_GET['edit'])){
	$q = $database_handle->prepare("SELECT * FROM user WHERE id = '$_GET[edit]'");
	$q->execute();
	$data = $q->fetch(PDO::FETCH_ASSOC);
	}
?>	
</td>
</tr>
</table>
</div>

<div id="content">
		<?php if(!empty($_SESSION['user'])) {
		echo '<h3>  You logged in login <a href=profile.php>'.$_SESSION['user'].'</a>!</h3>';
		?>

<ul id="my_menu">
	<li><a href="index.php"><span>Home</span></a></li>
	<li><a href="profile.php"><span>Profile</span></a></li>
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

