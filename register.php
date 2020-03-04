<?php
include 'config.php';
include BASE_PATH.'/persistence/controller/register_form_controller.php';
include BASE_PATH.'/header.php';
include BASE_PATH.'/menu.php';

?>
    <div class="container">
      <div class="row">
        <div class="col-md-4 col-md-offset-4">
          <form method="post" action="" name="signup-form" class="needs-validation" novalidate>
            <?php include 'utils/messages.php' ?>
            <h2 class="text-center">Register</h2>
            <hr>
            <div class="form-group">
              <label for="inputVorname">Vorname</label>
              <input type="text" class="form-control" id="inputVorname" name="vorname" pattern="[a-zA-Z0-9]+" required />
            </div>
            <div class="form-group">
              <label for="inputNachname">Nachname</label>
              <input type="text" class="form-control" id="inputNachname" name="nachname" pattern="[a-zA-Z0-9]+" required />
            </div>
            <div class="form-group">
              <label for="inputEmail">Email</label>
              <input type="email" class="form-control" id="inputEmail" name="email" required />
            </div>
            <div class="form-group">
              <label for="inputPassword">Password</label>
              <input type="password" class="form-control" id="inputPassword" name="password" required />
            </div>
            <div class="form-group">
              <label for="inputPassword2">Password bestätigen</label>
              <input type="password" class="form-control" id="inputPassword2" name="password2" required />
            </div>
            <button type="submit" class="btn btn-primary" name="register" value="register">Registrieren</button>
          </form>
        </div>
      </div>
    </div>

<?php include BASE_PATH.'/footer.php'; ?>
