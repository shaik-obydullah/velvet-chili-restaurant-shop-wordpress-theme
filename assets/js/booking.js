/**
 * Booking Form AJAX Submission (client-side UX only)
 * Server-side validation remains the single source of truth.
 */
jQuery(document).ready(function ($) {
  $("#bookingForm").on("submit", function (e) {
    e.preventDefault();

    // Clear previous inline errors
    $(".booking-form__error").remove();

    var form = $(this);
    var isValid = true;
    var errorMessages = [];

    // Helper to safely get trimmed value (handles null/undefined)
    function getTrimmedVal(selector) {
      var $el = form.find(selector);
      if ($el.length && $el.val() !== null && $el.val() !== undefined) {
        return $el.val().trim();
      }
      return "";
    }

    // Get field values safely
    var name = getTrimmedVal('[name="name"]');
    var email = getTrimmedVal('[name="email"]');
    var phone = getTrimmedVal('[name="phone"]');
    var party = form.find('[name="party"]').val();
    var date = form.find('[name="date"]').val();
    var time = form.find('[name="time"]').val();

    // Helper to show error
    function showError(selector, message) {
      var $input = form.find(selector);
      if ($input.length) {
        $(
          '<div class="booking-form__error" style="color:#b8413a; font-size:0.85rem; margin-top:4px;">' +
            message +
            "</div>",
        ).insertAfter($input);
      }
      isValid = false;
      errorMessages.push(message);
    }

    // Validate each field
    if (name === "") showError('[name="name"]', "Please enter your full name.");
    if (email === "") {
      showError('[name="email"]', "Please enter your email address.");
    } else if (!/^[^\s@]+@([^\s@.,]+\.)+[^\s@.,]{2,}$/.test(email)) {
      showError('[name="email"]', "Please enter a valid email address.");
    }
    if (phone === "")
      showError('[name="phone"]', "Please enter your phone number.");
    if (!party || party === "")
      showError('[name="party"]', "Please select number of guests.");
    if (!date) showError('[name="date"]', "Please select a date.");
    if (!time || time === "")
      showError('[name="time"]', "Please select a time.");

    if (!isValid) {
      alert("Please fix the following:\n\n- " + errorMessages.join("\n- "));
      return;
    }

    // Proceed with AJAX
    var submitBtn = form.find(".booking-form__submit");
    var originalText = submitBtn.text();
    submitBtn.text("Sending...").prop("disabled", true);

    var formData = {
      action: "vcrs_booking",
      nonce: vcrs_booking_ajax.nonce,
      name: name,
      email: email,
      phone: phone,
      party: party,
      date: date,
      time: time,
      notes: form.find('[name="notes"]').val() || "",
    };

    $.ajax({
      url: vcrs_booking_ajax.ajax_url,
      type: "POST",
      data: formData,
      success: function (response) {
        if (response.success) {
          alert(response.data.message);
          form[0].reset();
          $(".booking-form__error").remove();
        } else {
          var errors = response.data.errors;
          alert(errors ? errors.join("\n") : response.data.error);
        }
      },
      error: function () {
        alert("AJAX request failed. Please try again.");
      },
      complete: function () {
        submitBtn.text(originalText).prop("disabled", false);
      },
    });
  });
});
