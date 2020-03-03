<?php
include BASE_PATH.'/controller/UserDAO.php';

$connection = $database->getConnection();
$dao = new UserDAO($connection);

if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = $dao->getUserByEmail($email);

    if (!$user) {
        $_SESSION['error_msg'] = 'E-Mail Password Kombination konnte nicht verifiziert werden!';
    } else {
        if ((password_verify($password, $user->getPW())) && ($user->isActive() == 1)) {
            $_SESSION['user_id'] = $user->getId();
            $_SESSION['user_vorname'] = $user->getVorname();
            $_SESSION['user_nachname'] = $user->getNachname();
            $_SESSION['user_email'] = $user->getEmail();
            header("Location: index.php");
        } else {
            $_SESSION['error_msg'] = 'E-Mail Password Kombination konnte nicht verifiziert werden!';
        }
    }
}
?>
