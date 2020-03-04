<?php
include BASE_PATH.'/persistence/controller/UserDAO.php';
$connection = $database->getConnection();
$dao = new UserDAO($connection);

if (isset($_POST['edit-user'])) {

    $id = $_POST['id'];
    $vorname = $_POST['vorname'];
    $nachname = $_POST['nachname'];
    $role_id = $_POST['rolle'];

    $user = $dao->updateUser($id, $role_id, $vorname, $nachname);
    if($user!=0) {
        $_SESSION['success_msg'] = 'User '.$vorname.' '.$nachname.' wurde erfolgreich ge&auml;ndert.';
    } else {
        $_SESSION['error_msg'] = 'Irgendwas ist schief gelaufen :/';
    }
}

?>
