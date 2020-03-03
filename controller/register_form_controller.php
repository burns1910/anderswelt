<?php
include 'UserDAO.php';
$connection = $database->getConnection();
$dao = new UserDAO($connection);

include 'mail_controller.php';

if (isset($_POST['register'])) {

  $vorname = $_POST['vorname'];
  $nachname = $_POST['nachname'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $password2 = $_POST['password2'];
  $token = random_bytes(50);
  $token_hash = hash('sha256', $token);
  $pw_hash = password_hash($password, PASSWORD_BCRYPT);
  $timestamp = time()+60*60*24; //Aktueller Timestamp +24 Std
  $token_expire_date = date('Y-m-d H:i:s',$timestamp);

  $errors = false;

  if (!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error_msg'] = 'Bitte gib eine g&uuml;ltige E-Mail Adresse ein.';
    $errors = true;
  } elseif ($password != $password2) {
    $_SESSION['error_msg'] = 'Die eingegebenen Passw&ouml;rter stimmen nicht überein.';
    $errors = true;
  }

  if($dao->doesUserExist($email)) {
    $_SESSION['error_msg'] = 'Diese E-Mail wurde bereits registriert.';
    $errors = true;
  }

  if(!$errors) {
      $user_id = $dao->addUser($vorname, $nachname, $email, $token_hash, $pw_hash, $token_expire_date);
      if($user_id!=0) {
      $url = sprintf('%sverify_user.php?%s', "https://planung.anderswe.lt/", http_build_query([
        'id' => $user_id,
        'token' => bin2hex($token)
      ]));
      $_SESSION['success_msg'] = 'User erfolgreich registiert.';
      $_SESSION['info_msg'] = 'Zur Verifizierung deines Accounts wurde dir eine E-Mail zugesendet.';

      $verifyMail_text = 'Moin '.$vorname.',<br /><br />';
      $verifyMail_text .= 'schön, dass du bei uns mitplanen möchtest. Bitte bestätige dafür zunächst deine E-Mail Adresse, indem du auf folgenden Link klickst:<br /><br />';
      $verifyMail_text .= sprintf('<a href="%s">%s</a></p>', $url, $url);
      $verifyMail_betreff = 'Anderswelt Planungskosmos Email Verifikation';
      sendMail($email, $verifyMail_betreff, $verifyMail_text, 'burns@anderswe.lt', 'Anderswelt Planungskosmos');
    } else {
      $_SESSION['error_msg'] = 'User konnte nicht angelegt werden.';
    }
  }

}
?>
