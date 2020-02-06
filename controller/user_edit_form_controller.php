<?php
include 'user_controller.php';



if (isset($_POST['edit-user'])) {

    $id = $_POST['id'];
    $vorname = $_POST['vorname'];
    $nachname = $_POST['nachname'];
    $role_id = $_POST['rolle'];

    $user = updateUser($id, $role_id, $vorname, $nachname);
    if($role_id!=0) {
        $message = '<p class="aw-success-message">User '.$vorname.' '.$nachname.' wurde erfolgreich ge&auml;ndert.</p><br />';
    } else {
        $message = '<p class="aw-error-message">Irgendwas ist schief gelaufen</p><br />';
    }
}

?>