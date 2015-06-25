<?php
	include('../config.php');
	$query = "select * from data where user_id = '".$_GET['userId']."' limit 10;";
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