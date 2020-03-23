<?php
include '../config.php';
include BASE_PATH.'/header.php';
include BASE_PATH.'/persistence/dao/RoleDAO.php';
?>
    <script src="/anderswelt/persistence/ajax/users.js"></script>
    <title>User</title>
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
  $roleDao = new RoleDAO($connection);
  $allRoles = $roleDao->getAllRoles();
?>
<div class="container">
  <h2>User</h2>
  <table id="userTable" class="table table-hover table-bordered">
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
  </table>

<div class="modal fade" id="userModal">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Rolle anpassen</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form method="post" action="" id="userForm" class="needs-validation" novalidate>
            <div class="form-group">
                <label for="userVorname">Vorname</label>
                <input type="text" class="form-control" id="userVorname" name="userVorname" readonly/>
            </div>
            <div class="form-group">
                <label for="userNachnname">Nachname</label>
                <input type="text" class="form-control" id="userNachname" name="userNachname" readonly/>
            </div>
            <div class="form-group">
                <label for="userEmail">Email</label>
                <input type="text" class="form-control" id="userEmail" name="userEmail" readonly/>
            </div>
            <div class="form-group">
              <label for="rolePermissions">Rolle</label>
              <select class="form-control" id="userRole" name="userRole">
                <?php
                foreach ($allRoles as $r) {
                  $r_id = $r->getId();
                  $r_name = $r->getName();
                  echo '<option value="'.$r_id.'">'.$r_name.'</option>';
                }
                ?>
              </select>
            </div>
            <input type="hidden" name="userId" id="userId" />
            <input type="hidden" name="action" id="action" />
            <input type="submit" name="save" id="save" class="btn btn-info" value="Save" />
            <button type="button" class="btn btn-default" data-dismiss="modal">abbrechen</button>
        </form>
      </div>
    </div>
  </div>
</div>
</div>

<?php
}
include BASE_PATH.'/footer.php';
?>
