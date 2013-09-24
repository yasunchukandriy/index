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
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="maket">
<div id="header"></div>
<div id="left">
	<?php
echo '<br><p align = center><strong> EDIT NEWS</strong></p>';
$q = $database_handle->prepare("SELECT * FROM news ORDER BY ID");
$q->execute();
while($data = $q->fetch(PDO::FETCH_ASSOC)) {
	echo '<i>'.$data['title'].'</i> | <a href="newsedit.php?id='.$data['id'].'">edit</a> | <a href="newsedit.php?del='.$data['id'].'">del</a><br>';
	}
if(!empty($_GET['id'])){
	$q = $database_handle->prepare("SELECT * FROM news WHERE id = '$_GET[id]'");
	$q->execute();
	$data = $q->fetch(PDO::FETCH_ASSOC);
	}
if(!empty($_GET['del'])) {
	$q = $database_handle->prepare("DELETE FROM news WHERE id = '$_GET[del]'");
	$q->execute();
	}
	?>
<form id='forma' action='' method='post'>
<p>Title<br /><input type='text' name='title' value= <?=$data["title"] ?> ></p>
<p>Text<br /><textarea rows='10' cols='45' name='text'><?=$data['text']?></textarea></p>
<p><input type='submit' name='submit' value='Update'>
<br></p></form>
<?php
if(!empty($_POST['title']) AND !empty($_POST['title'])) {
	$title = trim($_POST['title']);
	$text = trim($_POST['text']);
	$q = $database_handle->prepare("UPDATE `news` SET  `title` =  '$_POST[title]', `text` =  '$_POST[text]' WHERE  `id` = $_GET[id]");
	$q->execute();
	unset($_POST);
	echo 'News Update<br>';

	}
?>
</div>
<div id="footer" align="center"><font color="red">••InternetDevels••</font></div>
<div id="content">
<?php  if(!empty($_SESSION['user'])) {
		echo 'You logged in login '.$_SESSION['user'].'
	|<a href = "exit.php"> Exit </a>|';
	echo '<br>|<a href="index.php"> Home </a>|';
		} 
?> </div>
</div>
</body>
</html>