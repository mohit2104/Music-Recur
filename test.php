<?php

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
        echo "success";
    }

?>

<!DOCTYPE html>
<html>
<head>
    <title>Image Upload Form</title>
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script>
        $scope.upsong = function submitForm() {
            console.log("Uploading a song");
            var fd = new FormData(document.getElementById("frm"));
            fd.append("label", "WEBUPLOAD");
            $.ajax({
              url: "test.php",
              type: "POST",
              data: fd,
              enctype: 'multipart/form-data',
              processData: false,  // tell jQuery not to process the data
              contentType: false   // tell jQuery not to set contentType
            }).done(function( data ) {
                console.log("PHP Output:");
                console.log( data );
            });
            return false;
        }
    </script>
</head>

<body>
    <form method="post" id="fileinfo" name="fileinfo" onsubmit="return submitForm();">
        <label>Select a file:</label><br>
        <input type="file" name="file" required />
        <input type='text' name='name' />
        <button onclick = 'submitForm()' value="Upload" />
    </form>
    <div id="output"></div>
</body>
</html>