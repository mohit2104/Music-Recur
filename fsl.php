<?php
	include('../config.php');
	$query = '';
	if($_GET['userId'] > 0)
		$query = "select * from data where user_id = '".$_GET['userId']."' limit 20;";
	else
		$query = "select * from data limit 50;";
	$result = mysql_query($query);
	echo  "["; 
	$id = 0;
	while ( $row = mysql_fetch_assoc($result) ){
		if($id != 0) 
			echo ",";
		echo '{ "oid" : "'.$row["id"].'", "id" : "'.$id.'", "name" : "'.$row["name"].'", "movie" : "'.$row["movie"].'", "artist" : "'.$row["artist"].'", "link" : "'.$row["link"].'", "count" : "'.$row["count"].'"}';
		$id = $id + 1;
	}	
    echo "]";
 ?>