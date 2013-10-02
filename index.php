<?php
// session_start();
error_reporting(E_ALL);
 ini_set("include_path",getenv("DOCUMENT_ROOT")."/function");
    include "translate.php";
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
<style>
   body {
    background-image: url(img/45.jpg); 
    background-color: #c7b39b;
   }
  </style>
</head>
<body text="white" link="red" vlink="red" alink="red" >
<div id="maket">
<div id="header">
<a href=<?php print "index.php?lang=English&" . http_build_query($_GET) ?>><img src="/img/flag-en0.gif"></a>
<a href=<?php print "index.php?lang=Ukrainian&" . http_build_query($_GET) ?>><img src="/img/flag_ukr.gif"></a>

        <!-- <input type=image src="/img/flag-en0.gif"  name='en'  alt='Go!' onclick="location.href='index.php?lang=English'">    -->
        <!-- <input type=image src="/img/flag_ukr.gif"  name="ukr"  alt="Go!" onclick="location.href='index.php?lang=Ukrainian'">      -->
<a href="index.php"><img src="img/f_4b1c3b607c0f6.jpg" width="1000"></a>
</div>
<div id="left">
<form method = "post">
		  <select name = "current_page">
		    <?php for($i = 1; $i < $limit_page+1; $i++) {?>
		    <option value = "<?php print $i; ?>"><?php print $i; }?></option>
		  </select>
		  <input type = "submit" value="<?php print(translate('Move',$_SESSION['language']))?>">
		</form>
		<?php
	// for($i=0; $i < $limit; $i++):
	// $this_news = ($_SESSION['current_page']-1)*10+$i+1;
	?>
<?php 
		
		$your_desired_width = 150;
		echo '<br><p align = center><strong> '. translate('NEWS',$_SESSION['language']).'</strong></p>';
	 	// $q = $database_handle->prepare("SELECT * FROM news ORDER BY ID");
	 	$first = ($_SESSION['current_page']-1)*10;
		$last = 10;
		$q = $database_handle -> prepare("SELECT * FROM news ORDER BY ID LIMIT :first, :last ");
		$q -> bindParam('first', $first, PDO::PARAM_INT);
		$q -> bindParam('last', $last, PDO::PARAM_INT);
	 	$q->execute();	 
	
	 	if(!empty($_GET['id'])) {
				$a = $_GET['id'];
				$q = $database_handle->prepare("SELECT * FROM news WHERE id = '$a'");
	 			$q->execute();
	 			$data = $q->fetch(PDO::FETCH_ASSOC);
			 	if ($_SESSION['language'] == 'Ukrainian'){
			 		$data['title']=$data['title_ukr'];
		            $data['text']=$data['text_ukr'];	
			 	}
				if (strcmp($data['id'],$a) == 0){
				if (($data['img'])==NULL)	
				echo '<i><b><h1 align="center">'.$data['title'].'</h1></b></i><p align="center">Added by: <a href="newsuser.php?user='. $data['user'] .'">'.$data['user'].'</a>       '. date('d M Y H:i:s', $data['date']).'</p><p align="justify">'.$data['text'].'|<a href="index.php"> Back </a>|</p>';
			else
				echo '<i><b><h1 align="center">'.$data['title'].'</h1></b></i><p align="center">Added by: <a href="newsuser.php?user='. $data['user'] .'">'.$data['user'].'</a>       '. date('d M Y H:i:s', $data['date']).'</p><p align="center"><img src="http://'.$_SERVER['HTTP_HOST'].'/img/'.$data['img'].'" height="400" width="600"></p><p align="justify">'.$data['text'].'|<a href="index.php"> Back </a>|</p>';
				}
			}
	 	while($data = $q->fetch(PDO::FETCH_ASSOC)) 
		{	
		 	if ($_SESSION['language'] == 'Ukrainian'){
		 		$data['title']=$data['title_ukr'];
	            $data['text']=$data['text_ukr'];	
		 	}

			if (strlen($data['text']) < $your_desired_width) {
				if (($data['img'])==NULL)	
				echo '<i><b><h1 align="center"><a href="index.php?id='.$data['id'].'">'.$data['title'].'</a></h1></b></i><p align="center">'. translate('Added by:',$_SESSION['language']).'<a href="newsuser.php?user='. $data['user'] .'">'.$data['user'].'</a>       '. date('d M Y H:i:s', $data['date']) .'</p><p align="center">'.$data['text'].'</i></p>';
					else
       			echo '<i><b><h1 align="center"><a href="index.php?id='.$data['id'].'">'.$data['title'].'</a></h1></b></i><p align="center">'. translate('Added by:',$_SESSION['language']).' <a href="newsuser.php?user='. $data['user'] .'">'.$data['user'].'</a>       '. date('d M Y H:i:s', $data['date']) .'</p><p align="center"><img src="http://'.$_SERVER['HTTP_HOST'].'/img/'.$data['img'].'" height="400" width="600"></p><p align="center">'.$data['text'].'</i></p>';
    			}
    		else  {
    			$data['text'] = wordwrap($data['text'], $your_desired_width);
    			$i = strpos($data['text'], "\n");
    			if ($i) {
        		$data['text'] = substr($data['text'], 0, $i);
    			}
    			if (($data['img'])==NULL)
				echo '<i><b><h1 align="center"><a href="index.php?id='.$data['id'].'">'.$data['title'].'</a></h1></b></i><p align="center">'. translate('Added by:',$_SESSION['language']).' <a href="newsuser.php?user='. $data['user'] .'">'.$data['user'].'</a>       '. date('d M Y H:i:s', $data['date']) .'</p><p align="center">'.$data['text'].'</i> | <a href="index.php?id='.$data['id'].'">'. translate('Read more',$_SESSION['language']).'</a></p>';
    			else
    			echo '<i><b><h1 align="center"><a href="index.php?id='.$data['id'].'">'.$data['title'].'</a></h1></b></i><p align="center">'. translate('Added by:',$_SESSION['language']).' <a href="newsuser.php?user='. $data['user'] .'">'.$data['user'].'</a>       '. date('d M Y H:i:s', $data['date']) .'</p><p align="center"><img src="http://'.$_SERVER['HTTP_HOST'].'/img/'.$data['img'].'" height="400" width="600"></p><p align="center">'.$data['text'].'</i> | <a href="index.php?id='.$data['id'].'">'. translate('Read more',$_SESSION['language']).'</a></p>';
    		}
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
	<li><a href="newsedit.php"><span><?php print(translate('Edit News',$_SESSION['language']))?></span></a></li>
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