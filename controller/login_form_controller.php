<?php
include 'user_controller.php';

if (isset($_POST['login'])) {
 
    $email = $_POST['email'];
    $password = $_POST['password'];
    $user = getUserByMail($email);
 
    if (!$user) {
        $message = '<p class="aw-error-message">E-Mail Password Kombination konnte nicht verifiziert werden!</p><br />';
    } else {
        if ((password_verify($password, $user['pw_hash'])) && ($user['aktiv'] == 1)) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_vorname'] = $user['vorname'];
            $_SESSION['user_nachname'] = $user['nachname'];
            $_SESSION['user_email'] = $user['email'];
            header("Location: index.php");
        } else {
            $message = '<p class="aw-error-message">E-Mail Password Kombination konnte nicht verifiziert werden!</p><br />';
        }
    }
}
?>
