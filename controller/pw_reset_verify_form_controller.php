<?php
include 'pw_reset_controller.php';
include 'register_controller.php';
include 'mail_controller.php';
require_once "./controller/lib/crypto/random.php";


$tokenChecked = false;
if(isset($_GET['selector']) && isset($_GET['validator'])) {
    $selector = filter_input(INPUT_GET, 'selector');
    $validator = filter_input(INPUT_GET, 'validator');

    if ( false !== ctype_xdigit( $selector ) && false !== ctype_xdigit( $validator ) ) {
        $tokenChecked = validatedToken($selector, $validator);
    }
}

if(isset($_POST['reset-pw'])) {
    $selector = $_POST['selector'];
    $validator = $_POST['validator'];
    if(validatedToken($selector, $validator)) {
        $email = getMailBySelector($selector);
        $pw_hash = password_hash($_POST['password'], PASSWORD_BCRYPT);     
        $update = updatePWByMail($email, $pw_hash);
        
        deleteTokenByEMail($email);
        
        if ( $update == true ) {
            // New password. New session.
            session_destroy();
            $message = '<p class="aw-success-message">Password erfolgreich geändert.</p><br />';
        }
    }
}

function validatedToken($selector, $validator) {
    // Get tokens
    $results = getToken($selector);
    if ( !empty( $results ) ) {
        $token = $results['token'];
        $calc = hash('sha256', hex2bin($validator));

        // Validate tokens
        if ( hash_equals( $calc, $token ) )  {
            return true;
        }
        else {
            $message = '<p class="aw-error-message">Verifizierung fehlgeschlagen.</p><br />';
            return false;
        }
    }
    else {
        $message = '<p class="aw-error-message">Verifizierung fehlgeschlagen.</p><br />';
        return false;
    }
}

?>