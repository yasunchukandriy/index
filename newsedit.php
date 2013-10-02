<?php
error_reporting(E_ALL);
//session_start();
 ini_set("include_path",getenv("DOCUMENT_ROOT")."/function");
    include "translate.php";
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
<div id="header">
<a href=<?php print "newsedit.php?lang=English&" . http_build_query($_GET) ?>><img src="/img/flag-en0.gif"></a>
<a href=<?php print "newsedit.php?lang=Ukrainian&" . http_build_query($_GET) ?>><img src="/img/flag_ukr.gif"></a>
<a href="index.php"><img src="img/f_4b1c3b607c0f6.jpg" width="1000"></a></div>
<div id="left">
<?php
echo '<br><p align = center><strong>'.translate('EDIT NEWS',$_SESSION['language']).' </strong></p>';
	if ($role['role'] == 'admin')
	{
	$q = $database_handle->prepare("SELECT * FROM news ORDER BY ID");
	$q->execute();
	while($data = $q->fetch(PDO::FETCH_ASSOC)) {	
	echo '<p><b>'.$data['title'].'</b>';
?>
	<input type='submit' name='submit' value='<?php print(translate('EDIT',$_SESSION['language']))?>' onclick="location.href='newsedit.php?edit=<?php print $data['id']; ?>'">
	<input type='submit' name='submit' value='<?php print(translate('DELETE',$_SESSION['language']))?>' onclick="if(confirm('Are you sure you want to delete this user?'))location.href='newsedit.php?del=<?php print $data['id']; ?>'">	
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
	<input type='submit' name='submit' value='<?php print(translate('EDIT NEWS',$_SESSION['language']))?>' onclick="location.href='newsedit.php?edit=<?php print $data['id']; ?>'">
	<input type='submit' name='submit' value='<?php print(translate('DELETE',$_SESSION['language']))?>' onclick="if(confirm('Are you sure you want to delete this user?'))location.href='newsedit.php?del=<?php print $data['id']; ?>'">	
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
<p align = center><strong><?php print(translate('English Version',$_SESSION['language']))?></strong></p>
<p><?php print(translate('Title',$_SESSION['language']))?><br /><input type='text' name='title' class="form-login1" value= <?=$data["title"] ?> ></p>
<p><?php print(translate('Text',$_SESSION['language']))?><br /><textarea rows='10' cols='45' name='text' class="form-login2"><?=$data['text']?></textarea></p>
<p align = center><strong><?php print(translate('Ukrainian Version',$_SESSION['language']))?></strong></p>
<p><?php print(translate('Title',$_SESSION['language']))?><br /><input type='text' name='title_ukr' class="form-login1" value= <?=$data["title_ukr"] ?> ></p>
<p><?php print(translate('Text',$_SESSION['language']))?><br /><textarea rows='10' cols='45' name='text_ukr' class="form-login2"><?=$data['text_ukr']?></textarea></p>
<p><input type='submit' name='submit' value='<?php print(translate('Update',$_SESSION['language']))?>'>
<br></p></form>
<?php
if(!empty($_POST['title']) AND !empty($_POST['text']) AND !empty($_POST['text_ukr']) AND !empty($_POST['text_ukr'])) {
	$title = strip_tags(trim($_POST['title']));
	$text = strip_tags(trim($_POST['text']));
	$title_ukr = strip_tags(trim($_POST['title_ukr']));
	$text_ukr = strip_tags(trim($_POST['text_ukr']));
	$q = $database_handle->prepare("UPDATE `news` SET  `title` =  '$title', `text` =  '$text', `title_ukr` =  '$title_ukr', `text_ukr` =  '$text_ukr' WHERE  `id` = $_GET[edit]");
	$q->execute();
	unset($_POST);
	echo ''.translate('News Update',$_SESSION['language']).'';
	}
?>
</div>
<div id="content">
		<?php if(!empty($_SESSION['user'])) {
echo '<h3>  '. translate('You logged in login',$_SESSION['language']).' <a href=profile.php>'.$_SESSION['user'].'</a>!</h3>';
		?>
<ul id="my_menu">
	<li><a href="index.php"><span><?php print(translate('Home',$_SESSION['language']))?></span></a></li>
	<li><a href="profile.php"><span><?php print(translate('Profile',$_SESSION['language']))?></span></a></li>
	<li><a href="addnews.php"><span><?php print(translate('Add News',$_SESSION['language']))?></span></a></li>
	<li><a href="exit.php"><span><?php print(translate('Exit',$_SESSION['language']))?></span></a></li>
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