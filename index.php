<?php
include 'config.php';
include './controller/login_form_controller.php';
include 'header.php';
include 'menu.php';
if(!$logged_in_admin) {

?>

<form method="post" action="" name="signin-form">
    <div class="form-element">
        <label>E-Mail</label>
        <input type="email" name="email" required />
    </div>
    <div class="form-element">
        <label>Password</label>
        <input type="password" name="password" required />
    </div>
    <button type="submit" name="login" value="login">Log In</button>
</form><br />

<a class="aw-center-text" href="register.php"><i class="fa fa-fw fa-user-plus"></i>Neuen User registrieren</a><br /><br />
<a class="aw-center-text" href="pw_reset.php"><i class="fa fa-fw fa-refresh"></i>Password vergessen?</a>


<?php
}
else {
	echo '<p class="aw-center-text">Hallo '.$_SESSION['user_vorname'].'</p>';
}
include 'footer.php';
?>