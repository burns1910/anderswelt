<?php
include 'config.php';
include BASE_PATH.'/persistence/controller/pw_reset_verify_form_controller.php';
include BASE_PATH.'/header.php';
include BASE_PATH.'/menu.php';


if($tokenChecked) {
    global $selector;
    global $validator;
?>
    <div class="container">
      <div class="row">
        <div class="col-md-4 col-md-offset-4">
          <?php include 'utils/messages.php'; ?>
          <form method="post" action="">
      	    <input type="hidden" name="selector" value="<?php echo $selector; ?>">
      	    <input type="hidden" name="validator" value="<?php echo $validator; ?>">
            <div class="form-group">
              <input type="password" class="form-control mb-4" name="password" placeholder="Enter your new password" required>
            </div>
            <div class="form-group">
              <input type="password" class="form-control mb-4" name="password2" placeholder="Re-enter your new password" required>
            </div>
      	    <button type="submit" class="btn btn-primary" name="reset-pw" value="reset-pw">&Auml;ndern</button>
	        </form>
        </div>
      </div>
    </div>

<?php
}
include BASE_PATH.'/footer.php'; ?>
