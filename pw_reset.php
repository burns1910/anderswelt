<?php
include 'config.php';
include BASE_PATH.'/persistence/controller/pw_reset_form_controller.php';
include BASE_PATH.'/header.php';
include BASE_PATH.'/menu.php';

?>
		<div class="container">
			<div class="row">
				<div class="col-md-4 col-md-offset-4">
					<?php include 'utils/messages.php'; ?>
					<form method="post" action="">
						<h2 class="text-center">Passwort zur&uuml;cksetzen</h2>
						<hr>
						<div class="form-group">
				    	<input type="text" class="form-control mb-4" name="email" placeholder="Enter your email address" required>
				    	<button type="submit" class="btn btn-primary" name="reset-mail" value="reset-mail">zur&uuml;cksetzen</button>
				    </div>
					</form>
				</div>
			</div>
		</div>
<?php include BASE_PATH.'/footer.php'; ?>
