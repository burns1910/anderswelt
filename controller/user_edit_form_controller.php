<?php
include 'user_controller.php';



if (isset($_POST['edit-user'])) {

    $id = $_POST['id'];
    $vorname = $_POST['vorname'];
    $nachname = $_POST['nachname'];
    $role_id = $_POST['rolle'];

    $user = updateUser($id, $role_id, $vorname, $nachname);
    if($role_id!=0) {
        $_SESSION['success_msg'] = 'User '.$vorname.' '.$nachname.' wurde erfolgreich ge&auml;ndert.';
    } else {
        $_SESSION['error_msg'] = 'Irgendwas ist schief gelaufen :/';
    }
}

?>
