<?php
	include('../config.php');
	session_start();
	if(!isset($_SESSION['id'])){
		echo "<a href = 'session.php'>Admin verification</a>";
		return;
	}
	if(isset($_POST["submit"])) {
		$target_dir = "songs/";
		$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
		$uploadOk = 1;
		if(file_exists($target_file)) {
		    echo "Sorry, file already exists.";
		    $uploadOk = 0;
		}

		if($uploadOk == 0) {
		    echo "Sorry, your file was not uploaded.";
		} else {
		    if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
		        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
		        $query = "insert into data values ('', '".$_SESSION['id']."', '".$_POST['name']."', '".$_POST['movie']."', '".$_POST['artist']."', '".$target_file."', '0')";
		        mysql_query( $query );
		    } else {
		    	echo $_FILES['fileToUpload']['error'];
		        echo "Sorry, there was an error uploading your file.";
		    }
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
	<style>
		#nav{
			position : absolute; 
			left : 0%;
			top : 0%;
			width : 100%;
			height: 50px;
			background : black;
		}
		#upf{
			position: absolute;
			top : 120px;
			width : 100%;
		}
		.inp{
			padding : 10px;
		}
		input{
			font-size: 25px;
			padding : 10px;
			margin : 0px;
		}
		.upload{
			margin : 15px;
			color : white;
			font-size : 20px;
			cursor : pointer;
			text-decoration: none;
		}
	</style>
</head>	
<body>
<div id ='nav'>
	<div class = 'upload link' style = 'float : left' ng-click = "getNewList('0', 'Default')">
		Home <i class  ='fa fa-home'></i>
	</div>
	<div class = 'upload' style = 'float : left'>
		Edit <i class  ='fa fa-edit'></i>
	</div>
</div>
</div>
<form id = 'upf' action="" method="post" enctype="multipart/form-data">
	<div class = 'inp'>
		<span style = 'font-size : 25px; font-family : courier; background : rgba(100, 100, 100, 0.3)'>
			UPLOAD A NEW SONG
		</span><br>
    	<input type="file" name="fileToUpload" id="fileToUpload"  \>
    </div>
    <div class = 'inp'>
    	<input type='text' name = 'name' placeholder = 'Song Name'/>
    </div>
    <div class = 'inp'>
    	<input type='text' name = 'movie' placeholder = 'Movie Name'/>
    </div>
    <div class = 'inp'>
    	<input type='text' name = 'artist' placeholder = 'Artists Name'/>
    </div>
    <div class  = 'inp'>
    	<input type="submit" value="Upload Song" name="submit" />
    </div>
</form>

</body>
</html>

