<?php
include '../config.php';
include '../controller/user_controller.php';
include '../header.php';
include '../menu.php';

if(!$logged_in_admin) {
?>

  <p>Willkommen beim Burns-System</p>
  <p>Bitte logge dich ein</p>

<?php
}
else {
?>
  <div class="container">
    <h2>User</h2>
    <table class="table">
      <thead class="thead-primary">
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
include '../footer.php';
?>
