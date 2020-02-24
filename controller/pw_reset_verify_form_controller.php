<?php
include 'pw_reset_controller.php';
include 'user_controller.php';
include 'mail_controller.php';
#require_once "./controller/lib/crypto/random.php";


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
    $email = getMailBySelector($selector);
    $password = $_POST['password'];
    $password2 = $_POST['password2'];
    $pw_equal = strcmp($password, $password2);
    if($pw_equal==0) {
      if(validatedToken($selector, $validator) && !tokenExpired($email)) {
          $pw_hash = password_hash($_POST['password'], PASSWORD_BCRYPT);
          $update = updatePWByMail($email, $pw_hash);

          deleteTokenByEMail($email);

          if ( $update == true ) {
              // New password. New session.
              session_destroy();
              $_SESSION['success_msg'] = 'Password erfolgreich ge&auml;ndert.';
          }
      }
    } else {
      $_SESSION['error_msg'] = 'Die Passw&ouml;rter stimmen nicht &uuml;berein.';
    }
}

function tokenExpired($email) {
    $expired = true;
    $expireDate = getTokenExpireDateByEmail($email);
    $timestamp = time();

    if($timestamp >= $expireDate) {
        $_SESSION['error_msg'] = 'Der Link zur Verifizierung ist abgelaufen.';
    } elseif ($timestamp < $expireDate) {
        $expired = false;
    }
    return $expired;
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
            $_SESSION['error_msg'] = 'Verifizierung fehlgeschlagen.';
            return false;
        }
    }
    else {
        $_SESSION['error_msg'] = 'Verifizierung fehlgeschlagen.';
        return false;
    }
}

?>
