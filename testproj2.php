<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login/Register and File Upload</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .container {
      background-color: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      width: 300px;
      text-align: center;
    }

    .form-group {
      margin-bottom: 15px;
    }

    .form-group label {
      display: block;
      font-weight: bold;
      margin-bottom: 5px;
    }

    .form-group input {
      width: 100%;
      padding: 8px;
      box-sizing: border-box;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    .form-group button {
      width: 100%;
      padding: 10px;
      background-color: #007bff;
      color: #fff;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    #fileUploadForm {
      display: none;
    }

    #fileUploadForm input[type="file"] {
      margin-top: 15px;
    }
  </style>
</head>
<body>

<div class="container" id="loginContainer">
  <h2>Login</h2>
  <form id="loginForm" onsubmit="return login()">
    <div class="form-group">
      <label for="usernameLogin">Username:</label>
      <input type="text" id="usernameLogin" name="usernameLogin" required>
    </div>

    <div class="form-group">
      <label for="passwordLogin">Password:</label>
      <input type="password" id="passwordLogin" name="passwordLogin" required>
    </div>

    <div class="form-group">
      <button type="submit">Login</button>
    </div>
  </form>

  <p>Don't have an account? <a href="#" onclick="showRegister()">Register</a></p>
</div>

<div class="container" id="registerContainer" style="display: none;">
  <h2>Register</h2>
  <form id="registerForm" onsubmit="return register()">
    <div class="form-group">
      <label for="usernameRegister">Username:</label>
      <input type="text" id="usernameRegister" name="usernameRegister" required>
    </div>

    <div class="form-group">
      <label for="passwordRegister">Password:</label>
      <input type="password" id="passwordRegister" name="passwordRegister" required>
    </div>

    <div class="form-group">
      <button type="submit">Register</button>
    </div>
  </form>

  <p>Already have an account? <a href="#" onclick="showLogin()">Login</a></p>
</div>

<div class="container" id="fileUploadForm">
  <h2>Welcome, <span id="loggedInUser"></span>!</h2>
  <form id="uploadForm" enctype="multipart/form-data" onsubmit="return uploadFile()">
    <label for="file">Choose a file to upload:</label>
    <input type="file" id="file" name="file" required>
    <button type="submit">Upload</button>
  </form>
</div>

<script>
  function showRegister() {
    document.getElementById('loginContainer').style.display = 'none';
    document.getElementById('registerContainer').style.display = 'block';
  }

  function showLogin() {
    document.getElementById('loginContainer').style.display = 'block';
    document.getElementById('registerContainer').style.display = 'none';
  }

  function login() {
    // Your login logic here (not implemented in this example)
    var username = document.getElementById('usernameLogin').value;
    document.getElementById('loggedInUser').innerText = username;
    showFileUploadForm();
    return false; // Prevent form submission
  }

  function register() {
    // Your registration logic here (not implemented in this example)
    var username = document.getElementById('usernameRegister').value;
    document.getElementById('loggedInUser').innerText = username;
    showFileUploadForm();
    return false; // Prevent form submission
  }

  function showFileUploadForm() {
    document.getElementById('loginContainer').style.display = 'none';
    document.getElementById('registerContainer').style.display = 'none';
    document.getElementById('fileUploadForm').style.display = 'block';
  }

  function uploadFile() {
    // Your file upload logic here (not implemented in this example)
    alert('File uploaded successfully!');
    return false; // Prevent form submission
  }
</script>

</body>
</html>


