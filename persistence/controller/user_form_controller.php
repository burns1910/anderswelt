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

  $update = $userDao->updateUser($id, $role_id, $vorname, $nachname, $email, $pw_hash);
  if($update!=0) {
      $_SESSION['success_msg'] = 'User '.$vorname.' '.$nachname.' wurde erfolgreich ge&auml;ndert.';
  }
}

if(!empty($_POST['action']) && $_POST['action'] == 'deleteUser') {
  $userDao->deleteUser($_POST['userId']);
}

?>
