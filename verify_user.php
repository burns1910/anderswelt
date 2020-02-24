<?php
include 'config.php';
include './controller/user_controller.php';
include './controller/mail_controller.php';
include 'header.php';
include 'menu.php';

$tokenChecked = false;
if(isset($_GET['id']) && isset($_GET['token'])) {
  $user_id = $_GET['id'];
  $token = $_GET['token'];
  $user = getUserByID($user_id);
  $email = $user['email'];
  $verified = $user['mail_verified'];

  if($verified == 0) {
    $timestamp = time();
    $expireDate = strtotime($user['token_expire_date']);

    if($timestamp >= $expireDate) {
      echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Der Link zur Verifizierung ist abgelaufen</div>';
        // Neuen Link zusenden
    } elseif ($timestamp < $expireDate) {
      if ( false !== ctype_xdigit( $token )) {
        $tokenChecked = validatedToken($token, $user['token']);
      }
      if($tokenChecked) {
        verifyEmail($email);
        echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>E-Mail erfolgreich aktiviert</div>';
        echo '<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert">&times;</button>Dein Account muss noch freigeschaltet werden, Burns weiss Bescheid...</div>';

        $activateMail_text = sprintf("Neuer User %s %s hat sich registriert.", $user['vorname'], $user['nachname']);
        $activateMail_betreff = 'Neue Anmeldung im Planungskosmos';
        sendMail('burns@anderswe.lt', $activateMail_betreff, $activateMail_text, 'burns@anderswe.lt', 'Anderswelt Planungskosmos');
      }
    }
  } else {
    $_SESSION['info_msg'] = 'Deine E-Mail wurde bereits verifiziert, bitte logge dich ein.';
    header("Location: index.php");
  }
}

function validatedToken($input, $token) {
  $calc = hash('sha256', hex2bin($input));

  if ( hash_equals($calc, $token ) )  {
    return true;
  }
  else {
    $_SESSION['error_msg'] = 'Verifizierung fehlgeschlagen.';
    return false;
  }
}
include 'messages.php';
include 'footer.php';
?>
