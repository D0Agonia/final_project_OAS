<?php
$directory_path = __DIR__;
include __DIR__ . '/php/forgot_pass_form.php';
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="images/KLDLogo.svg" type="image/x-icon" />
    <link rel="stylesheet" href="forgot_pass.css" />
    <link rel="stylesheet" href="./css/main.css" />
    <link rel="stylesheet" href="dist/css/bootstrap.css" />
    <title>KLD - OAS | Forgot Password</title>
  </head>
  <body class="body">
    <div class="container">
      <div class="login-box">
        <div class="login-container overflow-auto">
          <div class="back-box">
            <a href="login_student.php">
              <img src="images/back-icon.svg" alt="back to homepage" />
            </a>
          </div>
          <div class="logo-box">
            <a href="/landing.html">
              <img
                src="images/KLDLogo.png"
                alt="KLDLogo"
                class="img-fluid logo-img"
                style="width: 150px; height: 150px"
                id="logo"
              />
            </a>
          </div>
          <h1 class="h1 fw-bolder">
            Forgot <br />
            Password
          </h1>
          <img
            src="images/Forgot password-amico.svg"
            alt="Login Icon"
            class="img-fluid login-icon"
            style="width: 200px; height: 200px"
          />
          <form method="post" class="form">
            <?php if($show_error == true){
              echo '<p class="text-center fw-bold text-danger">' . $error_display . '</p>';
            }?>
            <div class="form-floating txtFP-email">
              <input
                type="email"
                class="form-control"
                id="forgot-email"
                placeholder="Enter your Email"
                name="email"
              />
              <label for="email" class="form-label">Email Address</label>
            </div>
            <div class="btn-submit-box d-flex justify-content-center">
              <input
                type="submit"
                class="btn-submit fw-semibold"
                id="submit"
                value="Proceed"
                name="submit_button"
              />
            </div>
          </form>
        </div>
      </div>
    </div>
  </body>
</html>
