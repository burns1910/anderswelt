<?php
include '../config.php';
include BASE_PATH.'/header.php';
include BASE_PATH.'/menu.php';

if(!isset($_SESSION['user_id'])) {
?>

  <p>Willkommen beim Burns-System</p>
  <p>Bitte logge dich ein</p>

<?php
}
else {

?>
  <div class="container">
    <?php include '../utils/messages.php' ?>
    <h2>Berechtigungen</h2>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">+ hinzuf&uuml;gen</button>
    <table id="permTable" class="table table-hover display dataTable">
      <thead class="thead-dark">
        <tr>
          <th>ID</th>
          <th>Name</th>
        </tr>
      </thead>
    </table>

    <!-- Script -->
    <script>
    $(document).ready(function(){
        $('#permTable').DataTable({
            'language': {
              "lengthMenu": "_MENU_ Eintr&auml;ge pro Seite",
              "emptyTable": "Noch keine Eintr&auml;ge gespeichert",
              "zeroRecords": "Nix gefunden, sorry",
              "search": "Suchen:",
              "info": "Seite _PAGE_ von _PAGES_",
              "infoEmpty": "No records available",
              "infoFiltered": "(filtered from _MAX_ total records)",
              "paginate": {
                  "first":      "Start",
                  "last":       "Ende",
                  "next":       "Vor",
                  "previous":   "Zur&uuml;ck"
              }
            },
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            'ajax': {
                'url':'../persistence/controller/permission_form_controller.php',
                'data' : {action:'listPermissions'}
            },
            'columns': [
                { data: 'id' },
                { data: 'name' },
            ]
        });
    });
    </script>

<div class="modal fade" id="addModal">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Neue Berechtigung</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form method="post" action="" class="needs-validation" novalidate>
            <div class="form-group">
                <label for="addName">Name</label>
                <input type="text" class="form-control" id="addName" name="name" required />
            </div>
            <div class="form-group">
                <label for="addDescription">Beschreibung</label>
                <textarea class="form-control" id="addDescription" name="description" rows="5" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary" name="add-permission" value="add-permission">Hinzuf&uuml;gen</button>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="editModal">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Berechtigung bearbeiten</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form method="post" action="" class="needs-validation" novalidate>
            <div class="form-group">
                <label for="editName">Name</label>
                <input type="text" class="form-control" id="editName" name="name" required />
            </div>
            <div class="form-group">
                <label for="editDescription">Beschreibung</label>
                <textarea class="form-control" id="editDescription" name="description" rows="5" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary" name="edit-permission" value="edit-permission">Hinzuf&uuml;gen</button>
        </form>
      </div>
    </div>
  </div>
</div>

<?php
}
include BASE_PATH.'/footer.php';
?>
