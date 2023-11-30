"use strict";

(function ($) {
  "use strict";

  document.addEventListener("DOMContentLoaded", function () {
    var today = new Date(),
        year = today.getFullYear(),
        month = today.getMonth(),
        monthTag = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
        day = today.getDate(),
        days = document.getElementsByTagName("td"),
        selectedDay,
        setDate,
        daysLen = days.length; // options should like '2014-01-01'

    function Calendar(selector, options) {
      this.options = options;
      this.draw();
    }

    Calendar.prototype.draw = function () {
      this.getCookie("selected_day");
      this.getOptions();
      this.drawDays();
      var that = this,
          reset = document.getElementById("reset"),
          pre = document.getElementsByClassName("pre-button"),
          next = document.getElementsByClassName("next-button");
      pre[0].addEventListener("click", function () {
        that.preMonth();
      });
      next[0].addEventListener("click", function () {
        that.nextMonth();
      });
      reset.addEventListener("click", function () {
        that.reset();
      });

      while (daysLen--) {
        days[daysLen].addEventListener("click", function () {
          that.clickDay(this);
        });
      }
    };

    Calendar.prototype.drawHeader = function (e) {
      var headDay = document.getElementsByClassName("head-day");
      var headMonth = document.getElementsByClassName("head-month");

      if (e) {
        headDay[0].innerHTML = e;
        headDay[0].style.display = "block"; // Display the head-day
      } else {
        headDay[0].style.display = "none"; // Hide the head-day
      }

      headMonth[0].innerHTML = monthTag[month] + " - " + year;
    };

    Calendar.prototype.drawDays = function () {
      var today = new Date(); // Get today's date

      var startDay = new Date(year, month, 1).getDay();
      var nDays = new Date(year, month + 1, 0).getDate();
      var n = startDay;
      var todayPastMonths = new Date(today.getTime());
      todayPastMonths.setMonth(todayPastMonths.getMonth() - 1);

      for (var k = 0; k < 42; k++) {
        days[k].innerHTML = "";
        days[k].id = "";
        days[k].className = "";
        days[k].removeAttribute("disabled");
      }

      for (var i = 1; i <= nDays; i++) {
        days[n].innerHTML = i;
        n++;
      }

      for (var j = 0; j < 42; j++) {
        if (days[j].innerHTML === "") {
          days[j].id = "disabled";
        } else {
          var currentDate = new Date(year, month, days[j].innerHTML);

          if (currentDate < todayPastMonths || currentDate < today && month !== today.getMonth()) {
            days[j].id = "disabled";
            days[j].classList.add("disabled");
          } else if (currentDate.getTime() === today.getTime()) {
            days[j].id = "today";
            days[j].classList.add("selected");
          }
        }
      }

      for (var j = 0; j < 42; j++) {
        if (days[j].innerHTML === "") {
          days[j].id = "disabled";
        } else if (j === day + startDay - 1) {
          if (this.options && month === setDate.getMonth() && year === setDate.getFullYear() || !this.options && month === today.getMonth() && year === today.getFullYear()) {
            this.drawHeader(day);
            days[j].id = "today";
            days[j].classList.add("selected");
          }
        } else {
          // Disable past days in previous months
          var currentDate = new Date(year, month, days[j].innerHTML);

          if (currentDate < today || currentDate.getMonth() < today.getMonth() && currentDate.getFullYear() === today.getFullYear() || j === day + startDay - 1 && month !== today.getMonth() && year !== today.getFullYear()) {
            days[j].id = "disabled";
            days[j].classList.add("disabled");
          } else if (j === day + startDay - 1) {
            days[j].id = "today";
            days[j].classList.add("selected");
          }
        }

        if (selectedDay) {
          if (j === selectedDay.getDate() + startDay - 1 && month === selectedDay.getMonth() && year === selectedDay.getFullYear()) {
            days[j].classList.add("selected");
            this.drawHeader(selectedDay.getDate());
          }
        } // Disable click event and focusability for disabled days


        if (days[j].id === "disabled") {
          days[j].setAttribute("disabled", "disabled");
          days[j].style.pointerEvents = "none";
          days[j].setAttribute("tabindex", "-1");
          days[j].classList.add("disabled");
        } else {
          days[j].removeAttribute("disabled");
          days[j].style.pointerEvents = "auto";
          days[j].setAttribute("tabindex", "0");
          days[j].classList.remove("disabled");
        }
      }
    };

    Calendar.prototype.clickDay = function (o) {
      var selected = document.getElementsByClassName("selected"),
          len = selected.length;

      if (len !== 0) {
        selected[0].className = "";
      }

      o.className = "selected";
      selectedDay = new Date(year, month, o.innerHTML);
      this.drawHeader(o.innerHTML);
      this.setCookie("selected_day", 1);
    };

    Calendar.prototype.preMonth = function () {
      if (month < 1) {
        month = 11;
        year = year - 1;
      } else {
        month = month - 1;
      }

      this.drawHeader(null); // Hide the head-day

      this.drawDays();
    };

    Calendar.prototype.nextMonth = function () {
      if (month >= 11) {
        month = 0;
        year = year + 1;
      } else {
        month = month + 1;
      }

      this.drawHeader(null); // Hide the head-day

      this.drawDays();
    };

    Calendar.prototype.getOptions = function () {
      if (this.options) {
        var sets = this.options.split("-");
        setDate = new Date(sets[0], sets[1] - 1, sets[2]);
        day = setDate.getDate();
        year = setDate.getFullYear();
        month = setDate.getMonth();
      }
    };

    Calendar.prototype.reset = function () {
      month = today.getMonth();
      year = today.getFullYear();
      day = today.getDate();
      this.options = undefined;
      this.drawDays();
    };

    Calendar.prototype.setCookie = function (name, expiredays) {
      if (expiredays) {
        var date = new Date();
        date.setTime(date.getTime() + expiredays * 24 * 60 * 60 * 1000);
        var expires = "; expires=" + date.toGMTString();
      } else {
        var expires = "";
      }

      document.cookie = name + "=" + selectedDay + expires + "; path=/";
    };

    Calendar.prototype.getCookie = function (name) {
      if (document.cookie.length) {
        var arrCookie = document.cookie.split(";"),
            nameEQ = name + "=";

        for (var i = 0, cLen = arrCookie.length; i < cLen; i++) {
          var c = arrCookie[i];

          while (c.charAt(0) == " ") {
            c = c.substring(1, c.length);
          }

          if (c.indexOf(nameEQ) === 0) {
            selectedDay = new Date(c.substring(nameEQ.length, c.length));
          }
        }
      }
    };

    var calendar = new Calendar();
  }, false);
})(jQuery);