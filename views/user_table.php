<?php
include '../config.php';
include BASE_PATH.'/persistence/dao/UserDAO.php';
include BASE_PATH.'/persistence/dao/RoleDAO.php';
include BASE_PATH.'/header.php';
include BASE_PATH.'/menu.php';
$connection = $database->getConnection();
$userDao = new UserDAO($connection);
$roleDao = new RoleDAO($connection);

if(!isset($_SESSION['user_id'])) {
?>

  <p>Willkommen beim Burns-System</p>
  <p>Bitte logge dich ein</p>

<?php
}
else {
  $allUsers = $userDao->getAllUsers();

?>
  <div class="container">
    <?php include '../utils/messages.php' ?>
    <h2>Users</h2>
    <table class="table table-hover">
      <thead class="thead-dark">
        <tr>
          <th>ID</th>
          <th>Vorname</th>
          <th>Nachname</th>
          <th>E-Mail</th>
          <th>Rolle</th>
          <th></th>
          <th></th>
        </tr>
      </thead>
      <tbody>
  <?php
    if(!is_null($allUsers)) {
      foreach ($allUsers as $user) {
        $id = $user->getId();
        $vorname = $user->getVorname();
        $nachname = $user->getNachname();
        $email = $user->getEmail();
        $role_id = $user->getRoleId();
        $rolename = $user->role;
        echo "        <tr>\n";
        echo "          <td>$id</td>\n";
        echo "          <td>$vorname</td>\n";
        echo "          <td>$nachname</td>\n";
        echo "          <td>$email</td>\n";
        echo "          <td>$rolename</td>\n";
        echo '          <td><a href="user_edit.php?id='.$id.'">bearbeiten</a></td>'."\n";
        echo '          <td><a href="user_edit.php?id='.$id.'">l&ouml;schen</a></td>'."\n";
        echo "        </tr>\n";
      }
    }
    echo "      </tbody>\n";
    echo "    </table>\n";
    echo "  </div>\n";
}
include BASE_PATH.'/footer.php';
?>
