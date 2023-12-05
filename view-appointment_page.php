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
                <td class="user-details"><script>buildName(<?php echo $user['firstname'] . ", " . $user['middlename'] . ", " . $user['surname']?>);</script></td>
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
                <td class="user-details">' . $displayAuthName . '</td>
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
                <td class="user-details"><?php echo $appointment['appointment_location]']?></td>
              </tr>
              <tr>
                <td class="info-identifier">Appointment Type</td>
                <td class="user-details"><?php echo $displayAppointmentType?></td>
              </tr>
              <?php for($i = 0; $i < count($appointment['typeDoc_relationship_id']); $i++){ 
              for($j = 0; $j < count($docNames); $i++){
                if($j == $appointment['typeDoc_relationship_id'] && $appointment['typeDoc_relationship_id'] != 0){
                  $displayDocumentRequested = $docNames[$j]; echo '
                  <tr>
                    <td class="info-identifier">Document Requested</td>
                    <td class="user-details"></td>
                  </tr>';
                  break;
                }
              }
              }?>
              <tr>
                <td class="info-identifier">Date</td>
                <td class="user-details"><script>grabDate(<?php echo $appointment['appointment_datetime']?>);</script></td>
              </tr>
              <tr>
                <td class="info-identifier">Time</td>
                <td class="user-details"><script>convertTo12hr(grabDate(<?php echo $appointment['appointment_datetime']?>));</script></td>
              </tr>
            </table>
            <form action="#">
              <div class="btn-box">
                <a
                  href="reschedule-page"
                  type="button"
                  class="btn-appointment fw-semibold"
                >
                  Reschedule Appointment
                </a>
                <button
                  type="submit"
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
            <a href="index?i=1" class="btn-home fw-semibold">Yes</a>
            <button
              type="button"
              class="btn-back fw-semibold"
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
    <script>
      function convertTo12hr(time24hr) {
        var [hours, minutes] = time24hr.split(':');
        hours = parseInt(hours, 10);
        minutes = parseInt(minutes, 10);
        var meridiem = hours >= 12 ? 'PM' : 'AM';
        hours = (hours % 12 || 12).toString().padStart(2, '0');
        minutes = minutes < 10 ? '0' + minutes : minutes;
        var time12hr = hours + ':' + minutes + ' ' + meridiem;

        return time12hr;
      }
      function convertTo24hr(time12hr) {
        var [time, meridiem] = time12hr.split(' ');
        var [hours, minutes] = time.split(':');
        hours = parseInt(hours, 10);

        if (meridiem === 'PM' && hours < 12) {
          hours += 12;
        } else if (meridiem === 'AM' && hours === 12) {
          hours = 0;
        }

        hours = hours.toString().padStart(2, '0');
        minutes = parseInt(minutes, 10);

        return hours + ':' + (minutes < 10 ? '0' + minutes : minutes);
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
