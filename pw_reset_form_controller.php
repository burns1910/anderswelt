<?php
include 'pw_reset_controller.php';
include 'register_controller.php';
include 'mail_controller.php';
require_once "./controller/lib/crypto/random.php";


 if (isset($_POST['reset-mail'])) {
    $errors = false;
    $email = $_POST['email'];

    if(doesUserExist($email) && filter_var($email,FILTER_VALIDATE_EMAIL)) { //Wenn user Existiert und eine gültige Eingabe vorliegt
        // Create tokens
        $selector = bin2hex(random_bytes(8));
        $token = random_bytes(32);
        $hash = hash('sha256', $token);

        $url = sprintf('%spw_reset_verify.php?%s', "https://planung.anderswe.lt/", http_build_query([
            'selector' => $selector,
            'validator' => bin2hex($token)
        ]));

        // Token expiration
        $timestamp = time()+60*60*24; //Aktueller Timestamp +24 Std
        $token_expire_date = date('Y-m-d H:i:s',$timestamp);

        deleteTokenByEMail($email);
        addToken($email, $selector, $hash, $token_expire_date);

        $resetMail_text = 'Moin,<br /><br />';
        $resetMail_text .= 'jemand (wahrscheinlich du), hat versucht dein Password zur&uuml;ckzusetzen. Um diesen Vorgang abzuschließen, klicke auf folgenden Link:<br /><br />';
        $resetMail_text .= sprintf('<a href="%s">%s</a></p>', $url, $url);
        $resetMail_betreff = 'Anderswelt Planungskosmos Reset Password';
 //       sendMail($email, $resetMail_betreff, $resetMail_text, 'burns@anderswe.lt', 'Anderswelt Planungskosmos');
        echo $url;
        $message = '<p class="aw-info-message">Bitte check dein E-Mail Postfach</p><br />';
    }
    else {
        $message = '<p class="aw-error-message">Bitte gib eine g&uuml;ltige E-Mail Adresse ein.</p><br />';
    }
}

?>