<?php

date_default_timezone_set('America/New_York');
session_start();

// initializing variables
$username = "";
$email    = "";
$errors = array();

// connect to the database
$db = mysqli_connect('localhost', 'root', 'morganclapsaddle', 'project');

// REGISTER USER
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);


  if (empty($username)) { array_push($errors, "Username is required"); }
  if (empty($email)) { array_push($errors, "Email is required"); }
  if (empty($password_1)) { array_push($errors, "Password is required"); }
  if ($password_1 != $password_2) {
        array_push($errors, "The two passwords do not match");
  }

  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);

  if ($user) { // if user exists
    if ($user['username'] === $username) {
      array_push($errors, "Username already exists");
    }

    if ($user['email'] === $email) {
      array_push($errors, "email already exists");
    }
  }

  // register user if there are no errors in the form
  if (count($errors) == 0) {

        $id = 0;
        $query = "INSERT INTO users (id, username, email, password) 
                          VALUES('$id', '$username', '$email', '$password_1')";
        mysqli_query($db, $query);
        $_SESSION['username'] = $username;
        $_SESSION['success'] = "You are now logged in";
        header('location: index.php');


        $queryGetID = "SELECT id FROM users WHERE username='$username' LIMIT 1";
        $result = mysqli_query($db, $queryGetID);
         $user = mysqli_fetch_assoc($result);

        if ($user) {
                $_SESSION['id'] = $user['id'];
        }

        $_SESSION['username'] = $username;
        $_SESSION['success'] = "You are now logged in";
        header('location: index.php');
  }
}
// LOGIN USER
if (isset($_POST['login_user'])) {
        $username = mysqli_real_escape_string($db, $_POST['username']);
        $password = mysqli_real_escape_string($db, $_POST['password']);

        if (empty($username)) {
                array_push($errors, "Username is required");
        }
        if (empty($password)) {
                array_push($errors, "Password is required");
        }

        if (count($errors) == 0) {

                $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
                $results = mysqli_query($db, $query);
                if (mysqli_num_rows($results) == 1) {
                        $_SESSION['username'] = $username;
                        $_SESSION['id'] = $users['id'];
                        $_SESSION['id'] = $id;
                        $_SESSION['success'] = "You are now logged in";
                        header('location: index.php');
                }else {
                        array_push($errors, "Wrong username/password combination");
                  }
        }
        $username = $_POST['username'];

        $login_time = new DateTime('now', new DateTimeZone('America/New_York'));
        $login_time_formatted = $login_time->format('Y-m-d H:i:s');


        $update_query = "UPDATE users SET last_login = ? WHERE username = ?";
        $stmt = $db->prepare($update_query);
        $stmt->bind_param('ss', $login_time_formatted, $username);
        $stmt->execute();
        $stmt->close();
        $db->close();

}

?>               
