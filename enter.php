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
<title>Login Box HTML Code - www.PSDGraphics.com</title>
<link href="login-box.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div style="padding: 100px 0 0 250px;">
<div id="login-box">
<H2>Login</H2>
<br />
<br />
<form id='forma' action='auth.php' method='post'>
<div id="login-box-name" style="margin-top:10px;">Login:</div><div id="login-box-field" style="margin-top:10px;"><input name="login" class="form-login" title="login" value="" size="30" maxlength="2048" /></div>
<div id="login-box-name">Password:</div><div id="login-box-field"><input name="password" type="password" class="form-login" title="password" value="" size="30" maxlength="2048" /></div>
<br />
<p><input type=image src=/img/login-btn.png  name='submit' value='Log in' alt='Go!' border=0 style="margin-left:150px;">
</div>
</div>
</form>
	<?php
}
?>
</body>
</html>
<html>

<!-- <meta charset="utf-8"/>
<body>


               	<h1>Log</h1>
	<p>Login<br /><input type='text' name='login'></p>
	<p>Password<br /><input type='password' name='password'></p>
	<p><input type='submit' name='submit' value='Log in'>
	<br></p></form><p><a href='registration.php'>Registration</a></p>
	

	</body>
	</html> -->