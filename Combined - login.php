<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
  <title>Registration system PHP and MySQL</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body style="background-color:#33475b" >

<div class="title">
        <h2>F4U: Files 4 You</h2>
</div>

  <div class="header">
        <h2>Login</h2>
  </div>

  <form method="post" action="login.php">
        <?php include('errors.php'); ?>
        <div class="input-group">
                <label>Username</label>
                <input type="text" name="username" >
        </div>
        <div class="input-group">
                <label>Password</label>
                <input type="password" name="password">
        </div>
        <div class="input-group">
                <button type="submit" class="btn" name="login_user">Login</button>
        </div>
        <p>
                Not yet a member? <a href="register.php">Sign up</a>
        </p>
        <p></p>
        <p>
                Project information page <a href="projectinfo.php" > project information </a>
        </p>
  </form>
</body>
</html>
