<?php
include __DIR__ . '/php/logout_form.php';
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="images/KLDLogo.svg" type="image/x-icon" />
    <link rel="stylesheet" href="./css/logout.css" />
    <link rel="stylesheet" href="./css/main.css" />
    <link rel="stylesheet" href="dist/css/bootstrap.css" />
    <title>Logout</title>
  </head>

  <body class="body">
    <div class="container mb-3">
      <section class="parent-logout">
        <div class="logout-box">
          <div class="img-box w-75">
            <img
              src="images/Curious-amico.svg"
              alt="Logout"
              class="mt-5 image-fluid"
            />
          </div>
          <div class="logout w-75 mt-5 mb-5">
            <h1 class="title fs-1">Logging Out</h1>
            <p class="title-desc fs-6">Are you sure you want to log out?</p>
            <form class="btn-form" method="post">
              <div class="btn-box">
                <input 
                  type="submit"
                  class="btn-home fw-semibold"
                  id="logout_button"
                  value="Yes"
                  name="logout_button"
                />
              </div>
              <div class="btn-box">
                <a href="index-student-guest" class="btn-back fw-semibold" style="display: block;">No</a>
              </div>
            </form>
          </div>
        </div>
      </section>
    </div>
  </body>
</html>
