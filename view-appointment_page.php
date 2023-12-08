<?php
include __DIR__ . '/php/view_appointment_page_form.php';
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="images/KLDLogo.svg" type="image/x-icon" />
    <link rel="stylesheet" href="./css/view-appointment_page.css" />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
      crossorigin="anonymous"
    />
    <title>KLD - OAS | View Appointment</title>
  </head>
  <body class="body">
    <div class="container">
      <header class="head">
        <div class="back">
          <a href="view_appointment">
            <img src="images/back-icon.svg" alt="back to view-appointment" />
          </a>
        </div>
        <div class="logo">
          <img
            src="images/KLDLogo.png"
            alt="KLDLogo"
            class="img-fluid logo-img"
            style="width: 150px; height: 150px"
            id="logo"
          />
        </div>
      </header>
      <main class="slip">
        <p class="slip-header fs-1 fw-bolder text-center">My Appointment</p>
        <div class="info-box">
          <div class="personal-box box table-responsive">
            <table class="personal-details details">
              <tr>
                <th colspan="2">PERSONAL INFORMATION</th>
              </tr>
              <tr>
                <td class="info-identifier">Email Address</td>
                <td class="user-details"><?php echo $user['email']?></td>
              </tr>
              <tr>
                <td class="info-identifier">Full Name</td>
                <td class="user-details" id="js-fullname"></td>
              </tr>
              <tr>
                <td class="info-identifier">Contact Number</td>
                <td class="user-details"><?php echo $user['phone_number']?></td>
              </tr>
              <?php if(isset($user['kld_id'])){ echo '
              <tr>
                <td class="info-identifier">Student ID</td>
                <td class="user-details">' . $user['kld_id'] . '</td>
              </tr>';
              } elseif(isset($user['guest_id'])){ echo '
              <tr>
                <td class="info-identifier">Type of ID</td>
                <td class="user-details">' . $auth_name . '</td>
              </tr>
              <tr>
                <td class="info-identifier">Identification No.</td>
                <td class="user-details">' . $appointment['auth_identification'] . '</td>
              </tr>';
              }?>
            </table>
          </div>
          <div class="appointment-box box table-responsive">
            <table class="appointment-details details">
              <tr>
                <th colspan="2">APPOINTMENT INFORMATION</th>
              </tr>
              <tr>
                <td class="info-identifier">Control Number</td>
                <td class="user-details"><?php echo $appointment['control_number']?></td>
              </tr>
              <tr>
                <td class="info-identifier">Building</td>
                <td class="user-details"><?php echo $appointment['appointment_location']?></td>
              </tr>
              <tr>
                <td class="info-identifier">Appointment Type</td>
                <td class="user-details"><?php echo $type_name[0]?></td>
              </tr>
              <?php for($i = 0; $i < count($appointment['typeDoc_relationship_id']); $i++){ 
              if($type_id[$i] == 'DOCREQ'){ echo '
              <tr>
                <td class="info-identifier">Document Requested</td>
                <td class="user-details">' . $doc_name[$i] . '</td>
              </tr>';}
              }?>
              <tr>
                <td class="info-identifier">Date</td>
                <td class="user-details" id="js-date"></td>
              </tr>
              <tr>
                <td class="info-identifier">Time</td>
                <td class="user-details" id="js-time"></td>
              </tr>
            </table>
            <form method="post">
              <div class="btn-box">
                <input
                type="submit"
                class="btn-appointment fw-semibold"
                id="reschedule"
                value="Reschedule Appointment"
                name="reschedule_button"
                />
                <button
                  type="button"
                  class="btn-appointment fw-semibold"
                  data-bs-toggle="modal"
                  data-bs-target="#cancelModal"
                >
                  Cancel Appointment
                </button>
              </div>
            </form>
          </div>
        </div>
      </main>
    </div>

    <div class="modal fade" tabindex="-1" id="cancelModal">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title fw-bold">Cancel Appointment</h5>
          </div>
          <div class="modal-body fw-light">
            <p>Do you really want to cancel this appointment?</p>
          </div>
          <div class="modal-footer">
            <form method="post">
              <input
              type="submit"
              class="btn-home fw-semibold"
              id="home"
              value="Yes"
              name="home_button"
              />
              <button
                type="button"
                class="btn-back fw-semibold"
                data-bs-dismiss="modal"
              >
                No
              </button>
            </form>
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
    <script>
      $(document).ready(function () {
        document.querySelector('#js-fullname').textContent = buildName(<?php echo "'" . $user['firstname'] . "', '" . $user['middlename'] . "', '" . $user['surname'] . "'"?>);
        document.querySelector('#js-date').textContent = grabDate(<?php echo "'" . $appointment['appointment_datetime'] . "'"?>);
        document.querySelector('#js-time').textContent = convertTo12hr(grabTime(<?php echo "'" . $appointment['appointment_datetime'] . "'"?>));
      });
      function convertTo12hr(time24hr) {
        var [hours, minutes, seconds] = time24hr.split(':');
        hours = parseInt(hours, 10);
        minutes = parseInt(minutes, 10);
        
        var meridiem = hours >= 12 ? 'PM' : 'AM';
        hours = (hours % 12 || 12).toString().padStart(2, '0');
        minutes = minutes < 10 ? '0' + minutes : minutes;
        
        var time12hr = hours + ':' + minutes + ' ' + meridiem;

        return time12hr;
      }
      function buildName(firstname, middlename, surname) {
        // Construct the full name without middle initial
        let fullName = `${firstname} ${surname}`;

        // Include middle initial if middlename exists
        if (middlename && middlename.length > 0) {
          const middleInitial = middlename.charAt(0);
          fullName = `${firstname} ${middleInitial}. ${surname}`;
        }

        return fullName;
      }
      function grabDate(input) {
        const datePart = input.split(' ')[0];
        return datePart;
      }
      function grabTime(input) {
        const timePart = input.split(' ')[1];
        return timePart;
      }
    </script>
  </body>
</html>
