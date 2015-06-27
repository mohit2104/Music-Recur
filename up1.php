<?php
	include('../config.php');
	session_start();
	if(!isset($_SESSION['id'])){
		echo "<a href = 'session.php'>Admin verification</a>";
		return;
	}
    $query = "insert into data values ('', '".$_SESSION['id']."', '".$_POST['name']."', '".$_POST['movie']."', '".$_POST['artist']."', '".$_POST['path']."', '0')";
    if(mysql_query( $query )){
    	echo "success";
    }
    else{
    	echo "failed";
    }  
?>