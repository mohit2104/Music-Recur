<?php
    include('../config.php');
    session_start();
    if(!isset($_SESSION['id'])){
        echo "<a href = 'session.php'>Admin verification</a>";
        return;
    }
    $allowedExts = array("mp3");
    $temp = explode(".", $_FILES["file"]["name"]);
    $extension = end($temp);
    if ((($_FILES["file"]["type"] == "audio/mp3") && ($_FILES["file"]["size"] < 10000) && in_array($extension, $allowedExts))) {
        echo "failed";
        return;
    }
    if ($_FILES["file"]["error"] > 0) {
        echo "failed";
        return;
    } 

    $filename = $_FILES["file"]["name"];

    if (file_exists("songs/" . $filename)) {
        echo "failed";
    } else {
        move_uploaded_file($_FILES["file"]["tmp_name"], "songs/" . $filename);
        $query = "insert into data values ('', '".$_SESSION['id']."', '".$_POST['name']."', '".$_POST['movie']."', '".$_POST['artist']."', '".$target_file."', '0')";
        mysql_query( $query );
        echo "success";
    }
?>