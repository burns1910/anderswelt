<?php
include 'config.php';
include './controller/pw_reset_form_controller.php';
include 'header.php';
include 'menu.php';

?>
<form action="" method="post">
	<div class="form-element">
    	<input type="text" class="text" name="email" placeholder="Enter your email address" required>
    	<button type="submit" name="reset-mail" value="reset-mail">zur&uuml;cksetzen</button>
    </div>
<?php include 'footer.php'; ?>