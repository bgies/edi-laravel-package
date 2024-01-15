(function () {
  'use strict'

  var buttons = document.querySelectorAll('.edi-btn-copy')
  // Fetch all the forms we want to apply custom Bootstrap validation styles to
//  var forms = document.querySelectorAll('.needs-validation')

  // Loop over them and prevent submission
  Array.prototype.slice.call(buttons)
    .forEach(function (button) {
      button.addEventListener('click', function (event) {
         var checkboxes = document.querySelectorAll('.form-check-input')
         Array.prototype.slice.call(checkboxes)
            .forEach(function (checkbox) {
               
            })

        form.classList.add('was-validated')
      }, false)
      
    })
})()