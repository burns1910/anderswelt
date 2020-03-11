<?php
include BASE_PATH.'/persistence/dao/RoleDAO.php';
$connection = $database->getConnection();
$roleDao = new RoleDAO($connection);

if (isset($_POST['listRoles'])) {
  getAllRolesAsTable();
}

if (isset($_POST['add-role'])) {

    $name = $_POST['name'];
    $description = $_POST['description'];

    $role_id = addRole($name, $description);
    if($role_id!=0) {
        $_SESSION['success_msg'] = 'Rolle '.$name.' wurde erfolgreich zur Liste hinzugefügt.';
    } else {
        $_SESSION['error_msg'] = 'Irgendwas ist schief gelaufen :/';
    }
}

if (isset($_POST['edit-role'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];

    $role_id = $roleDao->updateRole($id, $name, $description);
    if($role_id!=0) {
        $_SESSION['success_msg'] = 'Rolle '.$name.' wurde erfolgreich ge&auml;ndert.';
    } else {
        $_SESSION['error_msg'] = 'Irgendwas ist schief gelaufen :/';
    }
}

if (isset($_GET['id']) && isset($_GET['action'])) {
    if(strcmp($_GET['action'], "delete") == 0) {
        deleteRole($_GET['id']);
        $_SESSION['success_msg'] = 'Rolle wurde erfolgreich gel&ouml;scht.';
    } else {
        $_SESSION['error_msg'] = 'Irgendwas ist schief gelaufen :/';
    }
}

?>
