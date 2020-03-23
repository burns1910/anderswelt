<?php
include '../../config.php';
include BASE_PATH.'/persistence/dao/UserDAO.php';
$connection = $database->getConnection();
$userDao = new UserDAO($connection);

if(!empty($_POST['action']) && $_POST['action'] == 'listUsers') {
	$userDao->listUsers();
}

if(!empty($_POST['action']) && $_POST['action'] == 'getUser') {
	$userObj = $userDao->getUserById($_POST['userId']);
  echo json_encode($userObj);
}

if(!empty($_POST['action']) && $_POST['action'] == 'updateUser') {
  $id = $_POST['userId'];
  $vorname = $_POST['userVorname'];
  $nachname = $_POST['userNachname'];
  $email = $_POST['userEmail'];
  $role_id = $_POST['userRole'];
  $user = $userDao->getUserById($id);
  $pw_hash = $user->getPW();
  $updated = $userDao->updateUser($id, $role_id, $vorname, $nachname, $email, $pw_hash);
	switch ($updated) {
		case '1':
			$message = array('msgText'=>'User '.$vorname.' '.$nachname.' wurde erfolgreich ge&auml;ndert.', 'msgType'=>'alert-success');
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

if(!empty($_POST['action']) && $_POST['action'] == 'deleteUser') {
	$user_id = $_POST['userId'];
	$deleted = $userDao->deleteUser($user_id);
	if($deleted>0) {
		$message = array('msgText'=>'User wurde erfolgreich gelöscht.', 'msgType'=>'alert-success');
	} else {
		$message = array('msgText'=>'Irgendwas ist schief gegangen :/', 'msgType'=>'alert-danger');
	}
}

?>
