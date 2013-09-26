<?php
error_reporting(E_ALL);
//session_start();
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
<body text="white"  link="red" vlink="red" alink="red" >
<div id="maket">
<div id="header"><img src="img/f_4b1c3b607c0f6.jpg" width="1000"></div>
<div id="left">
	<?php
echo '<br><p align = center><strong> EDIT NEWS</strong></p>';
$q = $database_handle->prepare("SELECT * FROM news ORDER BY ID");
$q->execute();
while($data = $q->fetch(PDO::FETCH_ASSOC)) {
	echo '<p><b>'.$data['title'].'</b> | <a href="newsedit.php?id='.$data['id'].'">edit</a> | <a href="newsedit.php?del='.$data['id'].'" >del</a><br></p>';
	}
if(!empty($_GET['id'])){
	$q = $database_handle->prepare("SELECT * FROM news WHERE id = '$_GET[id]'");
	$q->execute();
	$data = $q->fetch(PDO::FETCH_ASSOC);
	}
if(empty($_GET['del'])) {
	
	}
	
if(!empty($_GET['del'])) {
	echo '| <a href="newsedit.php?del='.$data['id'].'">Yes</a> |';
	echo '| <a href="newsedit.php">No</a> |';
	$q = $database_handle->prepare("DELETE FROM news WHERE id = '$_GET[del]'");
	$q->execute();
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
		echo '<h3>  You logged in login '.$_SESSION['user'].'!</h3>';
		?>
<ul id="my_menu">
	<li><a href="index.php"><span>Home</span></a></li>
	<li><a href="profile.php"><span>Profile</span></a></li>
	<li><a href="edituser.php"><span>Edit User</span></a></li>
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