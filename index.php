<head >
 <title >CSI3660 Project Webpage </title >
 </head >
 <body >
 <h1>CSI3660 Project </h1>
<p>Project Description: A web server for sharing files, you can upload new files and look through the files that have been uploaded previously. </p>
<p></p>
<p> Group members: Robert Martin, Cassie Allard, Morgan Clapsaddle

<p>
<br>
<input name="file" type="file" id="file" size="80"> <br>

<input type="submit" id="u_button" name="u_button" value="Upload the File">

</p>
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
