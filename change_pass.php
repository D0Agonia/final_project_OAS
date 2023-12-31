<?php
include __DIR__ . '/php/change_pass_form.php';
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="images/KLDLogo.svg" type="image/x-icon" />
    <link rel="stylesheet" href="change_pass.css" />
    <link rel="stylesheet" href="./css/main.css" />
    <link rel="stylesheet" href="dist/css/bootstrap.css" />
    <title>KLD - OAS | Change Password</title>
  </head>
  <body class="body">
    <div class="container">
      <div class="login-box">
        <div class="login-container overflow-auto">
          <div class="back-box">
            <a href="/forgot_pass.html">
              <img src="images/back-icon.svg" alt="back to forgot password" />
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
            Change <br />
            Password
          </h1>
          <img
            src="images/Private data-amico.svg"
            alt="Change Pass Icon"
            class="img-fluid login-icon"
            style="width: 200px; height: 200px"
          />
          <form method="post" class="form">
            <?php if($show_error == true){
              echo '<p class="text-center fw-bold text-danger">' . $error_display . '</p>';
            }?>
            <div class="form-floating new-password">
              <input
                type="password"
                class="form-control"
                id="change-password"
                placeholder="Enter Student ID"
                name="change_pass"
              />
              <label for="change_pass" class="form-label">New Password</label>
            </div>
            <div class="form-floating confirm-password">
              <input
                type="password"
                class="form-control"
                id="confirm-pass"
                placeholder="Enter your otp"
                name="confirm-pass"
              />
              <label for="confirm-pass" class="form-label"
                >Confirm New Password</label
              >
            </div>
            <div class="btn-submit-box d-flex justify-content-center">
              <input
                type="submit"
                class="btn-submit fw-semibold"
                id="submit"
                value="Confirm"
                name="submit_button"
              />
            </div>
          </form>
        </div>
      </div>
    </div>
  </body>
</html>
