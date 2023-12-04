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
            <span><?php if($userType == 'STUDENT'){echo $_SESSION['fName'];}else{echo 'Guest';}?></span>
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
            <div class="step-circle" onclick="displayStep(1)">
              <img
                src="images/form-icon.svg"
                alt="form-icon"
                style="width: 30px"
              />
            </div>
            <div class="step-circle" onclick="displayStep(2)">
              <img
                src="images/schedule-icon.svg"
                alt="form-icon"
                style="width: 30px"
              />
            </div>
            <div class="step-circle" onclick="displayStep(3)">
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
                    name="student"
                    value="' . $_SESSION['loginID'] . '"
                    readonly
                  />';
                  } elseif($userType == 'GUEST'){ echo '
                  <select type="text" class="form-control type-of-id">
                    <option class="select-option" selected disabled>
                      Type of ID
                    </option>
                    <option value="school-id">School ID</option>
                    <option value="gov-id">Government-Issued ID</option>
                    <option value="private-id">Private ID</option>
                  </select>
                  <input
                    type="text"
                    class="form-control intification-no"
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
                    <option class="select-option" selected disabled>
                      Appointment Type
                    </option>
                    <option value="document">Document Requested</option>
                    <option value="information">Information Center</option>
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
                style="display: none; margin-top: 10px; margin-bottom: 0">
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
                      id="TMSLOT-010"
                      name="btn1"
                      value="05:00 PM"
                    />
                  </div>
                </div>
              </div>
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
                      <td class="user-details">jbuscsgan@gmail.com</td>
                    </tr>
                    <tr>
                      <td class="info-identifier">Full Name</td>
                      <td class="user-details">Josephine A. Madrigal</td>
                    </tr>
                    <tr>
                      <td class="info-identifier">Contact Number</td>
                      <td class="user-details">09305771234</td>
                    </tr>
                    <tr>
                      <td class="info-identifier">Student Number</td>
                      <td class="user-details">KLD-22-000234</td>
                    </tr>
                    <tr>
                      <td class="info-identifier">Type of ID</td>
                      <td class="user-details">SSS</td>
                    </tr>
                    <tr>
                      <td class="info-identifier">Identification No.</td>
                      <td class="user-details">Optional</td>
                    </tr>
                  </table>
                </div>
                <div class="appointment-box box table-responsive">
                  <table class="appointment-details details">
                    <tr>
                      <th colspan="2">APPOINTMENT INFORMATION</th>
                    </tr>
                    <tr>
                      <td class="info-identifier">Building</td>
                      <td class="user-details">KLD Building No.1</td>
                    </tr>
                    <tr>
                      <td class="info-identifier">Document Requested</td>
                      <td class="user-details">
                        Official Transcript of Record (TOR)
                      </td>
                    </tr>
                    <tr>
                      <td class="info-identifier">Date Released</td>
                      <td class="user-details">Sample Date</td>
                    </tr>
                    <tr>
                      <td class="info-identifier">Time</td>
                      <td class="user-details">Sample Time</td>
                    </tr>
                  </table>
                </div>
              </div>
              <div class="btn-box">
                <button
                  type="button"
                  class="btn-next-back fw-semibold prev-step"
                  value="back"
                >
                  Back
                </button>
                <a
                  href="thankyou-page"
                  type="submit"
                  class="btn-next-back fw-semibold"
                  value="next"
                >
                  Confirm Appointment
                </a>
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

      function displayStep(stepNumber) {
        if (stepNumber >= 1 && stepNumber <= 3) {
          $(".step-" + currentStep).hide();
          $(".step-" + stepNumber).show();
          currentStep = stepNumber;
          updateProgressBar();
        }
      }

      $(document).ready(function () {
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

      function processStep1() {
        const appointmentTypeSelect = document.querySelector('.form-control.appointment-type');
        const selectedValue = appointmentTypeSelect.value;

        const formData = $(".step.step-1 :input").serializeArray().reduce((obj, item) => {
          obj[item.name] = item.value;
          return obj;
        }, {});

        const selectedDocuments = [];
        $('.document-items li input[name="selectedDocuments[]"]').each(function() {
          if (!$(this).is(':disabled')) {
            selectedDocuments.push($(this).val());
          }
        });

        formData.appointmentType = selectedValue;
        formData.selectedDocuments = selectedDocuments;

        const jsonData = JSON.stringify(formData);

        console.log(jsonData);

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
              console.log(response.calendar_blacklist);
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

      function processStep2() {
        const cookieName = "selected_day";
        const cookieValue = document.cookie
          .split("; ")
          .find((row) => row.startsWith(cookieName))
          ?.split("=")[1]
        ;
        handleNextStep();
      }

      let selectedTime;
      const selectBtn = document.querySelector(".document-requested");
      const items = document.querySelectorAll(".item");
      const appointmentTypeSelect = document.querySelector('.form-control.appointment-type');
      const timeInputs = document.querySelectorAll('.btn-time');

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
          if (selectedValue === 'information') {
            allHiddenInputs.forEach((hiddenInput) => {
              hiddenInput.disabled = true;
            });
            item.classList.remove('checked');
            item.classList.add('item-disabled');
          } else if (selectedValue === 'document') {
            item.classList.remove('item-disabled');
          }
        });
      });

      timeInputs.forEach((input) => {
        input.addEventListener('change', function() {
          if(this.checked) {
            // Input is selected
            selectedTime = this.value;
          } else {
            // Input is deselected
            selectedTime = null;
          }
        });
      });
    </script>
  </body>
</html>
