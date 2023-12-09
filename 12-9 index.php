<?php
include 'server.php';
include 'logger.php';
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


function getUsernameFromFilePath($filePath) {
        $parts = explode('/', $filePath);
        $username = $parts[1];
        return "username";
}

if (!isset($_SESSION['username'])) {
        $_SESSION['msg'] = "You must log in first";
        header('location: login.php');
}

if (isset($_GET['logout'])) {
        session_destroy();
        unset($_SESSION['username']);
        header("location: login.php");
}


if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST["upload"])){
                //Handles uploading files to database
                $username = $_SESSION['username'];
                $userID = $_SESSION['id'];
                $targetDirectory = "uploads/";
                $targetFile = $targetDirectory . basename($_FILES["file"]["name"]);
                move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile);
                $db = new mysqli('localhost', 'root', 'morganclapsaddle', 'project');

                if ($db->connect_error) {
                        logEvent("Failed", "File uploaded by user: $username, File: $targetFile");
                        die("Connection failed: " . $db->connect_error);
                }


                $querySelect = "SELECT files FROM users WHERE username = ?";
                $stmtSelect = $db->prepare($querySelect);
                $stmtSelect->bind_param("s", $username);
                $stmtSelect->execute();
                $stmtSelect->bind_result($existingFiles);
                $stmtSelect->fetch();
                $stmtSelect->close();

                $updatedFiles = rtrim($existingFiles, ',') . "," . $targetFile;



                $queryUpdate = "UPDATE  users SET files = ? WHERE username = ?";
                $stmtUpdate = $db->prepare($queryUpdate);
                $stmtUpdate->bind_param("ss", $updatedFiles, $username);
                $stmtUpdate->execute();
                $stmtUpdate->close();
                $db->close();
                // Log file upload
                logEvent("success", "File uploaded by user: $username, File: $targetFile");

        } else if (isset($_POST["search"])) {

                $username = $_SESSION['username'];
                $db = new mysqli('localhost', 'root', 'morganclapsaddle', 'project');

                if ($db->connect_error) {
                        die("Connection failed: " . $db->connect_error);
                }

                // Retrieve files for the user from the database
                $querySearch = "SELECT files FROM users WHERE username = ?";
                $stmtSearch = $db->prepare($querySearch);
                $stmtSearch->bind_param("s", $username);
                $stmtSearch->execute();
                $stmtSearch->bind_result($files);
                $stmtSearch->fetch();


                $stmtSearch->close();
                $db->close();






        } else if (isset($_POST["open"])){
                // Handle file open
                $selectedFile = "uploads/" . $_POST["file"];
                if (file_exists($selectedFile)) {
                        $fileContents = htmlspecialchars( file_get_contents($selectedFile));

                        if ($fileContents !== false) {
                                // Output file contents or perform actions based on the file contents
                                echo "File contents: <br>";
                                echo nl2br($fileContents);
                        }else {
                                echo "Error reading file contents.";
                        }
                }
        }



        if (isset($_GET["delete"])) {
                $deletedFile = "uploads/" . trim($_GET["delete"]);
                if (file_exists($deletedFile)) {
                        unlink($selectedFile);


                        // Remove the file path from the database
                        $username = $_SESSION['username'];
                        $db = new mysqli('localhost', 'root', 'morganclapsaddle', 'project');
                        if ($db->connect_error) {
                                die("Connection failed: " . $db->connect_error);
                        }

                        $queryDelete = "UPDATE users SET files = REPLACE(files, ?, '') WHERE username = ?";
                        $stmtDelete = $db->prepare($queryDelete);
                        $stmtDelete->bind_param("ss", $deletedFile, $username);
                        $stmtDelete->execute();

                        $stmtDelete->close();
                        $db->close();
                }
        }



        $dirpath = "uploads/*";
        $files = array();
        $files = glob($dirpath);
        usort($files, function($x, $y) {
                return filemtime($x) < filemtime($y);
        });

        echo "<div>";

        foreach($files as $item){

                echo "</div>";

        }

}
?>

<!DOCTYPE html>
<html>
<head>

    <link rel="stylesheet" type="text/css" href="style.css">
        <style>
    /* Add or update the style for the file links */
    a {
        color: white;
    }

    /* Add or update the style for visited links if needed */
    a:visited {
        color: yellow;
    }
        </style>

</head>
<body style="background-color:#33475b">


<div class="title-container">
    <div class="title">
        <h2>F4U: Files 4 You</h2>
        <style> text-align:center </style>

    </div>
    </div>
    </div>
</div>



<div class="header">
    <h2>Home Page</h2>
</div>

<div class="content">
    <!-- notification message -->
    <?php if (isset($_SESSION['success'])) : ?>
        <div class="error success">
            <h3>
                <?php
                echo $_SESSION['success'];
                unset($_SESSION['success']);
                ?>
            </h3>
        </div>
    <?php endif ?>

    <!-- logged in user information -->
    <?php if (isset($_SESSION['username'])) : ?>
        <p>Welcome <strong><?php echo $_SESSION['username']; ?></strong></p>
        <p> <a href="index.php?logout='1'" style="color: red;">logout</a> </p>
    <?php endif ?>
</div>

