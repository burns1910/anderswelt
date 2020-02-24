<?php if (isset($_SESSION['success_msg'])): ?>
  <div class="alert alert-success">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <?php
      echo $_SESSION['success_msg'];
      unset($_SESSION['success_msg']);
    ?>
  </div>
<?php endif; ?>

<?php if (isset($_SESSION['error_msg'])): ?>
  <div class="alert alert-danger">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <?php
      echo $_SESSION['error_msg'];
      unset($_SESSION['error_msg']);
    ?>
  </div>
<?php endif; ?>

<?php if (isset($_SESSION['info_msg'])): ?>
  <div class="alert alert-info">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <?php
      echo $_SESSION['info_msg'];
      unset($_SESSION['info_msg']);
    ?>
  </div>
<?php endif; ?>
