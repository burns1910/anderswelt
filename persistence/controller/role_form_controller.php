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
  if($role_id!=0) {
    foreach ($_POST['rolePermissions'] as $permId) {
      $roleDao->addPermission($role_id, $permId);
    }
  }
}

if(!empty($_POST['action']) && $_POST['action'] == 'deleteRole') {
  $role_id = $_POST['roleId'];
  $permissions = $roleDao->getPermissionIDsFromRole($role_id);

  foreach ($permissions as $permId) {
    $roleDao->removePermission($role_id, $permId);
  }

  $roleDao->deleteRole($role_id);
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
	$role_id = $roleDao->updateRole($id, $name, $description);
	if(isset($_POST['rolePermissions']) && !empty($_POST['rolePermissions'])) {
		if ( array_key_exists('rolePermissions', $_POST)) {
			$permissions = $_POST['rolePermissions'];
		}
	} else {
		$permissions = array();
	}
	$roleDao->updatePermissions($id, $permissions);
	if($role_id!=0) {
			$_SESSION['success_msg'] = 'Rolle '.$name.' wurde erfolgreich ge&auml;ndert.';
	}
}

?>
