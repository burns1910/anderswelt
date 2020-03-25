<?php
include '../config.php';
include BASE_PATH.'/header.php';
include BASE_PATH.'/persistence/dao/PermissionDAO.php';
?>
    <script src="/anderswelt/persistence/ajax/roles.js"></script>
    <title>Rollen</title>
<?php
include BASE_PATH.'/menu.php';

if(!isset($_SESSION['user_id'])) {
?>

  <p>Willkommen beim Burns-System</p>
  <p>Bitte logge dich ein</p>

<?php
}
else {
  $connection = $database->getConnection();
  $permissionDao = new PermissionDAO($connection);
  $allPermissions = $permissionDao->getAllPermissions();
?>
    <div class="container-fluid mt-4">
      <div class="row">
        <div class="col-sm-2 sidebar-offcanvas" id="sidebar" role="navigation">
          <nav class="sidebar-nav">
            <ul class="nav flex-column">
              <li class="nav-item"><a class="nav-link" href="users.php"><i class="far fa-user"></i> User</a></li>
              <li class="nav-item"><a class="nav-link" href="roles.php"><i class="fas fa-users"></i> Rollen</a></li>
              <li class="nav-item"><a class="nav-link" href="permissions.php"><i class="far fa-id-card"></i> Berechtigungen</a></li>
            </ul>
          </nav>
        </div>
        <div class="col-sm-10">
          <h2>Rollen</h2>
          <button type="button" name="add" id="addRole" class="btn btn-primary">+ hinzuf&uuml;gen</button>
          <hr>
          <table id="roleTable" class="table table-hover table-bordered">
            <thead class="thead-dark">
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th></th>
                <th></th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>

    <div class="modal fade" id="roleModal">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Rolle anpassen</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <form method="post" action="" id="roleForm" class="needs-validation" novalidate>
                <div class="form-group">
                    <label for="roleName">Name</label>
                    <input type="text" class="form-control" id="roleName" name="roleName" required />
                </div>
                <div class="form-group">
                    <label for="roleDescription">Beschreibung</label>
                    <textarea class="form-control" id="roleDescription" name="roleDescription" rows="5" required></textarea>
                </div>
                <div class="form-group">
                  <label for="rolePermissions">Berechtigungen</label>
                  <select multiple class="form-control" id="rolePermissions" name="rolePermissions[]">
                    <?php
                    foreach ($allPermissions as $p) {
                      $p_id = $p->getId();
                      $p_name = $p->getName();
                      echo '<option value="'.$p_id.'">'.$p_name.'</option>';
                    }
                    ?>
                  </select>
                </div>
                <input type="hidden" name="roleId" id="roleId" />
                <input type="hidden" name="action" id="action" />
                <input type="submit" name="save" id="save" class="btn btn-info" value="Save" />
                <button type="button" class="btn btn-default" data-dismiss="modal">abbrechen</button>
            </form>
          </div>
        </div>
      </div>
    </div>

<?php
}
include BASE_PATH.'/footer.php';
?>
