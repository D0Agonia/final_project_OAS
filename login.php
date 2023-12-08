<?php
include __DIR__ . '/php/login_form.php';
?>

<!DOCTYPE html>
<html>
<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="log.css">
  <title> Admin </title>
</head>
<body>
  <div class="login-page">
    <div class="form">
      <div class="login-header">
        <p class="text-success fw-bold fs-1">LOGIN</p>
        <p>Please enter your credentials to login.</p>
      </div>
      <form method="post" class="login-form">
        <input type="text" placeholder="Username" name="admin_username"/>
        <input type="password" placeholder="Password" name="admin_password"/>
        <p class="text-center fw-bold fs-5 text-danger" hidden>Error Message</p>
        <input type="submit" class="button" id="login" value="Login" name="login_button"/> 
      </form>
    </div>
  </div>
</body>
</html>