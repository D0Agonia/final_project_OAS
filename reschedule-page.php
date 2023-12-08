<?php
include __DIR__ . '/php/reschedule_page_form.php';
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="images/KLDLogo.svg" type="image/x-icon" />
    <link rel="stylesheet" href="calendar-02/calendar-02/css/style.css" />
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
    />
    <link rel="stylesheet" href="./css/reschedule-page.css" />
    <link rel="stylesheet" href="./css/main.css" />
    <link rel="stylesheet" href="dist/css/bootstrap.css" />
    <title>KLD - OAS | Reschedule Appointment</title>
  </head>
  <body class="body">
    <div class="container">
      <header class="head">
        <div class="back-box">
          <a href="view-appointment_page?control_number=<?php echo $_GET['control_number']?>">
            <img src="images/back-icon.svg" alt="back to homepage" />
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
      <section class="form-head">
        <div class="welcome-remarks">
          <p class="welcome fs-5">Control Number: <span><?php echo $control_number;?></span></p>
        </div>
      </section>
      <main class="form-details mb-lg-0">
        <section class="form-box">
          <form method="post">
            <div class="step step-2">
              <!-- STEP 2 OF FORM -->
              <p class="description-child fs-5">Reschedule your Appointment</p>
              <hr />
              <div class="form-parent-calendar">
                <div class="calendar-child">
                  <div class="elegant-calencar">
                    <div class="wrap-header d-flex align-items-center">
                      <p id="reset">reset</p>
                      <div id="header" class="p-0">
                        <div
                          class="pre-button d-flex align-items-center justify-content-center"
                        >
                          <i class="fa fa-chevron-left"></i>
                        </div>
                        <div class="head-info">
                          <div class="head-day"></div>
                          <div class="head-month"></div>
                        </div>
                        <div
                          class="next-button d-flex align-items-center justify-content-center"
                        >
                          <i class="fa fa-chevron-right"></i>
                        </div>
                      </div>
                    </div>
                    <div class="calendar-wrap">
                      <table id="calendar">
                        <thead>
                          <tr>
                            <th>Sun</th>
                            <th>Mon</th>
                            <th>Tue</th>
                            <th>Wed</th>
                            <th>Thu</th>
                            <th>Fri</th>
                            <th>Sat</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                          </tr>
                          <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                          </tr>
                          <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                          </tr>
                          <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                          </tr>
                          <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                          </tr>
                          <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <div class="time-child">
                  <div class="time time-1">
                    <input
                      type="button"
                      class="btn-time"
                      id="TMSLOT-01"
                      name="btn1"
                      value="08:00 AM"
                    />
                    <input
                      type="button"
                      class="btn-time"
                      id="TMSLOT-02"
                      name="btn1"
                      value="09:00 AM"
                    />
                    <input
                      type="button"
                      class="btn-time"
                      id="TMSLOT-03"
                      name="btn1"
                      value="10:00 AM"
                    />
                  </div>
                  <div class="time time-2">
                    <input
                      type="button"
                      class="btn-time"
                      id="TMSLOT-04"
                      name="btn1"
                      value="11:00 AM"
                    />
                    <input
                      type="button"
                      class="btn-time"
                      id="TMSLOT-05"
                      name="btn1"
                      value="12:00 PM"
                    />
                    <input
                      type="button"
                      class="btn-time"
                      id="TMSLOT-06"
                      name="btn1"
                      value="01:00 PM"
                    />
                  </div>
                  <div class="time time-3">
                    <input
                      type="button"
                      class="btn-time"
                      id="TMSLOT-07"
                      name="btn1"
                      value="02:00 PM"
                    />
                    <input
                      type="button"
                      class="btn-time"
                      id="TMSLOT-08"
                      name="btn1"
                      value="03:00 PM"
                    />
                    <input
                      type="button"
                      class="btn-time"
                      id="TMSLOT-09"
                      name="btn1"
                      value="04:00 PM"
                    />
                  </div>
                  <div class="time time-4">
                    <input
                      type="button"
                      class="btn-time"
                      id="TMSLOT-010"
                      name="btn1"
                      value="05:00 PM"
                    />
                  </div>
                </div>
              </div>
              <p 
                class="text-center fw-bold text-danger" 
                id="reschedule-error-message" 
                style="display: none; margin-top: 10px; margin-bottom: 0px">
              </p>
              <div class="btn-box">
                <button
                  type="button"
                  class="btn-next-back fw-semibold"
                  value="confirm"
                >
                  Confirm
                </button>
              </div>
            </div>
          </form>
        </section>
      </main>
    </div>

    <script src="/calendar-02/calendar-02/js/jquery.min.js"></script>
    <script src="/calendar-02/calendar-02/js/bootstrap.min.js"></script>
    <script src="/calendar-02/calendar-02/js/popper.js"></script>
    <script src="/calendar-02/calendar-02/js/dist/main.dev.js"></script>
    <script>
      const timeInputs = document.querySelectorAll('.btn-time');
      var calendarBlacklist = <?php echo json_encode(fetchAppointmentBlacklist());?>;
      var selectedTime;

      $(document).ready(function () {
        document.cookie = "selected_day=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";

        $(".btn-next-back").click(function () {
          event.preventDefault();
          const jsonData = fetchFormData();

          $.ajax({
            url: "phpAction/reschedule_date.php",
            method: "POST",
            data: {jsonData: jsonData},
            dataType: "json",
            beforeSend: function(xhr) {
              xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            },
            success: function(response){
              if(response.processed == true){
                document.getElementById('reschedule-error-message').style.display = 'none';
                window.location.href = window.location.origin + "/view-appointment_page?control_number=" + '<?php echo $_GET['control_number'];?>';
              }
              else{
                document.getElementById('reschedule-error-message').style.display = '';
                $("#reschedule-error-message").text(response.error_message);
              }
            },
            error: function(error){
              console.error(error);
            }
          });
        });
      });

      function fetchFormData(){
        const formData = {};

        if(selectedTime != null){
          formData.appointmentDate = calendarDate + " " + convertTo24hr(selectedTime);
        }
        else{
          formData.appointmentDate = calendarDate;
        }
        formData.controlNumber = <?php echo $control_number;?>;

        return JSON.stringify(formData);
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

      function formatDate(date) {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0'); // Months are zero-based
        const day = String(date.getDate()).padStart(2, '0');

        const formattedDate = `${year}-${month}-${day}`;

        return formattedDate;
      }

      function getCurrentDate() {
        const today = new Date();

        const year = today.getFullYear();
        const month = String(today.getMonth() + 1).padStart(2, '0'); // Months are zero-based
        const day = String(today.getDate()).padStart(2, '0');

        const formattedDate = `${year}-${month}-${day}`;

        return formattedDate;
      }

      function grabCalendarDate() {
        const cookieName = "selected_day";
        calendarDate = document.cookie
          .split("; ")
          .find((row) => row.startsWith(cookieName))
          ?.split("=")[1]
        ;
        if(calendarDate !== undefined){
          calendarDate = formatDate(new Date(calendarDate));
        }
        else{
          calendarDate = getCurrentDate();
        }
      }

      timeInputs.forEach((input) => {
        input.addEventListener('click', function() {
          if(!this.classList.contains('time-selected')) {
            // Input is selected
            timeInputs.forEach((input) => {input.classList.remove('time-selected')});
            input.classList.add('time-selected');
            selectedTime = this.value;
          } else {
            // Input is deselected
            input.classList.remove('time-selected');
            selectedTime = null;
          }
        });
      });

      function updateCalendar() {
        grabCalendarDate();

        timeInputs.forEach(function(input) {
          input.disabled = false;
          input.classList.remove('time-selected');
          input.classList.remove('item-disabled');
        });

        for(let i = 0; i < calendarBlacklist.length; i++){
          let blacklistDate = grabDate(calendarBlacklist[i]);
          let blacklistTime = convertTo12hr(grabTime(calendarBlacklist[i]));
          if(calendarDate === blacklistDate){
            let specificCalendarTime = document.querySelector(`.btn-time[value="${blacklistTime}"]`);
            specificCalendarTime.disabled = true;
            specificCalendarTime.classList.add('item-disabled');
          }
        }

        selectedTime = null;
      }

      document.getElementById('calendar').addEventListener('click', function(event) {
        updateCalendar();
      });
    </script>
  </body>
</html>
