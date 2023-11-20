<html >
<body style="background-color:#33475b">
<head >
<title >F4U: Files 4 You </title>
</head >
<body >
<center>
        <h1> F4U: Files 4 You </h1>
        <br>

                <input name="file" type="file" id="file" size="80"> <br>

        <input type="submit" id="u_button" name="u_button" value="Upload the File">


<center>

<?php
 $file_result = "";

        if ($_FILES["file"]["error"] > 0)
        {
        $file_result .= "No File Uploaded or Invalid File ";
        $file_result .= "Error Code: " . $_FILES["file"]["error"] . "<br>";
        } else {

        $file_result .=
        "Upload: " . $_FILES["file"]["name"] . "<br>" .
        "Type: " . $_FILES["file"]["type"] . "<br>" .
        "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br>" .
        "Temp files: " . $_FILES["file"]["tmp_name"] . "<br>";

        move_uploaded_file($_FILES ["file"]["tmp_name"],
        "/full/path/on/server/" . $_FILES["file"]["name"]);

        $file_result .= "File Upload Successful!";
        }
?>
</body >
</html >
                                                                                             1,7           Top
