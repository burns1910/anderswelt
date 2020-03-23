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
  }
	else {
		$message = array('msgText'=>'Irgendwas ist schief gegangen :/', 'msgType'=>'alert-danger');
	}
	echo json_encode($message);
}

if(!empty($_POST['action']) && $_POST['action'] == 'deleteRole') {
  $role_id = $_POST['roleId'];
  $permissions = $roleDao->getPermissionIDsFromRole($role_id);
  foreach ($permissions as $permId) {
    $roleDao->removePermission($role_id, $permId);
  }
  $deleted = $roleDao->deleteRole($role_id);
	if($deleted>0) {
		$message = array('msgText'=>'Rolle wurde erfolgreich gelöscht.', 'msgType'=>'alert-success');
	} else {
		$message = array('msgText'=>'Irgendwas ist schief gegangen :/', 'msgType'=>'alert-danger');
	}
	echo json_encode($message);
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
	$permissions = array();
	if(isset($_POST['rolePermissions']) && !empty($_POST['rolePermissions'])) {
		if(array_key_exists('rolePermissions', $_POST)) {
			$permissions = $_POST['rolePermissions'];
		}
	}
	$roleUpdated = $roleDao->updateRole($id, $name, $description);
	$permissionUpdated = $roleDao->updatePermissions($id, $permissions);
	$updated = ($roleUpdated!=-1 ? max($roleUpdated, $permissionUpdated) : -1);
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
