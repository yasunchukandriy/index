<?php
error_reporting(E_ALL);
$database_handle=new PDO("mysql:host=localhost;dbname=user",'root','');
if(isset($_SESSION['user']) AND isset($_SESSION['pass']))
	{
	echo 'You are already logged in.';
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
<div >
<div id="login-box">
<H2>Login</H2>
<br />
<br />
<form id='forma' action='auth.php' method='post'>
<div id="login-box-name" style="margin-top:10px;">Login:</div><div id="login-box-field" style="margin-top:10px;"><input name="login" class="form-login" title="login" value="" size="30" maxlength="2048" /></div>
<div id="login-box-name">Password:</div><div id="login-box-field"><input name="password" type="password" class="form-login" title="password" value="" size="30" maxlength="2048" /></div>
<br />
<p><input type=image src=/img/login-btn.png  name='submit' value='Log in' alt='Go!' border=0 style="margin-left:150px;">
<p><b><a href="registration.php" style="margin-left:30px;">Registration</a></b></span></p>
</div>
</div>
</form>
	<?php
}
?>
</body>
</html>
<html>