<?php
	include("../config.php");
	global $key;
	session_start();
	if(isset($_POST['submit']) && isset($_POST['key']) && $_POST['key'] == $key){
	$_SESSION['log'] = "t";
	echo "<a href = 'upload.php'>Upload</a>";
	return;
}
?>

<form action = "" method = "post">
<input type = 'text' name = 'key' />
<input type = 'submit' name = 'submit' />
</form>



		
