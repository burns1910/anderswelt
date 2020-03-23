<?php
include '../../config.php';
include BASE_PATH.'/persistence/dao/RoleDAO.php';
$connection = $database->getConnection();
$roleDao = new RoleDAO($connection);

if(!empty($_POST['action']) && $_POST['action'] == 'listRoles') {
	$roleDao->listRoles();
}

if(!empty($_POST['action']) && $_POST['action'] == 'addRole') {
  $name = $_POST['roleName'];
  $description = $_POST['roleDescription'];

  $role_id = $roleDao->addRole($name, $description);
  if($role_id>0) {
		if(isset($_POST['rolePermissions']) && !empty($_POST['rolePermissions'])) {
			if ( array_key_exists('rolePermissions', $_POST)) {
		    foreach ($_POST['rolePermissions'] as $permId) {
		      $roleDao->addPermission($role_id, $permId);
		    }
			}
		}
		$message = array('msgText'=>'Rolle '.$name.' wurde erfolgreich hinzugefügt.', 'msgType'=>'alert-success');
		echo json_encode($message);
  }
	else {
		$message = array('msgText'=>'Irgendwas ist schief gegangen :/', 'msgType'=>'alert-danger');
		echo json_encode($message);
	}
}

if(!empty($_POST['action']) && $_POST['action'] == 'deleteRole') {
  $role_id = $_POST['roleId'];
  $permissions = $roleDao->getPermissionIDsFromRole($role_id);
  foreach ($permissions as $permId) {
    $roleDao->removePermission($role_id, $permId);
  }
  $role_id = $roleDao->deleteRole($role_id);
	if($role_id>0) {
		$message = array('msgText'=>'Rolle wurde erfolgreich gelöscht.', 'msgType'=>'alert-success');
		echo json_encode($message);
	} else {
		$message = array('msgText'=>'Irgendwas ist schief gegangen :/', 'msgType'=>'alert-danger');
		echo json_encode($message);
	}
}

if(!empty($_POST['action']) && $_POST['action'] == 'getRole') {
	$roleObj = $roleDao->getRoleByID($_POST['roleId']);
	$permissions = $roleDao->getPermissionIDsFromRole($_POST['roleId']);
	foreach ($permissions as $permission) {
		$roleObj->setPermission($permission);
	}
	echo json_encode($roleObj);
}

if(!empty($_POST['action']) && $_POST['action'] == 'updateRole') {
	$id = $_POST['roleId'];
	$name = $_POST['roleName'];
	$description = $_POST['roleDescription'];
	$roleUpdated = 0;
	$permissionUpdated = 0;
	$roleUpdated = $roleDao->updateRole($id, $name, $description);
	if(isset($_POST['rolePermissions']) && !empty($_POST['rolePermissions'])) {
		if (array_key_exists('rolePermissions', $_POST)) {
			$permissions = $_POST['rolePermissions'];
			$permissionUpdated = $roleDao->updatePermissions($id, $permissions);
		}
	}
	if($roleUpdated!=-1)
		$updated = max($roleUpdated, $permissionUpdated);
	else
			$updated = -1;
	switch ($updated) {
		case '1':
			$message = array('msgText'=>'Rolle '.$name.' wurde erfolgreich geändert.', 'msgType'=>'alert-success');
			break;
		case '0':
			$message = array('msgText'=>'Keine Änderungen vorgenommen', 'msgType'=>'alert-info');
			break;
		default:
			$message = array('msgText'=>'Irgendwas ist schief gegangen :/', 'msgType'=>'alert-danger');
			break;
	}
	echo json_encode($message);
}

?>
