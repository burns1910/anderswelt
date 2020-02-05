<?php
include 'role_controller.php';

if (isset($_POST['add-role'])) {

    $name = $_POST['name'];
    $description = $_POST['description'];

    $role_id = addRole($name, $description);
    if($role_id!=0) {
        $message = '<p class="aw-success-message">Rolle '.$name.' wurde erfolgreich zur Liste hinzugefügt.</p><br />';
    } else {
        $message = '<p class="aw-error-message">Irgendwas ist schief gelaufen</p><br />';
    }
}

if (isset($_POST['edit-role'])) {

    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];

    $role_id = updateRole($id, $name, $description);
    if($role_id!=0) {
        $message = '<p class="aw-success-message">Rolle '.$name.' wurde erfolgreich ge&auml;ndert.</p><br />';
    } else {
        $message = '<p class="aw-error-message">Irgendwas ist schief gelaufen</p><br />';
    }
}

if (isset($_GET['id']) && isset($_GET['action'])) {
    if(strcmp($_GET['action'], "delete") == 0) {
        deleteRole($_GET['id']);
        $message = '<p class="aw-success-message">Rolle wurde erfolgreich gel&ouml;scht.</p><br />';
    } else {
        $message = '<p class="aw-error-message">Irgendwas ist schief gelaufen</p><br />';
    }
}

?>