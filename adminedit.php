<?php
error_reporting(E_ALL);
//session_start();
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
<body text="white" link="red" vlink="red" alink="red" >
<div id="maket">
<div id="header"><a href="index.php"><img src="img/f_4b1c3b607c0f6.jpg" width="1000"></a></div>
<div id="left">
<?php
	$q = $database_handle->prepare("SELECT * FROM `user` WHERE `id` = '$_GET[edit]'");
	$q->execute();
	$data = $q->fetch(PDO::FETCH_ASSOC);
?>
	<br><p align = center><strong>Editing User: <?php print $data['user'];?></strong>
	<p>Select a user role:</p>
	<form id='forma' action='' method='POST' enctype='multipart/form-data'>
	<SELECT name="role">
	<OPTION value=<?=$data['role'] ?>><?=$data['role'] ?>
	<OPTION value="admin">Administrator
	<OPTION value="editor">Editor
	<OPTION value="user">User
	<OPTION value="blocked">Blocked
	</SELECT>
	<p>Your surname<br /><input type='text' name="surname" class="form-login1" value= <?=$data['username'] ?>></p>
	<p>Your name<br /><input name="name" class="form-login2" value= <?=$data['name'] ?>></p> Edit Avatar <br /> <input type='file' name='filename'>
	<p>Change your email<br /><input type='text' name="changeemail" class="form-login1" value= <?=$data['email'] ?>></p>
	<p><input type='submit' name='submit' value='Add'><br></p></form>
<?php
	if(!empty($_POST['role']) AND !empty($_POST['surname']) AND !empty($_POST['name']) AND !empty($_POST['changeemail']) AND ($_FILES["filename"]["size"] < 1024*5*1024)) {
	if(is_uploaded_file($_FILES["filename"]["tmp_name"])){
	 move_uploaded_file($_FILES["filename"]["tmp_name"], "./img/".$_FILES["filename"]["name"]);
     echo 'Avatar added<br>';
   } else {
      echo 'No avatar';
   }
	$surname = strip_tags(trim($_POST['surname']));
	$name = strip_tags(trim($_POST['name']));
	$email = strip_tags(trim($_POST['changeemail']));
	$filename = $_FILES["filename"]["name"];
	$role = strip_tags($_POST['role']);
	$q = $database_handle->prepare("UPDATE `user` SET `email` = '$email', `username` = '$surname', `name` = '$name', `avatar` = '$filename', `role` = '$role' WHERE `id` = '$_GET[edit]'");
	$q->execute();
		if($q) print('Data add!');
		exit("<meta http-equiv='refresh' content='0; url= 'admin.php?del=<?php print $data[id]; ?>'>");
}

?>
<br><p><strong>CHANGE PASSWORD</strong>
<form id='forma' action='' method='POST' enctype='multipart/form-data'>
	<p>New password<br /><input type='password' name="changepassword" class="form-login1" ></p>
	<p>Repeat new password<br /><input type='password' name="changepassword2" class="form-login1" ></p>
	<p><input type='submit' name='submit' value='Change'><br></p></form>
<?php
if(!empty($_POST['changepassword']) AND !empty($_POST['changepassword2'])){
$pass = strip_tags(md5(trim($_POST['changepassword'])));
if ($_POST['changepassword'] == $_POST['changepassword2']){
		$q = $database_handle->prepare("UPDATE `user` SET `pass` = '$pass' WHERE `id` = '$_GET[edit]'");
		$q->execute();
		if($q) print('Password changed');
		exit("<meta http-equiv='refresh' content='0; url= 'admin.php?del=<?php print $data[id]; ?>'>");
		}
	else {
	print('Passwords do not match');
	exit();
}
}
?>

</div>

<div id="content">
		<?php if(!empty($_SESSION['user'])) {
		echo '<h3>  You logged in login <a href=profile.php>'.$_SESSION['user'].'</a>!</h3>';
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