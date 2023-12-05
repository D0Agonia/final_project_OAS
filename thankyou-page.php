<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="images/KLDLogo.svg" type="image/x-icon" />
    <link rel="stylesheet" href="./css/logout.css" />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
      crossorigin="anonymous"
    />
    <title>KLD - OAS | Thank You</title>
  </head>
  <body class="body">
    <div class="container mb-5">
      <section class="parent-logout">
        <div class="logout-box">
          <div class="img-box w-75">
            <img
              src="images/Working-amico.svg"
              alt="work"
              class="image-fluid"
            />
          </div>
          <div class="logout w-75 mb-5">
            <h1 class="title fs-1">Thank You, <span>Human</span></h1>
            <p class="title-desc fs-6 mb-5">
              Your appointment has been confirmed.
            </p>
            <p class="title-desc fs-6 fw-semibold">
              Control Number: <span><?php echo isset($_GET['control_number']) ? $_GET['control_number'] : '';?></span>
            </p>
            <p class="title-desc fs-6 w-75 fw-semibold">
              NOTE: please remember your control number, you may use it to view
              and update your appointment details
            </p>
            <p class="title-desc fs-6">
              See you in Kolehiyo ng Lungsod ng Dasmariñas!
            </p>
            <button
              type="submit"
              class="btn-home fw-semibold"
              data-bs-toggle="modal"
              data-bs-target="#confirmModal"
            >
              Proceed
            </button>
          </div>
        </div>
      </section>
    </div>

    <div class="modal fade" tabindex="-1" id="confirmModal">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title fw-bold">Confirm Notice</h5>
          </div>
          <div class="modal-body fw-light">
            <p>Did you take note of your control number?</p>
            <p>Are you sure you want to proceed?</p>
          </div>
          <div class="modal-footer">
            <a href="index?i=1" class="btn-home2 fw-semibold">Yes</a>
            <button
              type="button"
              class="btn-back2 fw-semibold"
              data-bs-dismiss="modal"
            >
              No
            </button>
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
    <script></script>
  </body>
</html>
