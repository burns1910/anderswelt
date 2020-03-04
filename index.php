<?php
include 'config.php';
include(BASE_PATH.'/persistence/controller/login_form_controller.php');
include(BASE_PATH.'/header.php');
include(BASE_PATH.'/menu.php');
if(!isset($_SESSION['user_id'])) {

?>

    <div class="container">
      <div class="row">
        <div class="col-md-4 col-md-offset-4">
          <?php include 'utils/messages.php' ?>
          <form method="post" action="" name="signin-form" class="mb-4">
            <h2 class="text-center">Login</h2>
            <hr>
            <div class="form-group">
              <label for="inputEmail">E-Mail</label>
              <input type="email" class="form-control" id="inputEmail" name="email" required />
            </div>
            <div class="form-group">
              <label for="inputPassword">Password</label>
              <input type="password" class="form-control" id="inputPassword" name="password" required />
            </div>
            <button type="submit" class="btn btn-primary" name="login" value="login">Log In</button>
          </form>
          <p><a href="register.php"><i class="fa fa-fw fa-user-plus"></i>Neuen User registrieren</a></p>
          <p><a href="pw_reset.php"><i class="fa fa-fw fa-refresh"></i>Password vergessen?</a></p>
        </div>
      </div>
    </div>



<?php
}
else {
?>
    <div class="container">
      <blockquote class="blockquote">
        <p>Da spricht man wohl wieder einmal vom sogenannten besten Leben!</p>
        <footer class="blockquote-footer">la cr&eacute;ature mythique</footer>
      </blockquote>
  </div>
<?php
}
include(BASE_PATH.'/footer.php');
?>
