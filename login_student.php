<?php
include __DIR__ . '/php/login_student_form.php';
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="images/KLDLogo.svg" type="image/x-icon" />
    <link rel="stylesheet" href="login_student.css" />
    <link rel="stylesheet" href="./css/main.css" />
    <link rel="stylesheet" href="dist/css/bootstrap.css" />
    <title>KLD - OAS | Student Login</title>
  </head>
  <body class="body">
    <div class="container overflow-auto">
      <div class="login-box">
        <div class="login-container">
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
          <h1 class="h1 fw-bolder">Student Login</h1>
          <img
            src="images/Login-amico.svg"
            alt="Login Icon"
            class="img-fluid login-icon"
            style="width: 200px; height: 200px"
          />
          <form method="post" class="form">
            <?php if($show_error == true){
              echo '<p class="text-center fw-bold text-danger">' . $error_display . '</p>';
            }?>
            <div class="form-floating txtStudent-id">
              <input
                type="text"
                class="form-control"
                id="student-id"
                placeholder="Enter Student ID"
                name="student_id"
                value="<?php echo $studentID_value_text;?>"
              />
              <label for="student-id" class="form-label">Student ID</label>
            </div>
            <div class="form-floating txtStudent-password">
              <input
                type="password"
                class="form-control"
                id="pass"
                placeholder="Enter password"
                name="password"
              />
              <label for="pass" class="form-label">Password</label>
              <img src="images/eyes-closed.svg" alt="eye-close" id="eye" style="width: 20px; height: 20px;">
            </div>
            <div class="forgot-pass">
              <a href="forgot_pass.php">Forgot Password?</a>
            </div>
            <div class="btn-submit-box d-flex justify-content-center">
              <input
                type="submit"
                class="btn-submit fw-semibold"
                id="submit"
                value="Login"
                name="submit_button"
              />
            </div>
          </form>
        </div>
      </div>
    </div>

    <script>
      let eye = document.getElementById('eye');
      let pass = document.getElementById('pass');

      eye.onclick = function(){
        if(pass.type === "password"){
          pass.type = "text";
          eye.src = "images/eye-open.svg";
        }else{
          pass.type = "password";
          eye.src = "images/eyes-closed.svg";
        }
      }
    </script>
  </body>
</html>