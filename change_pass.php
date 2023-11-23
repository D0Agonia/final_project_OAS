<?php
include __DIR__ . '/php/change_pass_form.php';
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="images/KLDLogo.svg" type="image/x-icon" />
    <link rel="stylesheet" href="./css/change_pass.css" />
    <link rel="stylesheet" href="./css/main.css" />
    <link rel="stylesheet" href="dist/css/bootstrap.css" />
    <title>KLD - OAS | Change Password</title>
  </head>
  <body class="body">
    <div class="container">
      <div class="login-box">
        <div class="login-container overflow-auto">
          <div class="back-box">
            <a href="forgot_pass">
              <img src="images/back-icon.svg" alt="back to forgot password" />
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
                id="newPass"
                placeholder="Enter Student ID"
                name="change_pass"
              />
              <label for="change_pass" class="form-label">New Password</label>
            </div>
            <div class="form-floating confirm-password">
              <input
                type="password"
                class="form-control"
                id="confirmPass"
                placeholder="Enter your otp"
                name="confirm-pass"
              />
              <label for="confirm-pass" class="form-label"
                >Confirm New Password</label
              >
            </div>
            <div class="show-pass">
              <input type="checkbox" onclick="myFunction()"> Show Password
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

    <script>
      let newPass = document.getElementById('newPass');
      let confirmPass = document.getElementById('confirmPass');

      function myFunction() {
        if(newPass.type === "password" || confirmPass.type === "password"){
          confirmPass.type = "text";
          newPass.type = "text";
        }else{
          confirmPass.type = "password";
          newPass.type = "password";
        }
      }
    </script>
  </body>
</html>
