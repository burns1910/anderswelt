<?php
include '../../config.php';
include BASE_PATH.'/persistence/dao/PermissionDAO.php';
$connection = $database->getConnection();
$permissionDao = new PermissionDAO($connection);

if(!empty($_POST['action']) && $_POST['action'] == 'listPermissions') {
	$permissionDao->listPermissions();
}

if(!empty($_POST['action']) && $_POST['action'] == 'addPermission') {
  $name = $_POST['permName'];
  $description = $_POST['permDescription'];

  $permission_id = $permissionDao->addPermission($name, $description);
  if($permission_id!=0) {
      $_SESSION['success_msg'] = 'Berechtigung '.$name.' wurde erfolgreich zur Liste hinzugefügt.';
  } else {
      $_SESSION['error_msg'] = 'Irgendwas ist schief gelaufen :/';
  }
}

if(!empty($_POST['action']) && $_POST['action'] == 'getPermission') {
	$permObj = $permissionDao->getPermissionByID($_POST['permId']);
	echo json_encode($permObj);
}

if(!empty($_POST['action']) && $_POST['action'] == 'updatePermission') {
  $id = $_POST['permId'];
  $name = $_POST['permName'];
  $description = $_POST['permDescription'];
  $permission_id = $permissionDao->updatePermission($id, $name, $description);
  if($permission_id!=0) {
      $_SESSION['success_msg'] = 'Berechtigung '.$name.' wurde erfolgreich ge&auml;ndert.';
  }
}

if(!empty($_POST['action']) && $_POST['action'] == 'deletePermission') {
    $permission_id = $permissionDao->deletePermission($_POST['permId']);
		if($permission_id!=0) {
				$_SESSION['success_msg'] = 'Berechtigung '.$name.' wurde erfolgreich gel&ouml;scht.';
		}
}

?>
