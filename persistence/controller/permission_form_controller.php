<?php
include '../../config.php';
include BASE_PATH.'/persistence/dao/PermissionDAO.php';
$connection = $database->getConnection();
$permissionDao = new PermissionDAO($connection);

if(!empty($_POST['action']) && $_POST['action'] == 'listPermissions') {
	$permissionDao->listPermissions();
}

if (isset($_POST['add-permission'])) {

    $name = $_POST['name'];
    $description = $_POST['description'];

    $permission_id = $permissionDao->addPermission($name, $description);
    if($permission_id!=0) {
        $_SESSION['success_msg'] = 'Berechtigung '.$name.' wurde erfolgreich zur Liste hinzugefügt.';
    } else {
        $_SESSION['error_msg'] = 'Irgendwas ist schief gelaufen :/';
    }
}

if (isset($_POST['edit-permission'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $permission_id = $permissionDao->updatePermission($id, $name, $description);
    if($permission_id!=0) {
        $_SESSION['success_msg'] = 'Berechtigung '.$name.' wurde erfolgreich ge&auml;ndert.';
    }
}

if (isset($_GET['id']) && isset($_GET['action'])) {
    if(strcmp($_GET['action'], "delete") == 0) {
        $permissionDao->deletePermission($_GET['id']);
        $_SESSION['success_msg'] = 'Berechtigung wurde erfolgreich gel&ouml;scht.';
    } else {
        $_SESSION['error_msg'] = 'Irgendwas ist schief gelaufen :/';
    }
}

?>
