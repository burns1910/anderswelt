<?php
include 'user_controller.php';
include 'mail_controller.php';
#require_once "./controller/lib/crypto/random.php";


if (isset($_POST['register'])) {
 
    $vorname = $_POST['vorname'];
    $nachname = $_POST['nachname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];
    $token = $token = bin2hex(random_bytes(50));
    $pw_hash = password_hash($password, PASSWORD_BCRYPT);
    $errors = false;
    $timestamp = time()+60*60*24; //Aktueller Timestamp +24 Std
    $token_expire_date = date('Y-m-d H:i:s',$timestamp);

    if (!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)) {
        $message = '<p class="aw-error-message">Bitte gib eine g&uuml;ltige E-Mail Adresse ein.</p><br />';
        $errors = true;
    } elseif ($password != $password2) {
        $message = '<p class="aw-error-message">Die eingegebenen Passw&ouml;rter stimmen nicht überein.</p><br />';
        $errors = true;
    }

    if(doesUserExist($email) == true) {
        $message = '<p class="aw-error-message">Diese E-Mail wurde bereits registriert.</p><br />';
        $errors = true;
    }
 
    if(!$errors) {
        $user_id = addUser($vorname, $nachname, $email, $token, $pw_hash, $token_expire_date);
        if($user_id!=0) {
            $message = '<p class="aw-success-message">User erfolgreich registiert.</p><br />';
            $message .= '<p class="aw-info-message">Zur Verifizierung deines Accounts wurde dir eine E-Mail zugesendet.</p><br />';

            $verifyMail_text = 'Moin '.$vorname.',<br /><br />';
            $verifyMail_text .= 'schön, dass du bei uns mitplanen möchtest. Bitte bestätige dafür zunächst deine E-Mail Adresse, indem du auf folgenden Link klickst:<br /><br />';
            $verifyMail_text .= '<a href="https://planung.anderswe.lt/verify_user.php?id='.$user_id.'&token='.$token.'">https://planung.anderswe.lt/verify.php?id='.$user_id.'&token='.$token.'</a>';
            $verifyMail_betreff = 'Anderswelt Planungskosmos Email Verifikation';
            sendMail($email, $verifyMail_betreff, $verifyMail_text, 'burns@anderswe.lt', 'Anderswelt Planungskosmos');
        } else {
            $message = '<p class="aw-error-message">User konnte nicht angelegt werden.</p><br />';
        }
    }
}
?>