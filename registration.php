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
	$your_desired_width = 150;
		echo '<br><p align = center><strong>NEWS</strong></p>';
	 	$q = $database_handle->prepare("SELECT * FROM news ORDER BY ID");
	 	$q->execute();
	 	while($data = $q->fetch(PDO::FETCH_ASSOC)) 
		{	
			if (strlen($data['text']) > $your_desired_width) {
    			$data['text'] = wordwrap($data['text'], $your_desired_width);
    			$i = strpos($data['text'], "\n");
    		if ($i) {
        		$data['text'] = substr($data['text'], 0, $i);
    			}
    			}
			if(!empty($_GET['id'])) {
				$q = $database_handle->prepare("SELECT * FROM news WHERE id = '$_GET[id]'");
	 			$q->execute();
	 			$data = $q->fetch(PDO::FETCH_ASSOC);
			if (strcmp($data['id'],$a) == 0){	
				echo '<i><b><h1 align="center">'.$data['title'].'</h1></b></i><p align="center">Added by: '.$data['user'].'       '. date('d M Y H:i:s', $data['date']).'</p><p align="center"><img src="http://'.$_SERVER['HTTP_HOST'].'/img/'.$data['img'].'" height="400" width="600"></p><p align="justify">'.$data['text'].'</p>';
				}
				}
			else {
				echo '<i><b><h1 align="center">'.$data['title'].'</h1></b></i><p align="center">Added by: '.$data['user'].'       '. date('d M Y H:i:s', $data['date']) .'</p><p align="center"><img src="http://'.$_SERVER['HTTP_HOST'].'/img/'.$data['img'].'" height="400" width="600"></p><p align="center">'.$data['text'].'</i> | <a href="index.php?id='.$data['id'].'">Read more</a></p>';
				echo '<br />';
				}
				} 
				?>
</div>
<div id="footer" align="center"><font color="red">••InternetDevels••</font></div>
<div id="content">
	<form action='reg.php' method='POST'>
	<h1>Registration</h1>
	<p>Login<br /><input type='text' name='login' ></p>
	<p>Password<br /><input type='password' name='password' ></p>
	<p>Repeat password<br /><input type='password' name='password2'></p>
	<p><input type='submit' value='Registration' name='submit' ></p>|<a href="index.php"> Log </a>|
	</form>
</div>
</div>
</body>
</html>


