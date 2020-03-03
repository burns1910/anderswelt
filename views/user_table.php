<?php
include '../config.php';
include BASE_PATH.'/controller/UserDAO.php';
include BASE_PATH.'/header.php';
include BASE_PATH.'/menu.php';
$connection = $database->getConnection();
$dao = new UserDAO($connection);

if(!isset($_SESSION['user_id'])) {
?>

  <p>Willkommen beim Burns-System</p>
  <p>Bitte logge dich ein</p>

<?php
}
else {
?>
  <div class="container">
    <?php include '../messages.php' ?>
    <h2>Users</h2>
    <table class="table table-hover">
      <thead class="thead-dark">
        <tr>
          <th>ID</th>
          <th>Vorname</th>
          <th>Nachname</th>
          <th>E-Mail</th>
          <th>Rolle</th>
        </tr>
      </thead>
      <tbody>
  <?php
    $allUsers = getAllUsers();
    if(!is_null($allUsers)) {
      foreach ($allUsers as $user) {
        $id = $user['id'];
        echo "        <tr>\n";
        foreach ($user as $key => $value) {
          /*
          if($key == 'id') {
            continue;
          } */
          echo "          <td>$value</td>\n";
        }
        echo '            <td><a href="user_edit.php?id='.$id.'">bearbeiten</a></td>'."\n";
        echo "        </tr>\n";
      }
    }
    echo "      </tbody>\n";
    echo "    </table>\n";
    echo "  </div>\n";
}
include BASE_PATH.'/footer.php';
?>
