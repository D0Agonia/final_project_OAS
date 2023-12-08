<?php
include __DIR__ . '/php/view_appointment_form.php';
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="images/KLDLogo.svg" type="image/x-icon" />
    <link rel="stylesheet" href="./css/view_appointment.css" />
    <link rel="stylesheet" href="./css/main.css" />
    <link rel="stylesheet" href="dist/css/bootstrap.css" />
    <title>KLD - OAS | View Appointment Key</title>
  </head>
  <body class="body overflow-auto">
    <div class="container mt-5">
      <div class="login-box">
        <div class="login-container">
          <div class="back-box">
            <a href="index?i=1">
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
            View <br />
            Appointment
          </h1>
          <img
            src="images/Mobile login-amico.svg"
            alt="Login Icon"
            class="img-fluid login-icon"
            style="width: 200px; height: 200px"
          />
          <form method="post" class="form">
            <?php if($show_error == true){
              echo '<p class="text-center fw-bold text-danger">' . $error_message . '</p>';
            }?>
            <div class="form-floating control-VA">
              <input
                type="text"
                class="form-control"
                id="control-no"
                placeholder="Enter Control Number"
                name="control-no"
              />
              <label for="control-no" class="form-label">Control no.</label>
            </div>
            <div class="btn-submit-box d-flex justify-content-center">
              <input
                type="submit"
                value="Proceed"
                name="view_appointment"
                class="btn-submit fw-semibold"
              >
            </div>
          </form>
        </div>
      </div>
    </div>
  </body>
</html>
