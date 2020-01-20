<?php
include 'config.php';
include './controller/register_form_controller.php';
include 'header.php';
include 'menu.php';

?>

<form method="post" action="" name="signup-form">
    <div class="form-element">
        <label>Vorname</label>
        <input type="text" name="vorname" pattern="[a-zA-Z0-9]+" required />
    </div>
    <div class="form-element">
        <label>Nachname</label>
        <input type="text" name="nachname" pattern="[a-zA-Z0-9]+" required />
    </div>
    <div class="form-element">
        <label>Email</label>
        <input type="email" name="email" required />
    </div>
    <div class="form-element">
        <label>Password</label>
        <input type="password" name="password" required />
    </div>
    <div class="form-element">
        <label>Password bestätigen</label>
        <input type="password" name="password2" required />
    </div>
    <button type="submit" name="register" value="register">Registrieren</button>
</form>
<?php include 'footer.php'; ?>