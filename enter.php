﻿<?php
error_reporting(E_ALL);
$database_handle=new PDO("mysql:host=localhost;dbname=user",'root','');
if(isset($_SESSION['user']) AND isset($_SESSION['pass']))
	{
	echo ''.translate('You are already logged in.',$_SESSION['language']).'';
	} 
else {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta charset="utf-8"/>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="login-box.css" rel="stylesheet" type="text/css" />
<style>
   body {
	background-image: url(img/45.jpg); 
	background-color: #c7b39b;
   }
  </style>
</head>
<body link="#cecece" vlink="#cecece" alink="#ff0000">
<?php if(empty($_SESSION['user'])) 
		echo '<h3>'.translate('You logged in login Anonim!',$_SESSION['language']).' </h3>';
		echo '<h3>  <a href="listuser.php">'.translate('LIST USER',$_SESSION['language']).'</a></h3>';
		?>
<div id="login-box">
<H2><?php print(translate('LOGIN',$_SESSION['language']))?></H2>
<br />
<br />
<form id='forma' action='auth.php' method='post'>
<div id="login-box-name" style="margin-top:10px;"><?php print(translate('Login',$_SESSION['language']))?>:</div><div id="login-box-field" style="margin-top:10px;"><input name="login" class="form-login" title="login" value="" size="30" maxlength="2048" /></div>
<div id="login-box-name"><?php print(translate('Password',$_SESSION['language']))?>:</div><div id="login-box-field"><input name="password" type="password" class="form-login" title="password" value="" size="30" maxlength="2048" /></div>
<br />
<p><input type=image src=/img/login-btn.png  name='submit' value='Log in' alt='Go!' border=0 style="margin-left:150px;">
<p><b><a href="registration.php" style="margin-left:30px;"><?php print(translate('Registration',$_SESSION['language']))?></a></b></span></p>
</div>
</div>
</form>
	<?php
}
?>
</body>
</html>
<html>