<?php
error_reporting(E_ALL);
//session_start();
$database_handle=new PDO("mysql:host=localhost;dbname=user",'root','');
if (!empty($_POST['current_page'])) {
	$_SESSION['current_page'] = $_POST['current_page'];
	}
else {
	$_SESSION['current_page'] = 1;
}
$first=0;
$last = 100000;
$news = $database_handle -> prepare("SELECT * FROM news LIMIT :first, :last ");
$news -> bindParam('first', $first, PDO::PARAM_INT);
$news -> bindParam('last', $last, PDO::PARAM_INT);
$news -> execute();
$all_news = $news -> rowCount();
$limit_page = ceil($all_news / 10);
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
<div id="header"><img src="img/f_4b1c3b607c0f6.jpg" width="1000"></div>
<div id="left">
<form method = "post">
		  <select name = "current_page">
		    <?php for($i = 1; $i < $limit_page+1; $i++) {?>
		    <option value = "<?php print $i; ?>"><?php print $i; }?></option>
		  </select>
		  <input type = "submit" value="Move "/>
		</form>
		<?php
	// for($i=0; $i < $limit; $i++):
	// $this_news = ($_SESSION['current_page']-1)*10+$i+1;
	?>
<?php 

		$your_desired_width = 150;
		echo '<br><p align = center><strong>NEWS</strong></p>';
	 	// $q = $database_handle->prepare("SELECT * FROM news ORDER BY ID");
	 	$first = ($_SESSION['current_page']-1)*10;
		$last = 10;
		$q = $database_handle -> prepare("SELECT * FROM news ORDER BY ID LIMIT :first, :last ");
		$q -> bindParam('first', $first, PDO::PARAM_INT);
		$q -> bindParam('last', $last, PDO::PARAM_INT);
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
				$a = $_GET['id'];
				$q = $database_handle->prepare("SELECT * FROM news WHERE id = '$a'");
	 			$q->execute();
	 			$data = $q->fetch(PDO::FETCH_ASSOC);
			if (strcmp($data['id'],$a) == 0){	
				echo '<i><b><h1 align="center">'.$data['title'].'</h1></b></i><p align="center">Added by: '.$data['user'].'       '. date('d M Y H:i:s', $data['date']).'</p><p align="center"><img src="http://'.$_SERVER['HTTP_HOST'].'/img/'.$data['img'].'" height="400" width="600"></p><p align="justify">'.$data['text'].'|<a href="index.php"> Back </a>|</p>';
				}
			}
			else {
				echo '<i><b><h1 align="center">'.$data['title'].'</h1></b></i><p align="center">Added by: '.$data['user'].'       '. date('d M Y H:i:s', $data['date']) .'</p><p align="center"><img src="http://'.$_SERVER['HTTP_HOST'].'/img/'.$data['img'].'" height="400" width="600"></p><p align="center">'.$data['text'].'</i> | <a href="index.php?id='.$data['id'].'">Read more</a></p>';
				echo '<br />';
				}
				} 
?>
</div>

<div id="content">
<div id="login-box">
<H2>Registration</H2>
<form id='forma' action='reg.php' method='post'>
<div id="login-box-name" style="margin-top:10px;">Login:</div><div id="login-box-field" ><input name="login" class="form-login" title="login" value="" size="30" maxlength="2048" /></div>
<div id="login-box-name">Password:</div><div id="login-box-field"><input name="password" type="password" class="form-login" title="password" value="" size="30" maxlength="2048" /></div>
<div id="login-box-name">Repeat password:</div><div id="login-box-field"><input name="password2" type="password" class="form-login" title="password" value="" size="30" maxlength="2048" /></div>
<div id="login-box-name" style="margin-top:10px;">Email:</div><div id="login-box-field" style="margin-top:10px;"><input name="email" title="email" class="form-login" title="login" value="" size="30" maxlength="2048" /></div>
<br />
<b><a href="index.php" style="margin-right:300px;">Log</a></b>
<p><input type=image src=/img/11.png  name='submit' value='Log in' alt='Go!' border=0 style="margin-left:150px; margin-buttom:300px;">
</div>
</div>
</div>
</div>
</body>
</html>


