<?php
include 'config.php';
include './controller/pw_reset_verify_form_controller.php';
include 'header.php';
include 'menu.php';


if($tokenChecked) {
    global $selector;
    global $validator;
?>
	<form action="" method="post">
	    <input type="hidden" name="selector" value="<?php echo $selector; ?>">
	    <input type="hidden" name="validator" value="<?php echo $validator; ?>">
	    <div class="form-element"><input type="password" class="text" name="password" placeholder="Enter your new password" required></div>
	    <button type="submit" name="reset-pw" value="reset-pw">&Auml;ndern</button>
	</form>
<?php 
}
include 'footer.php'; ?>