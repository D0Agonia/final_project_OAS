<?php
include __DIR__ . '/php/login_guest_form.php';
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="images/KLDLogo.svg" type="image/x-icon" />
    <link rel="stylesheet" href="login_guest.css" />
    <link rel="stylesheet" href="./css/main.css" />
    <link rel="stylesheet" href="dist/css/bootstrap.css" />
    <title>KLD - OAS | Guest Login</title>
  </head>
  <body class="body">
    <!-- TODO: ADJUST THE LAYOUT AND RESPONSIVENESS -->
    <div class="container">
      <div class="login-box">
        <div class="login-container overflow-auto">
          <div class="back-box">
            <a href="index.html">
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
          <h1 class="h1 fw-bolder">Guest Login</h1>
          <img
            src="images/Account-amico.svg"
            alt="Login Icon"
            class="img-fluid login-icon"
            style="width: 200px; height: 200px"
          />
          <form method="post" class="form">
            <?php 
            if($_SESSION['showError'] == true){
              echo '<p class="text-center fw-bold text-danger">' . $error_display . '</p>';}
            elseif($_SESSION['showSuccess'] == true){
              echo '<p class="text-center fw-bold text-success">' . $success_display . '</p>';}
            ?>
            <div class="form-floating txtGuest-email">
              <input
                type="email"
                class="form-control"
                id="guest-email"
                placeholder="Enter your Email"
                name="email"
              />
              <label for="email" class="form-label">Email Address</label>
            </div>
            <div class="txtGuest-otp input-group">
              <input
                type="text"
                class="form-control"
                id="otp-guest"
                placeholder="Enter your otp"
                name="otp"
              />
              <input
                type="submit" 
                class="btn-send" 
                id="button-addon2"
                value="Send"
                name="otp_send"
              />
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
