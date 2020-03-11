<?php
include BASE_PATH.'/persistence/dao/UserDAO.php';
$connection = $database->getConnection();
$userDao = new UserDAO($connection);

if (isset($_POST['edit-user'])) {
    $id = $_POST['id'];
    $vorname = $_POST['vorname'];
    $nachname = $_POST['nachname'];
    $role_id = $_POST['rolle'];
    $user = $userDao->getUserById($id);
    $email = $user->getEmail();
    $pw_hash = $user->getPW();

    $update = $userDao->updateUser($id, $role_id, $vorname, $nachname, $email, $pw_hash);
    if($update!=0) {
        $_SESSION['success_msg'] = 'User '.$vorname.' '.$nachname.' wurde erfolgreich ge&auml;ndert.';
    } else {
        $_SESSION['error_msg'] = 'Irgendwas ist schief gelaufen :/';
    }
}

?>
