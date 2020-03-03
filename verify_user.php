<?php
include 'config.php';
include BASE_PATH.'/controller/UserDAO.php';
$connection = $database->getConnection();
$userDAO = new UserDAO($connection);
include BASE_PATH.'/controller/mail_controller.php';
include BASE_PATH.'/header.php';
include BASE_PATH.'/menu.php';

$tokenChecked = false;
if(isset($_GET['id']) && isset($_GET['token'])) {
  $user_id = $_GET['id'];
  $token = $_GET['token'];
  $user = $userDAO->getUserByID($user_id);
  $email = $user->getEmail();
  $verified = $user->isMailVerified();

  if($verified == 0) {
    $timestamp = time();
    $expireDate = strtotime($user->getTokenExpireDate());

    if($timestamp >= $expireDate) {
      echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Der Link zur Verifizierung ist abgelaufen</div>';
        // Neuen Link zusenden
    } elseif ($timestamp < $expireDate) {
      if ( false !== ctype_xdigit( $token )) {
        $tokenChecked = validatedToken($token, $user->getToken());
      }
      if($tokenChecked) {
        $userDAO->verifyEmail($email);
        echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>E-Mail erfolgreich aktiviert</div>';
        echo '<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert">&times;</button>Dein Account muss noch freigeschaltet werden, Burns weiss Bescheid...</div>';

        $activateMail_text = sprintf("Neuer User %s %s hat sich registriert.", $user->getVorname(), $user->getNachname());
        $activateMail_betreff = 'Neue Anmeldung im Planungskosmos';
        sendMail('burns@anderswe.lt', $activateMail_betreff, $activateMail_text, 'burns@anderswe.lt', 'Anderswelt Planungskosmos');
      }
    }
  } else {
    $_SESSION['info_msg'] = 'Deine E-Mail wurde bereits verifiziert, bitte logge dich ein.';
    header("Location: index.php");
  }
}

//TODO: Auslagern
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
include BASE_PATH.'/footer.php';
?>
