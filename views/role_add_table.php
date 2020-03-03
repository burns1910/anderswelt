<?php
include '../config.php';
include '../controller/role_form_controller.php';
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
    <?php include '../messages.php' ?>
    <h2>Roles</h2>
    <button type="button" name="add" id="addRole" class="btn btn-success btn-xs">Rolle hinzuf&uuml;gen</button>
    <table id="roleList" class="table table-hover">
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
  <?php
/*    $alleRollen = getAllRoles();
    if(!is_null($alleRollen)) {
      foreach ($alleRollen as $rolle) {
        $id = $rolle['id'];
        echo "        <tr>\n";
        foreach ($rolle as $key => $value) {
          if($key == 'description' ) {
            continue;
          }
          echo '          <td title="'.$rolle['description'].'">'.$value.'</td>'."\n";
        }
        echo '            <td><a href="#" data-toggle="modal" data-target="#modalEdit">bearbeiten</a></td>'."\n";
        echo '            <td><a href="role_edit.php?id='.$id.'&action=delete">l&ouml;schen</a></td>'."\n";
        echo "        </tr>\n";
      }
    }
    echo "      </tbody>\n";
    echo "    </table>\n";
    echo "  </div>\n";
*/
?>

    <div class="modal fade" id="modalAdd">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Neue Rolle</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <form method="post" action="" class="needs-validation" novalidate>
              <div class="form-group">
                <label for="inputName">Name</label>
                <input type="text" class="form-control" id="inputName" name="name" pattern="[a-zA-Z0-9]+" required />
              </div>
              <div class="form-group">
                <label for="inputDescription">Beschreibung</label>
                <textarea class="form-control" rows="5"></textarea>
              </div>
              <button type="submit" class="btn btn-primary" name="add-role" value="add-role">Hinzuf&uuml;gen</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">Abbrechen</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="roleModal">
      <div class="modal-dialog modal-dialog-centered">
        <form method="post" action="" class="needs-validation" id="roleForm" novalidate>
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Bearbeiten</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label for="inputName">Name</label>
                <input type="text" class="form-control" id="inputName" name="name" pattern="[a-zA-Z0-9]+" required />
              </div>
              <div class="form-group">
                <label for="inputDescription">Beschreibung</label>
                <textarea class="form-control" rows="5"></textarea>
              </div>
            </div>
            <div class="modal-footer">
              <input type="hidden" name="roleId" id="roleId" />
              <input type="hidden" name="action" id="action" value="" />
              <input type="submit" class="btn btn-primary" name="save" id="save" value="save" />
              <button type="button" class="btn btn-default" data-dismiss="modal">Abbrechen</button>
            </div>
          </div>
        </form>
      </div>
    </div>

<?php
getAllRolesAsTable();
}
include '../footer.php';
?>
