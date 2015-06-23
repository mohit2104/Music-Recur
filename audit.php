<?php
	include('../config.php');
	$query = "UPDATE `data` SET `count` = (`count` + 1) where id = ".$_GET['id'].";";
	mysql_query($query);

?>
	 

