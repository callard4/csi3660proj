<?php
  session_start();

  if (!isset($_SESSION['username'])) {
        $_SESSION['msg'] = "You must log in first";
        header('location: login.php');
  }
  if (isset($_GET['logout'])) {
        session_destroy();
        unset($_SESSION['username']);
        header("location: login.php");
  }
?>
<!DOCTYPE html>
<html>
<head>
        <div class="title">
         <h2>F4U: Files 4 You</h2>
        </div>
        <title>Home</title>
        <link rel="stylesheet" type="text/css" href="style.css">

</head>
<body style="background-color:#33475b">


<div class="header">
        <h2>Home Page</h2>
</div>



<div class="content">
        <!-- notification message -->
        <?php if (isset($_SESSION['success'])) : ?>
      <div class="error success" >
        <h3>
          <?php
                echo $_SESSION['success'];
                unset($_SESSION['success']);
          ?>
        </h3>
      </div>
        <?php endif ?>

    <!-- logged in user information -->
    <?php  if (isset($_SESSION['username'])) : ?>
        <p>Welcome <strong><?php echo $_SESSION['username']; ?></strong></p>
        <p> <a href="index.php?logout='1'" style="color: red;">logout</a> </p>
    <?php endif ?>
</div>

<div class="container" id="fileUploadForm">
  <h2> </h2>
  <form id="uploadForm" enctype="multipart/form-data" onsubmit="return uploadFile()">
    <label for="file">Choose a file to upload:</label>
    <input type="file" id="file" name="file" required>
    <button type="submit">Upload</button>
  </form>
</div>

<script>
 function uploadFile() {
    // Your file upload logic here (not implemented in this example)
    alert('File uploaded successfully!');
    return false; // Prevent form submission
  }
</script>


</body>
</html>
                                                                                                    133,7         Bot
