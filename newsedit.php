<?php
error_reporting(E_ALL);
//session_start();
	if(empty($_SESSION['user'])) {
		exit();
		}
	$database_handle=new PDO("mysql:host=localhost;dbname=user",'root','');
	$qu = $database_handle->prepare("SELECT * FROM user WHERE `user` = '$_SESSION[user]'");
	$qu->execute();
	$role = $qu->fetch(PDO::FETCH_ASSOC);
	if ($role['role'] == 'user')
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
<body text="white"  link="red" vlink="red" alink="red" >
<div id="maket">
<div id="header"><img src="img/f_4b1c3b607c0f6.jpg" width="1000"></div>
<div id="left">
<?php
echo '<br><p align = center><strong> EDIT NEWS</strong></p>';
	if ($role['role'] == 'admin')
	{
	$q = $database_handle->prepare("SELECT * FROM news ORDER BY ID");
	$q->execute();
	while($data = $q->fetch(PDO::FETCH_ASSOC)) {	
	echo '<p><b>'.$data['title'].'</b>';
?>
	<input type='submit' name='submit' value='EDIT USER' onclick="location.href='newsedit.php?edit=<?php print $data['id']; ?>'">
	<input type='submit' name='submit' value='DELETE' onclick="if(confirm('Are you sure you want to delete this user?'))location.href='newsedit.php?del=<?php print $data['id']; ?>'">	
<?php
	}
}
	if ($role['role'] == 'editor')
	{
	$q = $database_handle->prepare("SELECT user.*,news.*  FROM  user JOIN news WHERE user.user=news.user AND user.role='editor'");
	$q->execute();
	while($data = $q->fetch(PDO::FETCH_ASSOC)) {	
	echo '<p><b>'.$data['title'].'</b>';
	?>
	<input type='submit' name='submit' value='EDIT USER' onclick="location.href='newsedit.php?edit=<?php print $data['id']; ?>'">
	<input type='submit' name='submit' value='DELETE' onclick="if(confirm('Are you sure you want to delete this user?'))location.href='newsedit.php?del=<?php print $data['id']; ?>'">	
<?php
	}
}
if(!empty($_GET['del'])) {
	$q = $database_handle->prepare("DELETE FROM news WHERE id = '$_GET[del]'");
	$q->execute();  
	}
if(!empty($_GET['edit'])){
	$q = $database_handle->prepare("SELECT * FROM news WHERE id = '$_GET[edit]'");
	$q->execute();
	$data = $q->fetch(PDO::FETCH_ASSOC);

	}

	?>
<form id='forma' action='' method='post'>
<p>Title<br /><input type='text' name='title' class="form-login1" value= <?=$data["title"] ?> ></p>
<p>Text<br /><textarea rows='10' cols='45' name='text' class="form-login2"><?=$data['text']?></textarea></p>
<p><input type='submit' name='submit' value='Update'>
<br></p></form>
<?php
if(!empty($_POST['title']) AND !empty($_POST['text'])) {
	$title = trim($_POST['title']);
	$text = trim($_POST['text']);
	$q = $database_handle->prepare("UPDATE `news` SET  `title` =  '$_POST[title]', `text` =  '$_POST[text]' WHERE  `id` = $_GET[id]");
	$q->execute();
	unset($_POST);
	echo 'News Update<br>';
	}
?>
</div>
<div id="content">
		<?php if(!empty($_SESSION['user'])) {
		echo '<h3>  You logged in login <a href=profile.php>'.$_SESSION['user'].'</a>!</h3>';
		?>
<ul id="my_menu">
	<li><a href="index.php"><span>Home</span></a></li>
	<li><a href="profile.php"><span>Profile</span></a></li>
	<li><a href="addnews.php"><span>Add News</span></a></li>
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