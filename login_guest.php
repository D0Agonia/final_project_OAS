<?php
include __DIR__ . '/php/login_guest_form.php';
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="images/KLDLogo.svg" type="image/x-icon" />
    <link rel="stylesheet" href="./css/login_guest.css" />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
      crossorigin="anonymous"
    />
    <title>KLD - OAS | Guest Login</title>
  </head>
  <body class="body overflow-auto">
    <!-- TODO: ADJUST THE LAYOUT AND RESPONSIVENESS -->
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
          <h1 class="h1 fw-bolder">Guest Login</h1>
          <img
            src="images/Account-amico.svg"
            alt="Login Icon"
            class="img-fluid login-icon"
            style="width: 200px; height: 200px"
          />
          <form method="post" class="form">
            <p class="text-center fw-bold text-danger" id="text-response"></p>
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
                type="button" 
                class="btn-send otp_send" 
                id="button-addon2"
                value="Send"
                name="otp_send"
              />
            </div>
            <div class="btn-submit-box d-flex justify-content-center">
              <input
                type="button"
                class="btn-submit fw-semibold otp_submit"
                id="submit"
                value="Proceed"
                name="submit_button"
              />
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="modal fade" tabindex="-1" id="confirmModal">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title fw-bold">Successfully Sent OTP!</h5>
            <button class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body fw-light">
            <p>Please check your spam folder in your email account, if the otp is not in your inbox.</p>
          </div>
          <div class="modal-footer">
          </div>
        </div>
      </div>
    </div>

    <script
      src="https://code.jquery.com/jquery-3.7.1.min.js"
      integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
      integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
      integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
      crossorigin="anonymous"
    ></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
      var session = <?php echo json_encode($_SESSION); ?>

      $(document).ready(function () {
        $(".otp_send").click(function () {
          event.preventDefault();
          let data = {};
          data.email = document.querySelector('#guest-email').value;
          data.session = session;
          data = JSON.stringify(data);

          $.ajax({
            url: "phpAction/send_otp.php",
            method: "POST",
            data: {jsonData: data},
            dataType: "json",
            beforeSend: function(xhr) {
              xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            },
            success: function(response){
              if(response.processed == true){
                document.querySelector('#text-response').textContent = null;
                session = response.session;
                $('#confirmModal').modal('show');
              }
              else{
                document.querySelector('#text-response').textContent = response.message;
              }
            },
            error: function(error){
              console.error(error);
            }
          });
        });
        $(".otp_submit").click(function () {
          event.preventDefault();
          let data = {};
          data.email = document.querySelector('#guest-email').value;
          data.otp = document.querySelector('#otp-guest').value;
          data.session = session;
          data = JSON.stringify(data);

          $.ajax({
            url: "phpAction/verify_otp.php",
            method: "POST",
            data: {jsonData: data},
            dataType: "json",
            beforeSend: function(xhr) {
              xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            },
            success: function(response){
              if(response.processed == true){
                document.querySelector('#text-response').textContent = null;
                window.location.href = window.location.origin + "/index-student-guest";
              }
              else{
                document.querySelector('#text-response').textContent = response.message;
              }
            },
            error: function(error){
              console.error(error);
            }
          });
        });
      });
    </script>
  </body>
</html>
