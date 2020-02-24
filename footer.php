  <script>
  (function() {
  'use strict';
  window.addEventListener('load', function() {
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
  })();
  </script>
  <script src="/anderswelt/css/jquery-3.4.1.js"></script>
  <script src="/anderswelt/css/bootstrap.bundle.js"></script>
</body>
</html>
<?php
$connection = null;
?>
