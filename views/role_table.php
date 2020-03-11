<?php
include '../config.php';
include BASE_PATH.'/persistence/dao/RoleDAO.php';
include BASE_PATH.'/header.php';
include BASE_PATH.'/menu.php';
$connection = $database->getConnection();
$roleDao = new RoleDAO($connection);

if(!isset($_SESSION['user_id'])) {
?>

  <p>Willkommen beim Burns-System</p>
  <p>Bitte logge dich ein</p>

<?php
}
else {
  $allRoles = $roleDao->getAllRoles();

?>
  <div class="container">
    <?php include '../utils/messages.php' ?>
    <h2>Users</h2>
    <table class="table table-hover">
      <thead class="thead-dark">
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th></th>
          <th></th>
        </tr>
      </thead>
      <tbody>
  <?php
    if(!is_null($allRoles)) {
      foreach ($allRoles as $role) {
        $id = $role->getId();
        $name = $role->getName();
        echo "        <tr>\n";
        echo "          <td>$id</td>\n";
        echo "          <td>$name</td>\n";
        echo '          <td><a href="role_edit.php?id='.$id.'">bearbeiten</a></td>'."\n";
        echo '          <td><a href="role_edit.php?id='.$id.'">l&ouml;schen</a></td>'."\n";
        echo "        </tr>\n";
      }
    }
    echo "      </tbody>\n";
    echo "    </table>\n";
    echo "  </div>\n";
}
include BASE_PATH.'/footer.php';
?>
