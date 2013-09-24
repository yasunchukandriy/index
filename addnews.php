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
	<br><p align = center><strong>ADD NEWS</strong>
	<form id='forma' action='' method='post' enctype='multipart/form-data'>
	<p>Title<br /><input type='text' name='title'></p>
	<p>Text<br /><textarea rows='10' cols='45' name='text'></textarea></p> Add a picture <br /> <input type='file' name='filename'>
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
   	$title = trim($_POST['title']);
	$text = trim($_POST['text']);
	$filename = $_FILES["filename"]["name"];
	$user = $_SESSION['user'];
	$date = time();
	$insert = $database_handle->exec("INSERT INTO news (`title`, `text`, `img`, `user`, `date`) VALUES ('$title' , '$text', '$filename', '$user', '$date')");
	unset($_POST);
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