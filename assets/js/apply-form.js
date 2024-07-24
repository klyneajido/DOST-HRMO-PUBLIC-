(function () {
  'use strict';

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  var forms = document.querySelectorAll('.needs-validation');

  // Loop over them and prevent submission
  Array.prototype.slice.call(forms)
      .forEach(function (form) {
          form.addEventListener('submit', function (event) {
              // Check file size for all file inputs
              var fileInputs = form.querySelectorAll('input[type="file"]');
              var isValid = true;

              fileInputs.forEach(function (input) {
                  if (!validateFileSize(input)) {
                      isValid = false;
                  }
              });

              if (!form.checkValidity() || !isValid) {
                  event.preventDefault();
                  event.stopPropagation();
              }

              form.classList.add('was-validated');
          }, false);
      });
})();

function validateFileSize(input) {
  const file = input.files[0];
  const maxSize = 5 * 1024 * 1024; // 5MB in bytes
  const invalidSizeFeedback = input.closest('.col-md-6').querySelector('.invalid-size');
  const invalidFeedback = input.closest('.col-md-6').querySelector('.invalid-feedback');

  if (file && file.size > maxSize) {
      invalidSizeFeedback.style.display = 'block'; // Show size error message
      invalidFeedback.style.display = 'none'; // Hide generic error message
      input.value = ''; // Clear the file input
      return false;
  } else {
      invalidSizeFeedback.style.display = 'none'; // Hide size error message
  }

  // Check for generic validation error
  if (!input.checkValidity()) {
      invalidFeedback.style.display = 'block'; // Show generic error message
  } else {
      invalidFeedback.style.display = 'none'; // Hide generic error message
  }

  return true;
}

function validateFormFiles(form) {
  const fileInputs = form.querySelectorAll('input[type="file"]');
  let isValid = true;

  fileInputs.forEach(input => {
      if (input.hasAttribute('required') && input.files.length === 0) {
          input.nextElementSibling.style.display = 'block'; // Show required field error
          isValid = false;
      } else {
          input.nextElementSibling.style.display = 'none'; // Hide error if file is present
      }

      if (!validateFileSize(input)) {
          isValid = false;
      }
  });

  return isValid;
}

(function () {
  'use strict';
  var forms = document.querySelectorAll('.needs-validation');
  Array.prototype.slice.call(forms)
      .forEach(function (form) {
          form.addEventListener('submit', function (event) {
              if (!form.checkValidity() || !validateFormFiles(form)) {
                  event.preventDefault();
                  event.stopPropagation();
              }
              form.classList.add('was-validated');
          }, false);
      });
})();
