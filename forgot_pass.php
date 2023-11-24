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
    <link rel="stylesheet" href="./css/forgot_pass.css" />
    <link rel="stylesheet" href="./css/main.css" />
    <link rel="stylesheet" href="dist/css/bootstrap.css" />
    <title>KLD - OAS | Forgot Password</title>
  </head>
  <body class="body overflow-auto">
    <div class="container mt-5">
      <div class="login-box">
        <div class="login-container">
          <div class="back-box">
            <a href="login_student">
              <img src="images/back-icon.svg" alt="back to homepage" />
            </a>
          </div>
          <div class="logo-box">
              <img
                src="images/KLDLogo.png"
                alt="KLDLogo"
                class="img-fluid logo-img"
                style="width: 150px; height: 150px"
                id="logo"
              />
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
