<?php
include BASE_PATH.'/dao/ResetDAO.php';
include BASE_PATH.'/dao/UserDAO.php';
$connection = $database->getConnection();
$userDAO = new UserDAO($connection);
$resetDAO = new ResetDAO($connection);

include 'mail_controller.php';

$tokenChecked = false;

if(isset($_GET['selector']) && isset($_GET['validator'])) {
    $selector = filter_input(INPUT_GET, 'selector');
    $validator = filter_input(INPUT_GET, 'validator');

    if ( false !== ctype_xdigit( $selector ) && false !== ctype_xdigit( $validator ) ) {
        $tokenChecked = $resetDAO->isTokenValid($selector, $validator);
    }
}

if(isset($_POST['reset-pw'])) {
    $selector = $_POST['selector'];
    $validator = $_POST['validator'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];
    $pw_equal = strcmp($password, $password2);
    if($pw_equal==0) {
      $resetToken = $resetDAO->getTokenBySelector($selector);
      $email = $resetToken->getEmail();
      if($resetDAO->isTokenValid($selector, $validator) && !$resetDAO->isTokenExpired($resetToken)) {
        $pw_hash = password_hash($password, PASSWORD_BCRYPT);
        $update = $userDAO->updatePWByMail($email, $pw_hash);
        if ($update==true) {
          $resetDAO->deleteTokenByEMail($email);
          // New password. New session.
          session_destroy();
          $_SESSION['success_msg'] = 'Password erfolgreich ge&auml;ndert.';
        }
      }
    } else {
      $_SESSION['error_msg'] = 'Die Passw&ouml;rter stimmen nicht &uuml;berein.';
    }
}

?>
