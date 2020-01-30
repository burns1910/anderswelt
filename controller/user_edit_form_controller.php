<?php
include 'user_controller.php';

$user_id = 0;
$role_id = NULL;
$username = "";
$email = "";
$password = "";
$passwordConf = "";
$users = array();
$errors = array();

if (isset($_POST['update_user'])) { // if user clicked update_user button ...
    $user_id = $_POST['user_id'];
    updateUser($user_id);
}
// ACTION: Save User
if (isset($_POST['save_user'])) {  // if user clicked save_user button ...
    saveUser();
}
// ACTION: fetch user for editting
if (isset($_GET["edit_user"])) {
    $user_id = $_GET["edit_user"];
    editUser($user_id);
}
// ACTION: Delete user
if (isset($_GET['delete_user'])) {
    $user_id = $_GET['delete_user'];
    deleteUser($user_id);
}

?>