<div class="container" id="fileUploadForm">
    <form id="uploadForm" action="index.php" method="post" enctype="multipart/form-data" onsubmit= "return uploadFile()">
        <label for="file">Choose a file to upload:</label>
        <input type="file" id="file" name="file" required>
        <input type="hidden" name="upload" value="1"> <!-- Hidden field for form submission check -->

         <button type="submit">Upload</button>

        </form>
</div>

     <?php

        // Display a dropdown menu of user's files for selection
        $username = $_SESSION['username'];
        $db = new mysqli('localhost', 'root', 'morganclapsaddle', 'project');

        if ($db->connect_error) {
            die("Connection failed: " . $db->connect_error);
        }
        $username = $_SESSION['username'];
        $id = $_SESSION['id'];


        $querySelect = "SELECT files FROM users WHERE username = ?";
        $stmtSelect = $db->prepare($querySelect);
        $stmtSelect->bind_param("s", $username);

        $stmtSelect->execute();
        $stmtSelect->execute();
        $stmtSelect->execute();
        $stmtSelect->bind_result($files);
        $stmtSelect->fetch();
        $stmtSelect->close();
        $db->close();

        $fileArray = explode(",", $files);


        // Ensures the file paths include the correct directory prefix
        $fullFileArray = array_map(function ($file) {
                return '' . trim($file);

        }, $fileArray);

     if (isset($_GET["delete"])) {
        $deletedFile = "uploads/" . trim($_GET["delete"]);
        $deletedFile = "uploads/" . trim($_GET["delete"]);
        $deletedFile = "uploads/" . trim($_GET["delete"]);


        if (file_exists($deletedFile)) {
                unlink($deletedFile);

                }

        // Remove the file path from the database
                $username = $_SESSION['username'];

                $id = (int)$_SESSION['id'];
                $db = new mysqli('localhost', 'root', 'morganclapsaddle', 'project');

                }f ($db->connect_error) {

                $queryDelete = "UPDATE users SET files = REPLACE(files, ?, '') WHERE username = ?";
                $stmtDelete = $db->prepare($queryDelete);
                $stmtDelete->bind_param("ss", $deletedFile, $username);

                // Log the SQL query and parameters
                echo "SQL Query: " . $queryDelete . "<br>";
                echo "Parameters: " . $deletedFile . ", " . $username . "<br>";



                $stmtDelete->execute();


                $stmtDelete->close();
                echo "<script>document.location='index.php';</script>"; // Refresh the page to update the displayed list




    }

        $db = new mysqli('localhost', 'root', 'morganclapsaddle', 'project');
        $query = "SELECT id FROM users WHERE username = ?";
        $query = "SELECT id FROM users WHERE username = ?";
        $query = "SELECT id FROM users WHERE username = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($id);
        $stmt->fetch();
        $stmt->close();
        $_SESSION['id'] = $id;

        if ($id == 1) {

                $querySearch = "SELECT username, files FROM users";
                $stmtSearch = $db->prepare($querySearch);
                $stmtSearch->execute();
                $stmtSearch->bind_result($username, $files);



                while ($stmtSearch->fetch()) {
                        $fileArray = explode(",", $files);

                        echo "<div class='file-container'>";

                        foreach ($fileArray as $item) {


                                if (strlen($item) > 1){

                                        $fileName = basename($item);
                                        echo "<div class='filethumb'>";
                                        echo "<a href='" . $item . "' target='_blank'>";
                                        echo "<i class='fa fa-file' style='font-size: 70px;'></i>";
                                        echo "<div style='color: red; margin-top: 5px; margin-bottom: 20px; font-size: 15px;'>";
                                        echo "</div>";
                                }
                        }
                }


                $last_upload = new DateTime('now', new DateTimeZone('America/New_York'));
                $last_upload_formatted = $last_upload->format('Y-m-d H:i:s');




                $update_query = "UPDATE users SET last_upload = ? WHERE username = ?";
                $stmt->execute();are($update_query);
                $stmt->close();
                $db->close();



                $stmtSearch->close();
        }else{
                echo "<div class='file-container'>";
                foreach ($fullFileArray as $item) {

                        if (strlen($item) > 1){

                                $fileName = basename($item);

                                echo "<div class='filethumb'>";
                                echo "<a href='" . $item . "' target='_blank'>";
                                echo "<i class='fa fa-file' style='font-size: 70px;'></i>";
                        echo "<div class='delete-btn'><a href='?filestorage&delete=" . urlencode($fileName) . "'><i class='fa fa-trash'></i> Delete</a></div>";
                                echo "</div>";





                        }
                }


        echo "</div>"; // Close the container for file entries


                $last_upload = new DateTime('now', new DateTimeZone('America/New_York'));
                $last_upload_formatted = $last_upload->format('Y-m-d H:i:s');

                $update_time = "UPDATE users SET last_upload = ? WHERE username = ?";
                $stmt = $db->prepare($update_time);
                $stmt->bind_param('ss', $last_upload_formatted, $username);
                $stmt->execute();
                $stmt->close();
                $db->close();



        }

        ?>


<div class="container" id="fileSearchForm">



</div>

<script>
    function uploadFile() {
        
        var fileInput = document.getElementById('file');

        // Check if a file is chosen
        if (fileInput.files.length === 0) {
            // No file chosen, perform search instead of upload
            return true; // Allow form submission
       }
        alert('File uploaded successfully!');
        return true; // Allow form submission
    }
</script>
</body>
</html>
