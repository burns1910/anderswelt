<?php
include BASE_PATH.'/persistence/dao/ResetDAO.php';
include BASE_PATH.'/persistence/dao/UserDAO.php';
$connection = $database->getConnection();
$userDAO = new UserDAO($connection);
$resetDAO = new ResetDAO($connection);

include 'mail_controller.php';


 if (isset($_POST['reset-mail'])) {
    $errors = false;
    $email = $_POST['email'];

    if($userDAO->doesUserExist($email) && filter_var($email,FILTER_VALIDATE_EMAIL)) { //Wenn user Existiert und eine gültige Eingabe vorliegt
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

        $resetDAO->deleteTokenByEMail($email);
        $resetDAO->addToken($email, $selector, $hash, $token_expire_date);

        $resetMail_text = 'Moin,<br /><br />';
        $resetMail_text .= 'jemensch (wahrscheinlich du), hat versucht dein Password zur&uuml;ckzusetzen. Um diesen Vorgang abzuschließen, klicke auf folgenden Link:<br /><br />';
        $resetMail_text .= sprintf('<a href="%s">%s</a></p>', $url, $url);
        $resetMail_betreff = 'Anderswelt Planungskosmos Reset Password';
        sendMail($email, $resetMail_betreff, $resetMail_text, 'burns@anderswe.lt', 'Anderswelt Planungskosmos');
        $_SESSION['info_msg'] = 'Bitte check dein E-Mail Postfach';
    }
    else {
        $_SESSION['error_msg'] = 'Bitte gib eine g&uuml;ltige E-Mail Adresse ein.';
    }
}

?>
