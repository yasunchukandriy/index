<?php
error_reporting(E_ALL);
//session_start();
	if(empty($_SESSION['user'])) {
		exit();
		}
	$database_handle=new PDO("mysql:host=localhost;dbname=user",'root','');
	$q = $database_handle->prepare("SELECT * FROM user WHERE `user` = '$_SESSION[user]'");
	$q->execute();
	$data = $q->fetch(PDO::FETCH_ASSOC);
	if ($data['role'] == 'user')
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
<body text="white" link="red" vlink="red" alink="red" >
<div id="maket">
<div id="header"><a href="index.php"><img src="img/f_4b1c3b607c0f6.jpg" width="1000"></a></div>
<div id="left">
	<br><p align = center><strong>ADD NEWS</strong>
	<form id='forma' action='' method='post' enctype='multipart/form-data'>
	<p>Title<br /><input type='text' name='title' class="form-login1"></p>
	<p>Text<br /><textarea rows='10' cols='45' name='text' class="form-login2"></textarea></p> Add a picture <br /> <input type='file' name='filename'>
	<br>
	<p><input type='submit' name='submit' value='Add'><br></p></form>
	<?
	if(!empty($_POST['title']) AND !empty($_POST['text']) AND $_FILES["filename"]["size"] < 1024*3*1024)
	{	
	 if(is_uploaded_file($_FILES["filename"]["tmp_name"]))
   {
     move_uploaded_file($_FILES["filename"]["tmp_name"], "./img/".$_FILES["filename"]["name"]);
     echo 'File added<br>';
   } else {
      echo("Error loading file");
   }
   	$title = strip_tags(trim($_POST['title']));
	$text = strip_tags(trim($_POST['text']));
	$filename = $_FILES["filename"]["name"];
	$user = $_SESSION['user'];
	$date = time();
	$insert = $database_handle->exec("INSERT INTO news (`title`, `text`, `img`, `user`, `date`) VALUES ('$title' , '$text', '$filename', '$user', '$date')");
	unset($_POST);
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