<?php 
//session_start();
				echo '<br>|<a href="index.php"> Log </a>|';
				session_destroy();
				session_write_close();
 		exit("<meta http-equiv='refresh' content='0; url= index.php'>");
?> 
