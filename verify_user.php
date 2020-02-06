<?php
include 'config.php';
include './controller/user_controller.php';
include './controller/mail_controller.php';
include 'header.php';
include 'menu.php';

if(isset($_GET['id']) && isset($_GET['token'])) {
    $user_id = $_GET['id'];
    $token = $_GET['token'];
    $email = getMailFromUserByID($user_id);
    $verified = isEmailVerified($email);

    if($verified == 0) {
        $timestamp = time();
        $expireDate = getTokenExpireDateByUserID($user_id);

        if($timestamp >= $expireDate) {
            echo '<p class="aw-error-message">Der Link zur Verifizierung ist abgelaufen</p><br />';
            // Neuen Link zusenden
        } elseif ($timestamp < $expireDate) {
            verifyEmail($email);
            echo '<p class="aw-success-message">E-Mail erfolgreich aktiviert</p><br />';
            echo '<p class="aw-info-message">Dein Account muss noch freigeschaltet werden, Burns weiss Bescheid...</p><br />';
            
            $activateMail_text = 'Neuer User mit ID '.$user_id.' hat sich registriert.';
            $activateMail_betreff = 'Neue Anmeldung im Burns-System';
            sendMail('burns@anderswe.lt', $activateMail_betreff, $activateMail_text, 'burns@anderswe.lt', 'Anderswelt Planungskosmos');
        }
    } else {
        header("Location: index.php");
    }
}



include 'footer.php';
?>