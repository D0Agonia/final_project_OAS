<?php
include __DIR__ . '/php/index_student_guest_form.php';
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
    <link rel="stylesheet" href="./css/index-student-guest.css" />
    <link rel="stylesheet" href="./css/main.css" />
    <link rel="stylesheet" href="dist/css/bootstrap.css" />
    <title>KLD - OAS | Student Appointment</title>
  </head>
  <body class="body">
    <div class="container">
      <header class="head">
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
          <p class="welcome fs-5">Welcome, 
            <span><?php if($userType == 'STUDENT'){echo $_SESSION['fName'];} else{echo 'Guest';}?></span>
          </p>
        </div>
        <div class="logout">
          <a href="logout">
            <img
              src="images/logout-icon.svg"
              alt="logout"
              style="width: 40px"
            />
          </a>
        </div>
      </section>
      <main class="form-details mb-lg-0">
        <section class="progress-box">
          <div class="progress px-1" style="height: 4px">
            <div
              class="progress-bar"
              role="progressbar"
              style="width: 0%; background-color: #0b4619"
              aria-valuenow="0"
              aria-valuemin="0"
              aria-valuemax="100"
            ></div>
          </div>
          <div class="step-container d-flex justify-content-between">
            <div class="step-circle">
              <img
                src="images/form-icon.svg"
                alt="form-icon"
                style="width: 30px"
              />
            </div>
            <div class="step-circle">
              <img
                src="images/schedule-icon.svg"
                alt="form-icon"
                style="width: 30px"
              />
            </div>
            <div class="step-circle">
              <img
                src="images/check-icon.svg"
                alt="form-icon"
                style="width: 30px"
              />
            </div>
          </div>
        </section>
        <section class="form-box">
          <form id="multi-step-form" method="post">
            <div class="step step-1">
              <!-- STEP 1 OF FORM -->
              <p class="description-child fs-5">
                Fill out the fields to make an appointment
              </p>
              <hr />
              <div class="form-parent">
                <div class="personal-child">
                  <p class="personal-title h5 fw-semibold">
                    Personal Information
                  </p>

                  <input
                    type="text"
                    class="form-control first-name"
                    placeholder="First Name"
                    name="fname"
                    value="<?php echo $_SESSION['fName']; ?>"
                    <?php if($userType == 'STUDENT'){echo "readonly";}?>
                  />
                  <input
                    type="text"
                    class="form-control last-name"
                    placeholder="Last Name"
                    name="lname"
                    value="<?php echo $_SESSION['lName']; ?>"
                    <?php if($userType == 'STUDENT'){echo "readonly";}?>
                  />
                  <input
                    type="text"
                    class="form-control last-name"
                    placeholder="Middle Name (optional)"
                    name="mname"
                    value="<?php echo $_SESSION['mName']; ?>"
                    <?php if($userType == 'STUDENT'){echo "readonly";}?>
                  />
                  <input
                    type="email"
                    class="form-control email"
                    placeholder="Email"
                    name="email"
                    value="<?php echo $_SESSION['email']; ?>"
                    <?php if($userType == 'GUEST'){echo "readonly";}?>
                  />
                  <input
                    type="tel"
                    class="form-control contact-no"
                    placeholder="Contact No. (optional)"
                    name="contact_no"
                    value="<?php echo $_SESSION['contactNum']; ?>"
                  />
                  <?php if($userType == 'STUDENT'){ echo '
                  <input
                    type="text"
                    class="form-control student-no"
                    placeholder="Student No."
                    name="student-id"
                    value="' . $_SESSION['loginID'] . '"
                    readonly
                  />';
                  } elseif($userType == 'GUEST'){ echo '
                  <input
                    type="hidden"
                    name="guest-id"
                    value="' . $_SESSION['loginID'] . '"
                  />
                  <select type="text" class="form-control type-of-id">
                    <option value="no-id" class="select-option" selected disabled>
                      Type of ID
                    </option>
                    <option value="SCH">School ID</option>
                    <option value="GOV">Government-Issued ID</option>
                    <option value="PVT">Private ID</option>
                  </select>
                  <input
                    type="text"
                    class="form-control identification-no"
                    placeholder="Identification No."
                    name="identification"
                  />';
                  }?>
                </div>
                <div class="appointment-child">
                  <p class="appointment-title h5 fw-semibold">
                    Appointment Details
                  </p>
                  <select type="text" class="form-control appointment-type">
                    <option value="NONE" class="select-option" selected disabled>
                      Appointment Type
                    </option>
                    <option value="DOCREQ">Document Request</option>
                    <option value="INFOCEN">Information Center</option>
                  </select>
                  <div class="position-box">
                    <div
                      class="document-requested form-control d-flex"
                      style="overflow: hidden"
                    >
                      <span class="document-placeholder">Document Type</span>
                      <span class="arrow-dwn">
                        <img
                          src="images/drop_down.svg "
                          alt="drop_down"
                          style="width: 25px"
                        />
                      </span>
                    </div>

                    <ul class="document-items" style="overflow-x: auto">
                      <li class="item item-disabled">
                        <span class="checkbox">
                          <img
                            class="check-icon"
                            src="images/check.svg"
                            alt="check"
                          />
                        </span>
                        <span class="item-text">Transcript of Records</span>
                        <input type="hidden" name="selectedDocuments[]" value="TOR" disabled/>
                      </li>
                      <li class="item item-disabled">
                        <span class="checkbox">
                          <img
                            class="check-icon"
                            src="images/check.svg"
                            alt="check"
                          />
                        </span>
                        <span class="item-text">Transfer Credentials</span>
                        <input type="hidden" name="selectedDocuments[]" value="TRC" disabled/>
                      </li>
                      <li class="item item-disabled">
                        <span class="checkbox">
                          <img
                            class="check-icon"
                            src="images/check.svg"
                            alt="check"
                          />
                        </span>
                        <span class="item-text">Certificate of Grades</span>
                        <input type="hidden" name="selectedDocuments[]" value="COG" disabled/>
                      </li>
                      <li class="item item-disabled">
                        <span class="checkbox">
                          <img
                            class="check-icon"
                            src="images/check.svg"
                            alt="check"
                          />
                        </span>
                        <span class="item-text">Certificate of Enrollment</span>
                        <input type="hidden" name="selectedDocuments[]" value="COE" disabled/>
                      </li>
                    </ul>
                  </div>
                  <textarea
                    class="form-control comments"
                    name="comment"
                    id="purpose-comment"
                    cols="30"
                    placeholder="Purpose of visit / Comments"
                  ></textarea>
                </div>
              </div>
              <p 
                class="text-center fw-bold text-danger" 
                id="step1-error-message" 
                style="display: none; margin-top: 10px; margin-bottom: 0px">
              </p>
              <div class="btn-box">
                <button
                  type="submit"
                  class="btn-next-back fw-semibold next-step"
                  value="next"
                >
                  Next
                </button>
              </div>
            </div>
            <div class="step step-2">
              <!-- STEP 2 OF FORM -->
              <p class="description-child fs-5">Select Date and Time</p>
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
                      id="TMSLOT-10"
                      name="btn1"
                      value="05:00 PM"
                    />
                  </div>
                </div>
              </div>
              <p 
                class="text-center fw-bold text-danger" 
                id="step2-error-message" 
                style="display: none; margin-top: 10px; margin-bottom: 0px">
              </p>
              <div class="btn-box">
                <button
                  type="button"
                  class="btn-next-back fw-semibold prev-step"
                  value="back"
                >
                  Back
                </button>
                <button
                  type="submit"
                  class="btn-next-back fw-semibold next-step"
                  value="next"
                >
                  Next
                </button>
              </div>
            </div>
            <div class="step step-3">
              <!-- STEP 3 OF FORM -->
              <p class="description-child fs-5">Appointment Summary</p>
              <hr />
              <div class="form-parent-summary">
                <div class="personal-box box table-responsive">
                  <table class="personal-details details">
                    <tr>
                      <th colspan="2">PERSONAL INFORMATION</th>
                    </tr>
                    <tr>
                      <td class="info-identifier">Email Address</td>
                      <td class="user-details" id="summary-email"></td>
                    </tr>
                    <tr>
                      <td class="info-identifier">Full Name</td>
                      <td class="user-details" id="summary-name"></td>
                    </tr>
                    <tr>
                      <td class="info-identifier">Contact Number</td>
                      <td class="user-details" id="summary-phone_number"></td>
                    </tr>
                    <?php if($userType == 'STUDENT'){ echo '
                    <tr>
                      <td class="info-identifier">Student ID</td>
                      <td class="user-details" id="summary-student_id"></td>
                    </tr>';
                    } elseif($userType == 'GUEST'){ echo '
                    <tr>
                      <td class="info-identifier">Type of ID</td>
                      <td class="user-details" id="summary-authentication"></td>
                    </tr>
                    <tr>
                      <td class="info-identifier">Identification No.</td>
                      <td class="user-details" id="summary-identification"></td>
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
                      <td class="info-identifier">Building</td>
                      <td class="user-details" id="summary-building"></td>
                    </tr>
                    <tr id="summary-documents">
                      <td class="info-identifier">Appointment Type</td>
                      <td class="user-details" id="summary-appointType"></td>
                    </tr>
                    <tr>
                      <td class="info-identifier">Date Released</td>
                      <td class="user-details" id="summary-date"></td>
                    </tr>
                    <tr>
                      <td class="info-identifier">Time</td>
                      <td class="user-details" id="summary-time"></td>
                    </tr>
                  </table>
                </div>
              </div>
              <p 
                class="text-center fw-bold text-danger" 
                id="step3-error-message" 
                style="display: none; margin-top: 10px; margin-bottom: 0px">
              </p>
              <div class="btn-box">
                <button
                  type="button"
                  class="btn-next-back fw-semibold prev-step"
                  value="back"
                >
                  Back
                </button>
                <button
                  type="submit"
                  class="btn-next-back fw-semibold submit-data"
                  value="submit"
                >
                  Confirm Appointment
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
    <script src="dist/js/bootstrap.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.slim.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
      var currentStep = 1;
      var updateProgressBar;
      var calendarBlacklist;
      var selectedTime;

      var AppointmentDocument = <?php echo json_encode(fetchTable("AppointmentDocument"))?>;
      var AppointmentType = <?php echo json_encode(fetchTable("AppointmentType"))?>;
      var AuthenticationID = <?php echo json_encode(fetchTable("AuthenticationID"))?>;

      function displayStep(stepNumber) {
        if (stepNumber >= 1 && stepNumber <= 3) {
          $(".step-" + currentStep).hide();
          $(".step-" + stepNumber).show();
          currentStep = stepNumber;
          updateProgressBar();
        }
      }

      $(document).ready(function () {
        document.cookie = "selected_day=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
        
        $("#multi-step-form").find(".step").slice(1).hide();

        $(".next-step").click(function () {
          event.preventDefault();
          if(currentStep == 1){
            processStep1();
          }
          if(currentStep == 2){
            processStep2();
          }
        });

        $(".prev-step").click(function () {
          event.preventDefault();
          handlePrevStep();
        });

        $(".submit-data").click(function () {
          event.preventDefault();
          submitData();
        })

        updateProgressBar = function () {
          var progressPercentage = ((currentStep - 1) / 2) * 100;
          $(".progress-bar").css("width", progressPercentage + "%");
        };
      });

      function handleNextStep() {
        if (currentStep < 3) {
          $(".step-" + currentStep).addClass("animate__animated animate__fadeOutLeft");
          currentStep++;
          setTimeout(function () {
              $(".step").removeClass("animate__animated animate__fadeOutLeft").hide();
              $(".step-" + currentStep).show().addClass("animate__animated animate__fadeInRight");
              updateProgressBar();
          }, 500);
        }
      }

      function handlePrevStep() {
        if (currentStep > 1) {
          $(".step-" + currentStep).addClass("animate__animated animate__fadeOutRight");
          currentStep--;
          setTimeout(function () {
              $(".step").removeClass("animate__animated animate__fadeOutRight").hide();
              $(".step-" + currentStep).show().addClass("animate__animated animate__fadeInLeft");
              updateProgressBar();
          }, 500);
        }
      }

      function fetchFormData() {
        const formData = $(".step.step-1 :input").serializeArray().reduce((obj, item) => {
          if(item.name !== 'selectedDocuments[]' && item.name !== 'identification'){
            obj[item.name] = item.value;
          }
          return obj;
        }, {});

        const userType = '<?php echo $userType;?>';
        if (userType === 'GUEST') {
          formData.idType = document.querySelector('.form-control.type-of-id').value;
          formData.identification = document.querySelector('.form-control.identification-no').value;
        }
        else if (userType === 'STUDENT'){
          formData.idType = 'KLD';
          formData.identification = '';
        }

        const selectedDocuments = [];
        $('.document-items li input[name="selectedDocuments[]"]').each(function() {
          if (!$(this).is(':disabled')) {
            selectedDocuments.push($(this).val());
          }
        });

        formData.appointmentBuilding = 'KLD Building No. 1';
        formData.appointmentType = document.querySelector('.form-control.appointment-type').value;
        formData.selectedDocuments = selectedDocuments;
        if(selectedTime != null){
          formData.appointmentDate = calendarDate + " " + convertTo24hr(selectedTime);
        }
        else{
          formData.appointmentDate = calendarDate;
        }
        formData.userType = userType;

        return JSON.stringify(formData);
      }

      function processStep1() {
        const jsonData = fetchFormData();

        $.ajax({
          url: "phpAction/sanitize_information_details.php",
          method: "POST",
          data: {jsonData: jsonData},
          dataType: "json",
          beforeSend: function(xhr) {
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
          },
          success: function(response){
            if(response.processed == true){
              document.getElementById('step1-error-message').style.display = 'none';
              calendarBlacklist = response.blacklist;
              updateCalendar();
              handleNextStep();
            }
            else{
              document.getElementById('step1-error-message').style.display = '';
              $("#step1-error-message").text(response.error_message);
            }
          },
          error: function(error){
            console.error(error);
          }
        });
      }

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

      var calendarDate;

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

      function grabDate(input) {
        const datePart = input.split(' ')[0];
        return datePart;
      }

      function grabTime(input) {
        const timePart = input.split(' ')[1];
        return timePart;
      }

      const timeInputs = document.querySelectorAll('.btn-time');

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

      function addDocument(data) {
        var docRequestedRow = document.getElementById("summary-documents");

        var newRow = document.createElement("tr");

        newRow.innerHTML = `
          <td class="info-identifier">Requested Document</td>
          <td class="user-details" id="summary-docreq">${data}</td>
        `;

        newRow.id = "auto-generated-row";

        docRequestedRow.parentNode.insertBefore(newRow, docRequestedRow.nextSibling);
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

      function deleteDocument() {
        document.querySelectorAll('#auto-generated-row').forEach(function(row) {
          row.parentNode.removeChild(row);
        });
      }

      function processStep2() {
        const jsonData = fetchFormData();

        $.ajax({
          url: "phpAction/sanitize_calendar.php",
          method: "POST",
          data: {jsonData: jsonData},
          dataType: "json",
          beforeSend: function(xhr) {
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
          },
          success: function(response){
            if(response.processed == true){
              deleteDocument();
              document.getElementById('step2-error-message').style.display = 'none';

              document.querySelector('#summary-email').textContent = response.email;
              document.querySelector('#summary-name').textContent = buildName(response.fname, response.mname, response.lname);
              document.querySelector('#summary-phone_number').textContent = response.contact_no;
              if(document.getElementById('summary-student_id')){
                document.querySelector('#summary-student_id').textContent = response['student-id'];
              }
              if(document.getElementById('summary-authentication') && document.getElementById('summary-identification')){
                for(let i = 0; i < AuthenticationID.length; i++){
                  if(AuthenticationID[i].auth_abbreviation === response.idType){
                    document.querySelector('#summary-authentication').textContent = AuthenticationID[i].auth_name;
                    break;
                  }
                }
                document.querySelector('#summary-identification').textContent = response.identification;
              }
              document.querySelector('#summary-building').textContent = response.appointmentBuilding;
              for(let i = 0; i < AppointmentType.length; i++){
                if(AppointmentType[i].type_id === response.appointmentType){
                  document.querySelector('#summary-appointType').textContent = AppointmentType[i].type_name;
                  break;
                }
              }
              if(response.appointmentType === 'DOCREQ'){
                for(let i = 0; i < response.selectedDocuments.length; i++){
                  for(let j = 0; j < AppointmentDocument.length; j++){
                    if(AppointmentDocument[j].doc_abbreviation === response.selectedDocuments[i]){
                      addDocument(AppointmentDocument[j].doc_name);
                      break;
                    }
                  }
                }
              }
              document.querySelector('#summary-date').textContent = grabDate(response.appointmentDate);
              document.querySelector('#summary-time').textContent = convertTo12hr(grabTime(response.appointmentDate));

              handleNextStep();
            }
            else{
              document.getElementById('step2-error-message').style.display = '';
              $("#step2-error-message").text(response.error_message);
            }
          },
          error: function(error){
            console.error(error);
          }
        });
      }

      function submitData() {
        const jsonData = fetchFormData();

        $.ajax({
          url: "phpAction/submit_data.php",
          method: "POST",
          data: {jsonData: jsonData},
          dataType: "json",
          beforeSend: function(xhr) {
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
          },
          success: function(response){
            if(response.processed == true){
              document.getElementById('step3-error-message').style.display = 'none';
              window.location.href = window.location.origin + "/thankyou-page?control_number=" + response.control_number;
            }
            else{
              document.getElementById('step3-error-message').style.display = '';
              $("#step3-error-message").text(response.error_message);
            }
          },
          error: function(error){
            console.error(error);
          }
        });
      }

      const selectBtn = document.querySelector(".document-requested");
      const items = document.querySelectorAll(".item");
      const appointmentTypeSelect = document.querySelector('.form-control.appointment-type');

      selectBtn.addEventListener("click", () => {
        selectBtn.classList.toggle("open");
      });

      items.forEach((item) => {
        item.addEventListener("click", () => {
          item.classList.toggle("checked");
          let checked = document.querySelectorAll(".checked");
          let btnText = document.querySelector(".document-placeholder");

          if (checked && checked.length > 0) {
            btnText.innerText = `${checked.length} Selected`;

            // Enable hidden inputs for checked items
            checked.forEach((checkedItem) => {
              let hiddenInput = checkedItem.querySelector('input[name="selectedDocuments[]"]');
              if (hiddenInput) {
                hiddenInput.disabled = false;
              }
            });
          } else {
            btnText.innerText = `Document Type`;

            // Disable all hidden inputs when no items are checked
            let allHiddenInputs = document.querySelectorAll('input[name="selectedDocuments[]"]');
            allHiddenInputs.forEach((hiddenInput) => {
              hiddenInput.disabled = true;
            });
          }
        });
      });

      appointmentTypeSelect.addEventListener('change', function() {
        // Get the selected value from the select tag
        var selectedValue = this.value;

        // Get the list elements by class name along with hidden inputs
        var docList = document.querySelectorAll('.document-items .item');
        var btnText = document.querySelector(".document-placeholder");
        var allHiddenInputs = document.querySelectorAll('input[name="selectedDocuments[]"]');

        // Uncheck checkboxes and apply the item-disabled class to all items if Information is selected
        btnText.innerText = `Document Type`;
        docList.forEach(function(item) {
          if (selectedValue === 'INFOCEN') {
            allHiddenInputs.forEach((hiddenInput) => {
              hiddenInput.disabled = true;
            });
            item.classList.remove('checked');
            item.classList.add('item-disabled');
          } else if (selectedValue === 'DOCREQ') {
            item.classList.remove('item-disabled');
          }
        });
      });
    </script>
  </body>
</html>