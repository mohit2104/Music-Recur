<?php
	if(isset($_POST["submit"])) {
		mysql_connect('localhost', 'root', 'root');
		mysql_select_db('music');
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
		        $query = "insert into data values ('' , '".$_POST['name']."', '".$_POST['movie']."', '".$_POST['artist']."', '".$target_file."', '0')";
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
<body>

<form action="" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type='text' name = 'name' placeholder = 'Name of the song'/>
    <input type='text' name = 'movie' placeholder = 'movie'/>
    <input type='text' name = 'artist' placeholder = 'artist'/>
    <input type="submit" value="Upload Image" name="submit">
</form>

</body>
</html>

