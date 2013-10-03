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
$data = $database_handle -> prepare("SELECT * FROM news LIMIT :first, :last ");
$data -> bindParam('first', $first, PDO::PARAM_INT);
$data -> bindParam('last', $last, PDO::PARAM_INT);
$data -> execute();
$all_news = $data -> rowCount();
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
<?php

if (empty($_GET['id']))
{
	?>

<form method = "post">
		  <select name = "current_page">
		    <?php for($i = 1; $i < $limit_page+1; $i++) {?>
		    <option value = "<?php print $i; ?>"><?php print $i; }?></option>
		  </select>
		  <input type = "submit" value="<?php print(translate('Move',$_SESSION['language']))?>">
		</form>

		<?php
	}
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
	?>
<?php
if(!empty($_SESSION['user'])) {
$que = $database_handle->prepare("SELECT * FROM voting WHERE idnews='$_GET[id]' AND user='$_SESSION[user]'");
$que->execute();
$mark_s = $que->fetch(PDO::FETCH_ASSOC);
	if(empty($mark_s)) {
?>
	<form method='post' enctype='multipart/form-data'>
	<p><?php print(translate('VOTE',$_SESSION['language']))?>:</p>
	<p><input type="radio" name="group1" value="5">5</p>
	<p><input type="radio" name="group1" value="4">4</p>
	<p><input type="radio" name="group1" value="3">3</p>
	<p><input type="radio" name="group1" value="2">2</p>
	<p><input type="radio" name="group1" value="1">1</p>
	<input type="hidden" name="id" value=<?php print $_GET['id'] ?>>
	<p><input type='submit' name='submit3' value='<?php print(translate('Vote',$_SESSION['language']))?>'><br></p></form>
	</form>
	<?php
}
else {
echo ''.translate('Your mark',$_SESSION['language']).': '. $mark_s['mark'].' ';
?>
<input type='submit' name='submit' value='<?php print(translate('DELETE VOTE',$_SESSION['language']))?>' onclick="if(confirm('<?php print(translate('Are you sure you want to delete this comment?',$_SESSION['language']))?>'))location.href='delvote.php?delvote=<?php print $mark_s['id']; ?>'">
<?php
}
}
	if (!empty($_POST['group1'])){
	$mark = $_POST['group1'];
	$idnews = $_GET['id'];
	$user_v = $_SESSION['user'];
	$voting_insert = $database_handle->exec("INSERT INTO voting (`idnews`, `user`, `mark`) VALUES ('$idnews' , '$user_v', '$mark')");
	if($voting_insert)
	print(translate('Thanks for your feedback!',$_SESSION['language']));
	}	
	if(!empty($_SESSION['user'])) {
	?>
	<form id='forma' action='' method='post' enctype='multipart/form-data'>
	<h2><p align = center><?php print(translate('Comments',$_SESSION['language']))?></p></h2>
	<p><?php print(translate('Topic',$_SESSION['language']))?><br /><input type='text' name='topic_comments' class="form-login1"></p>
	<p><?php print(translate('Text',$_SESSION['language']))?><br /><textarea rows='10' cols='45' name='text_comments' class="form-login2" required placeholder="<?php print(translate('Enter comments',$_SESSION['language']))?>"></textarea></p> 
	<p><input type='submit' name='submit2' value='<?php print(translate('Add',$_SESSION['language']))?>'><br></p></form>
				<?php

	if (!empty($_POST['submit2'])) {
		if (!empty($_POST['topic_comments'])) {
			$topic_comments = strip_tags(trim($_POST['topic_comments']));
		}
		else {
			$topic_comments = strip_tags(trim(substr($_POST['text_comments'], 0, 15)));
		}
		$text_comments = strip_tags(trim($_POST['text_comments']));
		$user_comments = $_SESSION['user'];
		$date = time(); 
		$idnews=$_GET['id'];
		$comments_insert = $database_handle->exec("INSERT INTO comments (`idnews`, `user_comments`, `topic_comments`, `text_comments`, `create`) VALUES ('$idnews' , '$user_comments', '$topic_comments', '$text_comments', '$date')");
		if ($comments_insert) echo "Comments Add";
	}
}
		$qu = $database_handle->prepare("SELECT * FROM comments WHERE idnews = '$a'");
		$qu->execute();
	?>	

	
