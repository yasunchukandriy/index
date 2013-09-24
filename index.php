﻿<?php
// session_start();
error_reporting(E_ALL);
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
</head>
<body>
<div id="maket">
<div id="header"></div>
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
<div id="footer"  class="footer" align="center"><font color="red">••InternetDevels••</font></div>
<div id="content">
		<?php if(!empty($_SESSION['user'])) {
		echo 'You logged in login '.$_SESSION['user'].'
	|<a href = "exit.php"> Exit </a>|';
	echo '|<a href="addnews.php"> Add news </a>|';
	echo '|<a href="newsedit.php"> Edit news </a>|';
	echo '|<a href="index.php"> Home </a>|';
		} 
		else {
		include 'enter.php';
		}
?> 
</div>
</div>
</body>
</html>