<?php
		
	while($mas = $qu->fetch(PDO::FETCH_ASSOC)){
?>

<table>
<tr>
<td width=500>
<?php
	echo '<h1 align=center><font fase=arial black>'.$mas['topic_comments'].'</font></h1>';
	echo '<p align="center">'. translate('Added by:',$_SESSION['language']).'<a href="newsuser.php?user='. $mas['user_comments'] .'">'.$mas['user_comments'].'</a>';
	echo ''. date('d M Y H:i:s', $mas['create']) .'</p>';
	echo '<p align="center">'.$mas['text_comments'].'</i></p>';	

?>
</td>
<td>
<?php
if(!empty($_SESSION['user'])) {
$q = $database_handle->prepare("SELECT * FROM user WHERE `user` = '$_SESSION[user]'");
	$q->execute();
	$role = $q->fetch(PDO::FETCH_ASSOC);
if ($role['role']=='admin'){
	?>
<input type='submit' name='submit' value='<?php print(translate('DELETE COMMENT',$_SESSION['language']))?>' onclick="if(confirm('<?php print(translate('Are you sure you want to delete this comment?',$_SESSION['language']))?>'))location.href='delcomment.php?del=<?php print $mas['idcomment']; ?>'">
<?php
}
}
?>
</td>
</tr>
</table>
<?php

				}
			}
			}
	 	while($data = $q->fetch(PDO::FETCH_ASSOC)) 
		{	
		 	if ($_SESSION['language'] == 'Ukrainian'){
		 		$data['title']=$data['title_ukr'];
	            $data['text']=$data['text_ukr'];	
		 	}
		 	$quer = $database_handle->prepare("SELECT * FROM voting WHERE idnews='{$data['id']}'");
			$quer->execute();
			$mark_mas = $quer->fetch(PDO::FETCH_ASSOC);
			$avg = 0;
			$sum = 0;
		if (!empty($mark_mas)) {
   		foreach ($mark_mas as $value) {
     	$sum += $value['mark'];   
   		}
   		print_r($sum);
   		$avg = $sum / count($mark_mas);
		}
		if ($avg == 0){
    	$avg = translate('For metrial Nobody has voted!',$_SESSION['language']);
		}
		
			
			if (strlen($data['text']) < $your_desired_width) {
				if (($data['img'])==NULL)	
				echo '<i><b><h1 align="center"><a href="index.php?id='.$data['id'].'">'.$data['title'].'</a></h1></b></i><p align="center">' . $avg . '</p><p align="center"> '. translate('Added by:',$_SESSION['language']).'<a href="newsuser.php?user='. $data['user'] .'">'.$data['user'].'</a>       '. date('d M Y H:i:s', $data['date']) .'</p><p align="center">'.$data['text'].'</i></p>';
					else
       			echo '<i><b><h1 align="center"><a href="index.php?id='.$data['id'].'">'.$data['title'].'</a></h1></b></i><p align="center">' . $avg . '</p><p align="center"> '. translate('Added by:',$_SESSION['language']).' <a href="newsuser.php?user='. $data['user'] .'">'.$data['user'].'</a>       '. date('d M Y H:i:s', $data['date']) .'</p><p align="center"><img src="http://'.$_SERVER['HTTP_HOST'].'/img/'.$data['img'].'" height="400" width="600"></p><p align="center">'.$data['text'].'</i></p>';
    			}
    		else  {
    			$data['text'] = wordwrap($data['text'], $your_desired_width);
    			$i = strpos($data['text'], "\n");
    			if ($i) {
        		$data['text'] = substr($data['text'], 0, $i);
    			}
    			if (($data['img'])==NULL)
				echo '<i><b><h1 align="center"><a href="index.php?id='.$data['id'].'">'.$data['title'].'</a></h1></b></i><p align="center">' . $avg . '</p> <p align="center">'. translate('Added by:',$_SESSION['language']).' <a href="newsuser.php?user='. $data['user'] .'">'.$data['user'].'</a>       '. date('d M Y H:i:s', $data['date']) .'</p><p align="center">'.$data['text'].'</i> | <a href="index.php?id='.$data['id'].'">'. translate('Read more',$_SESSION['language']).'</a></p>';
    			else
    			echo '<i><b><h1 align="center"><a href="index.php?id='.$data['id'].'">'.$data['title'].'</a></h1></b></i><p align="center">' . $avg . '</p> <p align="center">'. translate('Added by:',$_SESSION['language']).' <a href="newsuser.php?user='. $data['user'] .'">'.$data['user'].'</a>       '. date('d M Y H:i:s', $data['date']) .'</p><p align="center"><img src="http://'.$_SERVER['HTTP_HOST'].'/img/'.$data['img'].'" height="400" width="600"></p><p align="center">'.$data['text'].'</i> | <a href="index.php?id='.$data['id'].'">'. translate('Read more',$_SESSION['language']).'</a></p>';
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